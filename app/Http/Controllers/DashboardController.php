<?php

namespace App\Http\Controllers;

use App\Models\Career;
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
            $ranked = $this->normalizeScoresToPercentage(
                $this->resolveRankedCareers($criteria)
            );

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

        return view('dashboard', compact(
            'careers',
            'educations',
            'skills',
            'skillGroups',
            'specializations',
            'certifications',
            'searchResults',
            'criteria'
        ));
    }

    private function resolveRankedCareers(array $criteria): Collection
    {
        $careerPayloads = Career::with([
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
                        ->take(10);
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return $this->calculateRankedCareersLocally($criteria);
    }

    private function normalizeScoresToPercentage(Collection $ranked): Collection
    {
        $maxScore = $ranked->max('score') ?? 0;

        if ($maxScore <= 0) {
            return $ranked;
        }

        return $ranked->map(fn ($item) => [
            'career_id' => $item['career_id'],
            'score' => round(($item['score'] / $maxScore) * 100, 2),
        ])->values();
    }

    private function calculateRankedCareersLocally(array $criteria): Collection
    {
        $scores = [];

        if (! empty($criteria['education_id'])) {
            foreach (DB::table('career_education_weights')->where('education_id', $criteria['education_id'])->get() as $row) {
                $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
            }
        }

        if (! empty($criteria['skill_ids'])) {
            foreach (DB::table('career_skill_weights')->whereIn('skill_id', $criteria['skill_ids'])->get() as $row) {
                $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
            }
        }

        if (! empty($criteria['specialization_ids'])) {
            foreach (DB::table('career_specialization_weights')->whereIn('specialization_id', $criteria['specialization_ids'])->get() as $row) {
                $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
            }
        }

        if (! empty($criteria['certification_id'])) {
            foreach (DB::table('career_certification_weights')->where('certification_id', $criteria['certification_id'])->get() as $row) {
                $scores[$row->career_id] = ($scores[$row->career_id] ?? 0) + floatval($row->weight);
            }
        }

        return collect($scores)
            ->map(fn ($score, $careerId) => [
                'career_id' => (int) $careerId,
                'score' => round($score, 6),
            ])
            ->filter(fn ($item) => $item['score'] > 0)
            ->sortByDesc('score')
            ->values()
            ->take(10);
    }
}
