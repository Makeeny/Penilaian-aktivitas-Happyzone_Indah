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
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kriteria')->unique();
            $table->string('nama_kriteria');
            $table->float('bobot', 5, 2); // 5 digit total, 2 di belakang koma (misal: 0.30)
            $table->enum('jenis', ['benefit', 'cost']); // jenis hanya bisa diisi 'benefit' atau 'cost'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};