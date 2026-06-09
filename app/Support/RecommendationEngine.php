<?php

namespace App\Support;

use Illuminate\Support\Collection;

class RecommendationEngine
{
    private const SAW_WEIGHTS = [
        'skills' => 0.40,
        'certification' => 0.25,
        'education' => 0.20,
        'specialization' => 0.15,
    ];

    private const CRITERION_ORDER = ['skills', 'certification', 'education', 'specialization'];

    public static function recommend(array $careerPayloads, array $criteria, int $cbfTopN = 15, int $finalTopN = 10): array
    {
        $cbfResults = self::rankByCosineSimilarity($careerPayloads, $criteria, $cbfTopN);

        if ($cbfResults->isEmpty()) {
            return [];
        }

        $candidateIds = $cbfResults->pluck('career_id')->all();
        $similarityMap = $cbfResults->pluck('similarity_score', 'career_id')->all();

        $sawResults = self::rankCandidatesWithSaw($careerPayloads, $criteria, $candidateIds, $similarityMap);

        return $sawResults->take($finalTopN)
            ->map(fn ($item) => [
                'career_id' => $item['career_id'],
                'score' => $item['score'],
                'saw_score' => $item['saw_score'],
                'similarity_score' => $item['similarity_score'],
            ])
            ->values()
            ->all();
    }

    private static function rankByCosineSimilarity(array $careers, array $criteria, int $topN): Collection
    {
        $userFeatures = self::buildUserFeatureMap($criteria);

        if ($userFeatures === []) {
            return collect();
        }

        $vocabulary = self::buildVocabulary($careers, $criteria);
        $userVector = self::vectorize($userFeatures, $vocabulary);

        if (array_sum($userVector) <= 0) {
            return collect();
        }

        $results = collect();

        foreach ($careers as $career) {
            $careerVector = self::vectorize(self::buildCareerFeatureMap($career), $vocabulary);
            $similarity = self::cosineSimilarity($userVector, $careerVector);

            if ($similarity > 0) {
                $results->push([
                    'career_id' => $career['career_id'],
                    'similarity_score' => round($similarity, 6),
                ]);
            }
        }

        return $results->sortByDesc('similarity_score')->values()->take($topN);
    }

    private static function rankCandidatesWithSaw(
        array $careers,
        array $criteria,
        array $candidateIds,
        array $similarityMap
    ): Collection {
        $careerMap = collect($careers)->keyBy('career_id');
        $candidateCareers = collect($candidateIds)
            ->map(fn ($id) => $careerMap->get($id))
            ->filter()
            ->values();

        if ($candidateCareers->isEmpty()) {
            return collect();
        }

        $rawRows = $candidateCareers
            ->map(fn ($career) => self::criterionScoresForCareer($career, $criteria))
            ->values()
            ->all();

        $normalizedRows = self::normalizeBenefitMatrix($rawRows);

        $ranked = collect();

        foreach ($candidateCareers as $index => $career) {
            $sawScore = self::weightedSum($normalizedRows[$index]);
            $ranked->push([
                'career_id' => $career['career_id'],
                'saw_score' => round($sawScore, 6),
                'similarity_score' => $similarityMap[$career['career_id']] ?? 0.0,
            ]);
        }

        $ranked = $ranked->sortByDesc('saw_score')->values();
        $maxScore = $ranked->max('saw_score') ?: 0;

        return $ranked->map(function ($item) use ($maxScore) {
            $item['score'] = $maxScore > 0
                ? round(($item['saw_score'] / $maxScore) * 100, 2)
                : 0.0;

            return $item;
        });
    }

    private static function buildCareerFeatureMap(array $career): array
    {
        $features = [];

        foreach ($career['educationWeights'] ?? [] as $weight) {
            $features[self::featureKey('education', $weight['education_id'])] = (float) $weight['weight'];
        }

        foreach ($career['specializationWeights'] ?? [] as $weight) {
            $features[self::featureKey('specialization', $weight['specialization_id'])] = (float) $weight['weight'];
        }

        foreach ($career['skillWeights'] ?? [] as $weight) {
            $features[self::featureKey('skill', $weight['skill_id'])] = (float) $weight['weight'];
        }

        foreach ($career['certificationWeights'] ?? [] as $weight) {
            $features[self::featureKey('certification', $weight['certification_id'])] = (float) $weight['weight'];
        }

        return $features;
    }

    private static function buildUserFeatureMap(array $criteria): array
    {
        $features = [];

        if (! empty($criteria['education_id'])) {
            $features[self::featureKey('education', $criteria['education_id'])] = 1.0;
        }

        if (! empty($criteria['certification_id'])) {
            $features[self::featureKey('certification', $criteria['certification_id'])] = 1.0;
        }

        foreach ($criteria['skill_ids'] ?? [] as $skillId) {
            if ($skillId) {
                $features[self::featureKey('skill', $skillId)] = 1.0;
            }
        }

        foreach ($criteria['specialization_ids'] ?? [] as $specId) {
            if ($specId) {
                $features[self::featureKey('specialization', $specId)] = 1.0;
            }
        }

        return $features;
    }

    private static function buildVocabulary(array $careers, array $criteria): array
    {
        $keys = array_keys(self::buildUserFeatureMap($criteria));

        foreach ($careers as $career) {
            $keys = array_merge($keys, array_keys(self::buildCareerFeatureMap($career)));
        }

        $keys = array_values(array_unique($keys));
        sort($keys);

        return $keys;
    }

    private static function vectorize(array $featureMap, array $vocabulary): array
    {
        return array_map(fn ($key) => $featureMap[$key] ?? 0.0, $vocabulary);
    }

    private static function cosineSimilarity(array $vectorA, array $vectorB): float
    {
        $dot = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        foreach ($vectorA as $index => $valueA) {
            $valueB = $vectorB[$index] ?? 0.0;
            $dot += $valueA * $valueB;
            $normA += $valueA ** 2;
            $normB += $valueB ** 2;
        }

        if ($normA <= 0 || $normB <= 0) {
            return 0.0;
        }

        return $dot / (sqrt($normA) * sqrt($normB));
    }

    private static function criterionScoresForCareer(array $career, array $criteria): array
    {
        $educationScore = self::matchWeight(
            $career['educationWeights'] ?? [],
            'education_id',
            $criteria['education_id'] ?? null
        );

        $certificationScore = self::matchWeight(
            $career['certificationWeights'] ?? [],
            'certification_id',
            $criteria['certification_id'] ?? null
        );

        $specializationScore = 0.0;
        foreach ($criteria['specialization_ids'] ?? [] as $specId) {
            $specializationScore += self::matchWeight(
                $career['specializationWeights'] ?? [],
                'specialization_id',
                $specId
            );
        }

        $skillsScore = 0.0;
        foreach ($criteria['skill_ids'] ?? [] as $skillId) {
            foreach ($career['skillWeights'] ?? [] as $weight) {
                if ((string) $weight['skill_id'] === (string) $skillId) {
                    $skillsScore += (float) $weight['weight'];
                }
            }
        }

        return [
            'skills' => $skillsScore,
            'certification' => $certificationScore,
            'education' => $educationScore,
            'specialization' => $specializationScore,
        ];
    }

    private static function matchWeight(array $weights, string $key, mixed $selectedId): float
    {
        if ($selectedId === null || $selectedId === '') {
            return 0.0;
        }

        foreach ($weights as $weight) {
            if ((string) ($weight[$key] ?? '') === (string) $selectedId) {
                return (float) $weight['weight'];
            }
        }

        return 0.0;
    }

    private static function normalizeBenefitMatrix(array $rows): array
    {
        if ($rows === []) {
            return [];
        }

        $normalized = [];

        foreach ($rows as $row) {
            $normalizedRow = [];
            foreach (self::CRITERION_ORDER as $criterion) {
                $columnMax = max(array_column($rows, $criterion));
                $normalizedRow[$criterion] = $columnMax > 0 ? $row[$criterion] / $columnMax : 0.0;
            }
            $normalized[] = $normalizedRow;
        }

        return $normalized;
    }

    private static function weightedSum(array $normalizedRow): float
    {
        $total = 0.0;

        foreach (self::CRITERION_ORDER as $criterion) {
            $total += self::SAW_WEIGHTS[$criterion] * ($normalizedRow[$criterion] ?? 0.0);
        }

        return $total;
    }

    private static function featureKey(string $kind, mixed $entityId): string
    {
        return "{$kind}:{$entityId}";
    }
}
