@extends('layouts.guru')
@section('title', $title)

@section('styles')
<style>
    /* CSS untuk membuat halaman responsif dan memperbaiki layout */
    :root {
        --primary-color: #6a5ae0;
        --primary-light: #f0f0ff;
    }
    .header-laporan {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .header-laporan h1 { font-size: 24px; font-weight: 700; margin: 0; }
    .back-button { display: flex; align-items: center; gap: 8px; text-decoration: none; color: #555; font-weight: 500; padding: 8px 12px; border-radius: 8px; transition: background-color 0.2s; }
    .back-button:hover { background-color: #eee; }
    
    /* === BAGIAN YANG DIUBAH: Layout Filter Horizontal === */
    .filter-card {
        background-color: #fff;
        padding: 20px 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    .filter-form {
        display: flex;
        flex-wrap: wrap; /* Agar responsif di layar kecil */
        gap: 20px;
        align-items: center;
    }
    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .filter-group label {
        font-weight: 600;
        font-size: 15px;
        white-space: nowrap; /* Mencegah label turun baris */
    }
    .filter-group .form-control {
        padding: 10px 15px;      /* Memberi ruang di dalam box agar lebih besar */
        font-size: 15px;         /* Menyamakan ukuran font */
        border: 1px solid #ccc;  /* Memberi batas yang jelas */
        border-radius: 8px;      /* Menyamakan lengkungan sudut */
        height: 48px;            /* Menyamakan tinggi dengan tombol */
        box-sizing: border-box;  /* Kalkulasi ukuran yang benar */
        background-color: #fff;  /* Pastikan background putih */
        min-width: 300px;        /* Beri lebar minimal */
    }
    .btn-filter {
        background-color: var(--primary-color);
        color: white; border: none; padding: 12px 25px;
        border-radius: 8px; font-weight: 600; cursor: pointer;
        height: 48px; margin-left: auto; /* Mendorong tombol ke kanan */
    }
    
    .table-card { background-color: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .table-responsive { overflow-x: auto; }
    .table-laporan { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .table-laporan th, .table-laporan td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
    .table-laporan th { font-weight: 600; font-size: 14px; background-color: #f8f9fa; }
    .table-laporan td { font-size: 15px; }
    .badge-nilai { display: inline-block; padding: 5px 12px; border-radius: 20px; font-weight: 700; background-color: var(--primary-light); color: var(--primary-color); }
    .action-icons a { color: #555; margin: 0 5px; text-decoration: none; }

    /* Tampilan Responsif */
    @media (max-width: 992px) {
        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }
        .btn-filter {
            margin-left: 0;
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="header-laporan">
    <h1>{{ $title }}</h1>
    <a href="{{ route('guru.dashboard') }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Dashboard</span>
    </a>
</div>

{{-- Filter Section (SUDAH DIPERBAIKI) --}}
<div class="filter-card">
    <form method="GET" action="{{ route('guru.laporan.index') }}" class="filter-form">
        <div class="filter-group">
            <label for="subject_id">Mata Pelajaran:</label>
            <select name="subject_id" id="subject_id" class="form-control">
                <option value="">Semua</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}" {{ request('subject_id') == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <button type="submit" class="btn-filter">Terapkan Filter</button>
    </form>
</div>

{{-- Tabel Hasil Peringkat --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table-laporan">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Nilai Akhir (V)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hasilPeringkat as $peringkat => $hasil) 
                    @if ($hasil['nilai_akhir'] > 1 || request()->hasAny(['subject_id', 'tanggal']))
                        <tr>
                            <td>{{ $peringkat + 1 }}</td>
                            <td><strong>{{ $hasil['siswa']->nama_lengkap }}</strong></td>
                            <td>{{ $hasil['siswa']->user->email }}</td>
                            <td><span class="badge-nilai">{{ number_format($hasil['nilai_akhir'], 2) }}</span></td>
                            <td class="action-icons">

                                {{-- Link untuk Melihat Detail --}}
                                <a href="{{ route('guru.laporan.show', ['profilSiswa' => $hasil['siswa']->id, 'subject_id' => request('subject_id'), 'tanggal' => request('tanggal')]) }}" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- Link untuk Mengunduh PDF --}}
                                <a href="{{ route('guru.laporan.download', ['profilSiswa' => $hasil['siswa']->id, 'subject_id' => request('subject_id'), 'tanggal' => request('tanggal')]) }}" title="Unduh Laporan">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">
                            Tidak ada data penilaian yang ditemukan untuk filter yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection