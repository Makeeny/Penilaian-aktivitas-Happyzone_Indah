@extends('layouts.siswa') {{-- Asumsi Anda punya layout untuk siswa --}}
@section('title', 'Dashboard Siswa')

@section('styles')
<style>
    .welcome-banner {
        background-color: #6a5ae0;
        color: white;
        border-radius: 20px;
        padding: 40px;
        display: flex;
        align-items: center;
        gap: 30px;
        margin-bottom: 40px;
    }
    .welcome-text h1 { font-size: 2.5rem; font-weight: 700; }
    .welcome-text p { font-size: 1.1rem; opacity: 0.9; margin-top: 10px; }
    .btn-progress {
        display: inline-block;
        margin-top: 20px;
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 12px 25px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .btn-progress:hover { background-color: rgba(255, 255, 255, 0.3); }
    .welcome-image { max-width: 40%; border-radius: 15px; }

    .section-title { font-size: 1.8rem; font-weight: 600; margin-bottom: 20px; text-align: center; }

    .mapel-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
    }
    .mapel-card {
       background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 15px;
        padding: 25px 20px;
        text-decoration: none;
        color: #333;
        font-weight: 600;
        transition: transform 0.2s, box-shadow 0.2s;
        /* Tambahkan Flexbox untuk mengatur layout vertikal */
        display: flex;
        flex-direction: column; /* Membuat item di dalamnya tersusun ke bawah */
        justify-content: center; /* Pusatkan konten secara vertikal */
        align-items: center; /* Pusatkan konten secara horizontal */
    }
    .mapel-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        color: #6a5ae0;
    }
    .mapel-card i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #6a5ae0;
        background-color: #f0f0ff;
        width: 70px;
        height: 70px;
        line-height: 70px; /* Menjaga ikon tetap di tengah lingkaran */
        border-radius: 50%;
        text-align: center;
        display: inline-block;
    }

    .mapel-card span {
        margin-top: auto; /* Mendorong teks ke bawah jika ada ruang lebih */
    }

    /* Responsif */
    @media (max-width: 768px) {
        .welcome-banner {
            flex-direction: column;
            text-align: center;
        }
        .welcome-image {
            display: none; /* Sembunyikan gambar di layar kecil agar tidak penuh */
        }
</style>
@endsection

@section('content')
    {{-- Banner Selamat Datang --}}
    <div class="welcome-banner">
        <div class="welcome-text">
            <h1>Halo, {{ Auth::user()->name }}! 👋</h1>
            <p>Selamat Datang Kembali! Yuk Lanjutkan petualangan belajarmu hari ini! Pantau progres dan prestasimu.</p>
            <a href="#" class="btn-progress">Lihat Progres Penilaianmu →</a>
        </div>
        <img src="{{ asset('images/elementary.png') }}" alt="Anak-anak belajar" class="welcome-image">
    </div>

    {{-- Pilihan Mata Pelajaran --}}
    <h2 class="section-title">Pilih Mata Pelajaran</h2>
    <div class="mapel-grid">
        @foreach($mapels as $mapel)
            <a href="{{ route('siswa.penilaian.show', $mapel->id) }}" class="mapel-card">
                @if($mapel->nama_mapel == 'Bahasa Inggris') <i class="fas fa-language"></i>
                @elseif($mapel->nama_mapel == 'Calistung') <i class="fas fa-calculator"></i>
                @elseif($mapel->nama_mapel == 'Art / Kesenian') <i class="fas fa-palette"></i>
                @elseif($mapel->nama_mapel == 'Mandarin') <i class="fas fa-globe-asia"></i>
                @elseif($mapel->nama_mapel == 'Matematika') <i class="fas fa-square-root-alt"></i>
                @elseif($mapel->nama_mapel == 'Gucheng') <i class="fas fa-music"></i>
                @else <i class="fas fa-book"></i>
                @endif
                <span>{{ $mapel->nama_mapel }}</span>
            </a>
        @endforeach
    </div>
@endsection
