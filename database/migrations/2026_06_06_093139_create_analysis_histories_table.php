<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
    {
        Schema::create('analysis_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Nyatet siapa yang ngelakuin analisis
            $table->json('criteria'); // Nyimpen skill/kriteria apa aja yang dipilih
            $table->json('results'); // Nyimpen hasil rekomendasi karirnya
            $table->timestamps(); // Otomatis nyatet tanggal dan jam analisis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysis_histories');
    }
};
