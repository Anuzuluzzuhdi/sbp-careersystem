<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\SawCriterionWeight;
use App\Support\SkillCategoryGrouper;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    // ─────────────────────────────────────────────
    // METHOD LAMA — TIDAK DIUBAH SAMA SEKALI
    // ─────────────────────────────────────────────

    public function index(Request $request)
    {
        $careers         = DB::table('careers')->orderBy('career_name')->get();
        $educations      = DB::table('educations')->orderBy('education_level')->get();
        $skills          = DB::table('skills')->orderBy('skill_name')->get();
        $skillGroups     = SkillCategoryGrouper::group($skills);
        $specializations = DB::table('specializations')->orderBy('specialization_name')->get();
        $certifications  = DB::table('certifications')->orderBy('certification_name')->get();

        return view('dashboard', compact(
            'careers', 'educations', 'skills',
            'skillGroups', 'specializations', 'certifications'
        ));
    }

    public function getRecommendation(Request $request)
    {
        // ─── SEMUA KODE INI COPY-PASTE DARI index() LAMA, TIDAK ADA YANG DIUBAH ───

        $careers         = DB::table('careers')->orderBy('career_name')->get();
        $educations      = DB::table('educations')->orderBy('education_level')->get();
        $skills          = DB::table('skills')->orderBy('skill_name')->get();
        $skillGroups     = SkillCategoryGrouper::group($skills);
        $specializations = DB::table('specializations')->orderBy('specialization_name')->get();
        $certifications  = DB::table('certifications')->orderBy('certification_name')->get();

        $educationId       = $request->query('education_id');
        $skillIds          = collect($request->query('skill_ids', []))->filter()->values()->all();
        $specializationIds = collect($request->query('specialization_ids', []))->filter()->values()->all();
        $certificationId   = $request->query('certification_id');

        $criteria = [
            'education_id'       => $educationId,
            'skill_ids'          => $skillIds,
            'specialization_ids' => $specializationIds,
            'certification_id'   => $certificationId,
        ];

        $hasCriteria   = (bool) array_filter($criteria);
        $searchResults = collect();

        if ($hasCriteria) {
            // resolveRankedCareers() returns scores already on a 0–100 scale
            // (both the Flask pipeline and the local SAW fallback). Do NOT pass
            // through normalizeScoresToPercentage() — that would re-scale and
            // collapse the top score to 100 a second time, distorting relative gaps.
            $ranked = $this->resolveRankedCareers($criteria);

            if ($ranked->isNotEmpty()) {
                $ids      = $ranked->pluck('career_id')->all();
                $scoreMap = $ranked->pluck('score', 'career_id')->all();
                $idList   = implode(',', array_map('intval', $ids));

                $searchResults = Career::whereIn('career_id', $ids)
                    ->orderByRaw("FIELD(career_id, $idList)")
                    ->get()
                    ->map(function ($career) use ($scoreMap) {
                        $career->score = $scoreMap[$career->career_id] ?? 0;
                        return $career;
                    });
            }
        }
// --- KODE BARU: Menyimpan histori ke database ---
        if ($hasCriteria && $searchResults->isNotEmpty()) {
            // Kita simpan nama karir dan skor kecocokannya saja agar rapi
            $historyResults = $searchResults->map(function($item) {
                return [
                    'career_name' => $item->career_name,
                    'score' => $item->score
                ];
            })->toArray();

            // Perintah untuk memasukkan data ke tabel analysis_histories
            \App\Models\AnalysisHistory::create([
                'user_id' => auth()->id(),
                'criteria' => $criteria,
                'results' => $historyResults
            ]);
        }
        // --- AKHIR KODE BARU ---

       $histories = \App\Models\AnalysisHistory::where('user_id', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('analysis.result', compact(
            'careers', 'educations', 'skills',
            'skillGroups', 'specializations', 'certifications',
            'searchResults', 'criteria', 'histories' // <-- Jangan lupa tambahkan 'histories' di sini
        ));
    }

    // ─────────────────────────────────────────────
    // METHOD BARU — hanya untuk view, nol logika
    // ─────────────────────────────────────────────

    public function analysisForm()
    {
        $educations      = DB::table('educations')->orderBy('education_level')->get();
        $skills          = DB::table('skills')->orderBy('skill_name')->get();
        $skillGroups     = SkillCategoryGrouper::group($skills);
        $specializations = DB::table('specializations')->orderBy('specialization_name')->get();
        $certifications  = DB::table('certifications')->orderBy('certification_name')->get();

        return view('analysis.form', compact(
            'educations', 'skills', 'skillGroups',
            'specializations', 'certifications'
        ));
    }

    public function careers()
    {
        $careers = DB::table('careers')->orderBy('career_name')->get();

        return view('careers.index', compact('careers'));
    }

    // ─────────────────────────────────────────────
    // PRIVATE METHODS LAMA — TIDAK DIUBAH SAMA SEKALI
    // ─────────────────────────────────────────────

    private function resolveRankedCareers(array $criteria): Collection
    {
        // ── Build career payload ──────────────────────────────────────────────
        // Each weight entry carries both `weight` (CBF role) and `saw_score`
        // (SAW role). saw_score is null when not yet populated; Flask falls
        // back to weight in that case (see preprocessing.py).
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
                    'career_id'             => $career->career_id,
                    'educationWeights'      => $career->educationWeights->map(fn ($w) => [
                        'education_id' => $w->education_id,
                        // CBF uses weight; SAW uses saw_score (null → fallback to weight)
                        'weight'       => floatval($w->weight),
                        'saw_score'    => $w->saw_score !== null ? floatval($w->saw_score) : null,
                        'frequency'    => intval($w->frequency),
                    ])->toArray(),
                    'skillWeights'          => $career->skillWeights->map(fn ($w) => [
                        'skill_id'  => $w->skill_id,
                        'weight'    => floatval($w->weight),
                        'saw_score' => $w->saw_score !== null ? floatval($w->saw_score) : null,
                        'frequency' => intval($w->frequency),
                    ])->toArray(),
                    'specializationWeights' => $career->specializationWeights->map(fn ($w) => [
                        'specialization_id' => $w->specialization_id,
                        'weight'            => floatval($w->weight),
                        'saw_score'         => $w->saw_score !== null ? floatval($w->saw_score) : null,
                        'frequency'         => intval($w->frequency),
                    ])->toArray(),
                    'certificationWeights'  => $career->certificationWeights->map(fn ($w) => [
                        'certification_id' => $w->certification_id,
                        'weight'           => floatval($w->weight),
                        'saw_score'        => $w->saw_score !== null ? floatval($w->saw_score) : null,
                        'frequency'        => intval($w->frequency),
                    ])->toArray(),
                ];
            })->toArray();

        // ── Try Flask pipeline ────────────────────────────────────────────────
        try {
            $response = (new FlaskController())->getResult([
                'careers'  => $careerPayloads,
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
            Log::warning('Flask pipeline unavailable; using local SAW fallback.', [
                'reason'     => $e->getMessage(),
                'timestamp'  => now()->toIso8601String(),
                'fallback'   => true,
            ]);
        }

        // ── Local SAW fallback ────────────────────────────────────────────────
        // Produces scores on the same 0–100 scale as Flask. Do NOT pass the
        // result through normalizeScoresToPercentage() — it is already normalised.
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
            'score'     => round(($item['score'] / $maxScore) * 100, 2),
        ])->values();
    }

    private function calculateRankedCareersLocally(array $criteria): Collection
    {
        // ── Load SAW global-criterion weights ─────────────────────────────────
        // Reads from saw_criterion_weights table; falls back to hardcoded
        // defaults (matching Flask's SAW_WEIGHTS) when the table is empty.
        $criterionWeights = SawCriterionWeight::activeWeights();

        // ── Step 1: compute raw per-criterion scores for every career ─────────
        // SAW uses saw_score when non-null; falls back to weight otherwise.
        // This mirrors criterion_scores_for_career() in Flask's preprocessing.py.
        $educationRows       = [];
        $skillRows           = [];
        $specializationRows  = [];
        $certificationRows   = [];

        if (! empty($criteria['education_id'])) {
            $educationRows = DB::table('career_education_weights')
                ->where('education_id', $criteria['education_id'])
                ->get(['career_id', 'weight', 'saw_score'])
                ->keyBy('career_id')
                ->toArray();
        }

        if (! empty($criteria['skill_ids'])) {
            foreach (DB::table('career_skill_weights')
                ->whereIn('skill_id', $criteria['skill_ids'])
                ->get(['career_id', 'weight', 'saw_score']) as $row) {
                $val = $row->saw_score !== null ? floatval($row->saw_score) : floatval($row->weight);
                $skillRows[$row->career_id] = ($skillRows[$row->career_id] ?? 0.0) + $val;
            }
        }

        if (! empty($criteria['specialization_ids'])) {
            foreach (DB::table('career_specialization_weights')
                ->whereIn('specialization_id', $criteria['specialization_ids'])
                ->get(['career_id', 'weight', 'saw_score']) as $row) {
                $val = $row->saw_score !== null ? floatval($row->saw_score) : floatval($row->weight);
                $specializationRows[$row->career_id] = ($specializationRows[$row->career_id] ?? 0.0) + $val;
            }
        }

        if (! empty($criteria['certification_id'])) {
            $certificationRows = DB::table('career_certification_weights')
                ->where('certification_id', $criteria['certification_id'])
                ->get(['career_id', 'weight', 'saw_score'])
                ->keyBy('career_id')
                ->toArray();
        }

        // ── Step 2: collect all career IDs that appear in any criterion ───────
        $allCareerIds = collect()
            ->merge(array_keys($educationRows))
            ->merge(array_keys($skillRows))
            ->merge(array_keys($specializationRows))
            ->merge(array_keys($certificationRows))
            ->unique()
            ->all();

        if (empty($allCareerIds)) {
            return collect();
        }

        // ── Step 3: build raw decision matrix (one row per career) ────────────
        $rawMatrix = [];
        foreach ($allCareerIds as $careerId) {
            $eduRow  = $educationRows[$careerId]      ?? null;
            $certRow = $certificationRows[$careerId]  ?? null;

            $rawMatrix[$careerId] = [
                // Single-match criteria: use saw_score if present, else weight
                'education'      => $eduRow
                    ? ($eduRow->saw_score !== null ? floatval($eduRow->saw_score) : floatval($eduRow->weight))
                    : 0.0,
                'certification'  => $certRow
                    ? ($certRow->saw_score !== null ? floatval($certRow->saw_score) : floatval($certRow->weight))
                    : 0.0,
                // Multi-match criteria: already summed above
                'skills'         => $skillRows[$careerId]         ?? 0.0,
                'specialization' => $specializationRows[$careerId] ?? 0.0,
            ];
        }

        // ── Step 4: benefit normalisation r_ij = x_ij / max(x_j) ────────────
        // Mirrors normalize_benefit_matrix() in Flask's saw.py.
        $criterionOrder = ['skills', 'certification', 'education', 'specialization'];
        $columnMax = [];
        foreach ($criterionOrder as $criterion) {
            $columnMax[$criterion] = max(array_column($rawMatrix, $criterion) ?: [0.0]);
        }

        $normalised = [];
        foreach ($rawMatrix as $careerId => $row) {
            $normRow = [];
            foreach ($criterionOrder as $criterion) {
                $normRow[$criterion] = $columnMax[$criterion] > 0
                    ? $row[$criterion] / $columnMax[$criterion]
                    : 0.0;
            }
            $normalised[$careerId] = $normRow;
        }

        // ── Step 5: weighted sum (SAW score) ──────────────────────────────────
        $sawScores = [];
        foreach ($normalised as $careerId => $normRow) {
            $score = 0.0;
            foreach ($criterionOrder as $criterion) {
                $w = $criterionWeights[$criterion] ?? 0.0;
                $score += $w * $normRow[$criterion];
            }
            $sawScores[$careerId] = $score;
        }

        // ── Step 6: max-scale to 0–100 ───────────────────────────────────────
        // Mirrors the final step in rank_candidates_with_saw() in Flask's saw.py.
        $maxSaw = max($sawScores ?: [0.0]);

        if ($maxSaw <= 0) {
            return collect();
        }

        return collect($sawScores)
            ->map(fn ($sawScore, $careerId) => [
                'career_id' => (int) $careerId,
                'score'     => round(($sawScore / $maxSaw) * 100, 2),
            ])
            ->filter(fn ($item) => $item['score'] > 0)
            ->sortByDesc('score')
            ->values()
            ->take(10);
    }
}