@extends('layouts.guru')

@section('title', 'Beranda Guru')

@section('content')
<style>
    .welcome-banner {
        background-color: #7A70FF; color: white; padding: 40px; border-radius: 20px;
        display: flex; align-items: center; justify-content: space-between;
        gap: 30px; overflow: hidden; position: relative;
    }
    .welcome-text h1 { font-size: 36px; font-weight: 700; margin-bottom: 10px; }
    .welcome-text p { font-size: 18px; opacity: 0.9; margin-bottom: 25px; }
    .welcome-text .btn-laporan {
        background-color: white; color: #7A70FF; padding: 12px 25px;
        text-decoration: none; border-radius: 10px; font-weight: 600;
        transition: transform 0.2s; display: inline-block;
    }
    .welcome-text .btn-laporan:hover { transform: scale(1.05); }
    .welcome-image { width: 40%; height: 250px; object-fit: cover; border-radius: 15px; }
    .section-title { text-align: center; font-size: 28px; font-weight: 600; margin-top: 50px; margin-bottom: 30px; }
    
    /* Responsif */
    @media (max-width: 768px) {
        .guru-grid { grid-template-columns: 1fr; }
        .welcome-banner { flex-direction: column; text-align: center; }
        .welcome-image { width: 80%; margin-top: 20px; }
    }
</style>

<div class="welcome-banner">
    <div class="welcome-text">
        <h1>Halo, {{ Auth::user()->name }}! 👋</h1>
        <p>Selamat Datang Kembali!</p>
        <a href="{{ route('guru.penilaian.index') }}" class="btn-laporan">Submit Laporan Penilaian Siswa →</a>
    </div>
    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop" alt="Suasana Kelas" class="welcome-image">
@endsection