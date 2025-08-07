<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('criterion_id')->constrained('kriterias')->onDelete('cascade');
            $table->integer('raw_score'); // Skor mentah dari guru (misal: 85)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_details');
    }
};