<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds the default SAW global-criterion weights.
 *
 * These values mirror the hardcoded SAW_WEIGHTS constant in the Flask
 * service (career-flask-api/app/service/preprocessing.py) and must
 * continue to sum to exactly 1.0.
 *
 * To change the weights at runtime:
 *   1. Update the rows in saw_criterion_weights via a DB migration or
 *      admin interface.
 *   2. Ensure all active rows still sum to 1.0.
 *   3. The Flask service will pick up the new values on the next request
 *      (values are passed in the payload from Laravel, not read directly
 *      from the DB by Flask).
 */
class SawCriterionWeightsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['criterion_name' => 'skills',          'weight' => 0.4000, 'is_active' => true],
            ['criterion_name' => 'certification',    'weight' => 0.2500, 'is_active' => true],
            ['criterion_name' => 'education',        'weight' => 0.2000, 'is_active' => true],
            ['criterion_name' => 'specialization',   'weight' => 0.1500, 'is_active' => true],
        ];

        foreach ($defaults as $row) {
            DB::table('saw_criterion_weights')->updateOrInsert(
                ['criterion_name' => $row['criterion_name']],
                array_merge($row, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
