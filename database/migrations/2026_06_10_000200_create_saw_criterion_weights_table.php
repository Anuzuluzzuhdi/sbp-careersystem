<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the saw_criterion_weights table.
 *
 * This table stores the per-criterion global SAW coefficients that are
 * applied after benefit normalisation (r_ij = x_ij / max(x_j)).
 * The sum of all active weights must equal 1.0.
 *
 * Default rows are inserted by SawCriterionWeightsSeeder, which is called
 * from DatabaseSeeder after this migration runs.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saw_criterion_weights', function (Blueprint $table) {
            $table->id();

            // e.g. 'skills', 'certification', 'education', 'specialization'
            $table->string('criterion_name', 50)->unique();

            // Global SAW coefficient for this criterion. All active rows must
            // sum to 1.0 (enforced at the application layer, not DB level).
            $table->decimal('weight', 5, 4);

            // When false the criterion is excluded from SAW computation.
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_criterion_weights');
    }
};
