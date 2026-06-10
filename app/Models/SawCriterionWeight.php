<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents a single SAW global-criterion weight row.
 *
 * Column roles:
 *   criterion_name  — one of: skills, certification, education, specialization
 *   weight          — SAW global coefficient for this criterion (sum of all
 *                     active rows must equal 1.0)
 *   is_active       — when false, the criterion is excluded from SAW scoring
 *
 * This model is used by DashboardController::calculateRankedCareersLocally()
 * to load the same criterion weights that Flask uses, so both paths produce
 * scores on the same normalised 0–100 scale.
 */
class SawCriterionWeight extends Model
{
    protected $table = 'saw_criterion_weights';

    protected $fillable = [
        'criterion_name',
        'weight',
        'is_active',
    ];

    protected $casts = [
        'weight'    => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * Returns a keyed array of active criterion weights, e.g.:
     *   ['skills' => 0.40, 'certification' => 0.25, ...]
     *
     * Falls back to the same hardcoded defaults used in Flask when the
     * table is empty or inaccessible.
     */
    public static function activeWeights(): array
    {
        try {
            $rows = static::where('is_active', true)->pluck('weight', 'criterion_name')->all();

            if (! empty($rows)) {
                return $rows;
            }
        } catch (\Throwable) {
            // Table not yet migrated or DB unavailable — use defaults.
        }

        return [
            'skills'         => 0.40,
            'certification'  => 0.25,
            'education'      => 0.20,
            'specialization' => 0.15,
        ];
    }
}
