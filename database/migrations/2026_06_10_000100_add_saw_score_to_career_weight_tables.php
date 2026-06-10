<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Additive migration: adds a nullable saw_score column to all four
 * career_*_weights tables so that SAW decision-matrix values can be
 * stored independently from the CBF feature-importance weight.
 *
 * Column roles after this migration:
 *   weight    — CBF feature-importance scalar (unchanged, range 0.0–1.0)
 *   saw_score — SAW raw decision-matrix value (nullable; when NULL the
 *               system falls back to weight until rows are populated)
 *
 * No existing columns, indexes, or foreign keys are altered.
 */
return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'career_education_weights',
            'career_specialization_weights',
            'career_skill_weights',
            'career_certification_weights',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                // Placed after weight so the column order is logical when
                // inspecting the schema. NULL = not yet set; fallback to weight.
                $blueprint->decimal('saw_score', 10, 4)->nullable()->after('weight');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'career_education_weights',
            'career_specialization_weights',
            'career_skill_weights',
            'career_certification_weights',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropColumn('saw_score');
            });
        }
    }
};
