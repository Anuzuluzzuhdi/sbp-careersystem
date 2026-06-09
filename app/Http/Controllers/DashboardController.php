<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Support\RecommendationEngine;
use App\Support\SkillCategoryGrouper;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $careers = DB::table('careers')->orderBy('career_name')->get();
        $educations = DB::table('educations')->orderBy('education_level')->get();
        $skills = DB::table('skills')->orderBy('skill_name')->get();
        $skillGroups = SkillCategoryGrouper::group($skills);
        $specializations = DB::table('specializations')->orderBy('specialization_name')->get();
        $certifications = DB::table('certifications')->orderBy('certification_name')->get();

        $educationId = $request->query('education_id');
        $skillIds = collect($request->query('skill_ids', []))->filter()->values()->all();
        $specializationIds = collect($request->query('specialization_ids', []))->filter()->values()->all();
        $certificationId = $request->query('certification_id');

        $criteria = [
            'education_id' => $educationId,
            'skill_ids' => $skillIds,
            'specialization_ids' => $specializationIds,
            'certification_id' => $certificationId,
        ];

        $hasCriteria = (bool) array_filter($criteria);
        $searchResults = collect();

        if ($hasCriteria) {
            $ranked = collect($this->resolveRankedCareers($criteria));

            if ($ranked->isNotEmpty()) {
                $ids = $ranked->pluck('career_id')->all();
                $scoreMap = $ranked->pluck('score', 'career_id')->all();
                $idList = implode(',', array_map('intval', $ids));

                $searchResults = Career::whereIn('career_id', $ids)
                    ->orderByRaw("FIELD(career_id, $idList)")
                    ->get()
                    ->map(function ($career) use ($scoreMap) {
                        $career->score = $scoreMap[$career->career_id] ?? 0;

                        return $career;
                    });
            }
        }

        $sidebarCareers = $searchResults->isNotEmpty()
            ? $searchResults
            : Career::orderBy('career_name')->limit(7)->get();

        $selectedCareerId = (int) $request->query(
            'career_id',
            $sidebarCareers->first()?->career_id ?? 0
        );

        if (! $sidebarCareers->contains('career_id', $selectedCareerId)) {
            $selectedCareerId = $sidebarCareers->first()?->career_id ?? 0;
        }

        $careerProfiles = $sidebarCareers->map(function ($career) use ($searchResults) {
            $score = $searchResults->isNotEmpty()
                ? ($career->score ?? null)
                : null;

            return $this->buildCareerProfile($career, $score);
        })->values();

        $selectedProfile = $careerProfiles->firstWhere('career_id', $selectedCareerId)
            ?? $careerProfiles->first();

        return view('dashboard', compact(
            'careers',
            'educations',
            'skills',
            'skillGroups',
            'specializations',
            'certifications',
            'searchResults',
            'criteria',
            'sidebarCareers',
            'selectedCareerId',
            'careerProfiles',
            'selectedProfile'
        ));
    }

    private function buildCareerProfile(Career $career, ?float $score = null): array
    {
        $topSkills = DB::table('career_skill_weights as csw')
            ->join('skills as s', 's.skill_id', '=', 'csw.skill_id')
            ->where('csw.career_id', $career->career_id)
            ->orderByDesc('csw.weight')
            ->limit(5)
            ->pluck('s.skill_name')
            ->all();

        $educationAnalysis = DB::table('career_education_weights as cew')
            ->join('educations as e', 'e.education_id', '=', 'cew.education_id')
            ->where('cew.career_id', $career->career_id)
            ->orderByDesc('cew.weight')
            ->limit(3)
            ->get(['e.education_level as label', 'cew.weight']);

        $specializationBars = DB::table('career_specialization_weights as csw')
            ->join('specializations as s', 's.specialization_id', '=', 'csw.specialization_id')
            ->where('csw.career_id', $career->career_id)
            ->orderByDesc('csw.weight')
            ->limit(5)
            ->get(['s.specialization_name as label', 'csw.weight']);

        return [
            'career_id' => $career->career_id,
            'name' => $career->career_name,
            'description' => $this->careerDescription($career->career_name),
            'score' => $score,
            'top_skills' => $topSkills,
            'education_analysis' => $educationAnalysis,
            'specialization_bars' => $specializationBars,
        ];
    }

    private function careerDescription(string $name): string
    {
        $descriptions = [
            'Software Engineer' => 'Merancang, mengembangkan, dan memelihara sistem perangkat lunak kompleks menggunakan berbagai bahasa pemrograman dan arsitektur modern.',
            'Data Analyst' => 'Menganalisis data untuk menghasilkan insight bisnis yang actionable melalui visualisasi dan laporan strategis.',
            'Data Scientist' => 'Membangun model prediktif dan algoritma machine learning untuk memecahkan masalah bisnis yang kompleks.',
            'UI/UX Designer' => 'Merancang antarmuka pengguna yang intuitif dan pengalaman digital yang menyenangkan berdasarkan riset pengguna.',
            'ML Engineer' => 'Mengimplementasikan, men-deploy, dan memelihara model machine learning di lingkungan produksi skala besar.',
            'Machine Learning Engineer' => 'Mengimplementasikan, men-deploy, dan memelihara model machine learning di lingkungan produksi skala besar.',
            'Cybersecurity Analyst' => 'Melindungi sistem dan jaringan dari ancaman siber melalui analisis keamanan, penetration testing, dan incident response.',
            'Cloud Engineer' => 'Merancang dan mengelola infrastruktur cloud yang skalabel, aman, dan hemat biaya untuk mendukung aplikasi modern.',
        ];

        return $descriptions[$name] ?? "Menjelajahi peran {$name} berdasarkan kebutuhan skill, spesialisasi, pendidikan, dan sertifikasi di industri IT.";
    }

    private function resolveRankedCareers(array $criteria): array
    {
        $careerPayloads = $this->buildCareerPayloads();

        try {
            $response = (new FlaskController())->getResult([
                'careers' => $careerPayloads,
                'criteria' => $criteria,
            ]);

            if ($response->successful()) {
                $ranked = collect($response->json('ranked', []))
                    ->filter(fn ($item) => isset($item['career_id'], $item['score']));

                if ($ranked->isNotEmpty()) {
                    return $ranked
                        ->filter(fn ($item) => ($item['score'] ?? 0) > 0)
                        ->sortByDesc('score')
                        ->values()
                        ->take(10)
                        ->all();
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return $this->calculateRankedCareersLocally($careerPayloads, $criteria)->all();
    }

    public function getRecommendation(Request $request)
    {
        return redirect()->route('dashboard', $request->query());
    }

    private function calculateRankedCareersLocally(array $careerPayloads, array $criteria): Collection
    {
        $ranked = RecommendationEngine::recommend($careerPayloads, $criteria);

        return collect($ranked)
            ->filter(fn ($item) => ($item['score'] ?? 0) > 0)
            ->sortByDesc('score')
            ->values()
            ->take(10);
    }

    private function buildCareerPayloads(): array
    {
        return Career::with([
            'educationWeights',
            'skillWeights',
            'specializationWeights',
            'certificationWeights',
        ])
            ->orderBy('career_name')
            ->get()
            ->map(function ($career) {
                return [
                    'career_id' => $career->career_id,
                    'educationWeights' => $career->educationWeights->map(fn ($weight) => [
                        'education_id' => $weight->education_id,
                        'weight' => floatval($weight->weight),
                        'frequency' => intval($weight->frequency),
                    ])->toArray(),
                    'skillWeights' => $career->skillWeights->map(fn ($weight) => [
                        'skill_id' => $weight->skill_id,
                        'weight' => floatval($weight->weight),
                        'frequency' => intval($weight->frequency),
                    ])->toArray(),
                    'specializationWeights' => $career->specializationWeights->map(fn ($weight) => [
                        'specialization_id' => $weight->specialization_id,
                        'weight' => floatval($weight->weight),
                        'frequency' => intval($weight->frequency),
                    ])->toArray(),
                    'certificationWeights' => $career->certificationWeights->map(fn ($weight) => [
                        'certification_id' => $weight->certification_id,
                        'weight' => floatval($weight->weight),
                        'frequency' => intval($weight->frequency),
                    ])->toArray(),
                ];
            })->toArray();
    }
}
