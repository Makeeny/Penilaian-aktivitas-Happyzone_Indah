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
        Schema::create('profil_siswas', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel 'users'. Jika user dihapus, profilnya juga ikut terhapus.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->text('alamat')->nullable();
            $table->string('no_telepon_ortu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_siswas');
    }
};