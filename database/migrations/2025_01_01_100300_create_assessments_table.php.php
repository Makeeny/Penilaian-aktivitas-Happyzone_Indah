<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('profil_siswa_id')->constrained('profil_siswas')->onDelete('cascade');
        $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // Diperbaiki dari 'subjects'
        $table->string('aktivitas');
        $table->date('tanggal');
        // NOTE: Perubahan Utama di Sini
        // Menghapus kriteria_id dan nilai_siswa tunggal
        // Menambahkan kolom untuk setiap nilai kriteria dan indikatornya
        $table->string('indikator_c1'); // Menyimpan teks indikator, mis: "Sangat Aktif"
        $table->string('indikator_c2');
        $table->string('indikator_c3');
        $table->string('indikator_c4');
        $table->integer('nilai_c1'); // Menyimpan nilai 1-100
        $table->integer('nilai_c2');
        $table->integer('nilai_c3');
        $table->integer('nilai_c4');
        $table->decimal('total_poin', 8, 2); // Kolom baru untuk menyimpan total poin (mis: 92.00)

        $table->text('feedback')->nullable();
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};