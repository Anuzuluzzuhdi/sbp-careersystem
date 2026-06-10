<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Populates the saw_score column in all four career_*_weights tables
 * using the existing frequency column as the SAW decision-matrix value.
 *
 * ─── Methodological rationale ───────────────────────────────────────────────
 *
 *   weight    = frequency / career_total   (relative frequency, range 0–1)
 *               → Used by CBF to build cosine-similarity feature vectors.
 *               → Measures how strongly an attribute CHARACTERISES a career.
 *
 *   saw_score = frequency                  (raw count, range 1–N)
 *               → Used by SAW as the raw decision-matrix entry x_ij.
 *               → Measures the VOLUME OF EVIDENCE associating an attribute
 *                 with a career in the training dataset.
 *               → Benefit normalisation (r_ij = x_ij / max(x_j)) applied at
 *                 query time rescales these to [0, 1] across the current
 *                 candidate set, so absolute magnitude does not affect SAW.
 *
 * ─── Idempotency ────────────────────────────────────────────────────────────
 *
 *   Safe to run multiple times. The UPDATE sets saw_score = frequency
 *   unconditionally — frequency never changes after seeding, so repeated
 *   runs always produce the same result.
 *
 * ─── Why DB::statement() instead of DB::table()->update() ───────────────────
 *
 *   DB::table($table)->update(['saw_score' => DB::raw('...')]) requires a
 *   WHERE clause on tables with composite primary keys (no auto-increment id).
 *   Without a WHERE, the query builder may not execute against all rows.
 *   DB::statement() sends the raw SQL directly, guaranteeing a full-table
 *   UPDATE with no silent skips.
 */
class SawScoreSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            'career_education_weights',
            'career_specialization_weights',
            'career_skill_weights',
            'career_certification_weights',
        ];

        foreach ($tables as $table) {
            // Raw SQL UPDATE — sets every row's saw_score to its frequency value.
            // DECIMAL(6,4) cast matches the column definition added by migration
            // 2026_06_10_000100_add_saw_score_to_career_weight_tables.php.
            DB::statement("UPDATE `{$table}` SET `saw_score` = CAST(`frequency` AS DECIMAL(10, 4))");

            // Count rows actually updated for console feedback.
            $total = DB::table($table)->count();

            $this->command->info("  [{$table}] saw_score populated — {$total} rows.");
        }

        $this->command->newLine();
        $this->command->info('SawScoreSeeder complete.');
        $this->command->info('Run the verification query in phpMyAdmin:');
        $this->command->line('');
        $this->command->line('  SELECT frequency, weight, saw_score');
        $this->command->line('  FROM career_skill_weights LIMIT 10;');
        $this->command->line('');
        $this->command->line('  Expected: saw_score = frequency (e.g. 7, 31, 27 ...)');
        $this->command->line('  Expected: weight unchanged (e.g. 0.0231, 0.1023 ...)');
    }
}
