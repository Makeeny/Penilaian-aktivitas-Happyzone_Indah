@extends('layouts.guru')
@section('title', $title)

@section('styles')
<style>
    /* Menggunakan kembali style dari halaman laporan agar konsisten */
    .header-laporan { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .header-laporan h1 { font-size: 24px; font-weight: 700; margin: 0; }
    .action-header { display: flex; gap: 10px; }
    .btn-action-header {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px;
        border-radius: 8px; text-decoration: none; font-weight: 600;
        transition: background-color 0.2s;
    }
        
    .filter-card, .table-card { background-color: #fff; padding: 20px 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
    .filter-form { display: flex; gap: 20px; flex-wrap: wrap; font-size: 15px; }
    .filter-group { display: flex; align-items: center; gap: 10px; box-sizing: border-box; }
    .filter-group .form-control {
        padding: 10px 5px 8px;      /* Memberi ruang di dalam box agar lebih besar */
        font-size: 15px;         /* Menyamakan ukuran font */
        border: 1px solid #ccc;  /* Memberi batas yang jelas */
        border-radius: 5px;      /* Menyamakan lengkungan sudut */
        height: 42px;            /* Menyamakan tinggi dengan tombol */
        box-sizing: border-box;  /* Kalkulasi ukuran yang benar */
        background-color: #fff;  /* Pastikan background putih */
        min-width: 240px;        /* Beri lebar minimal agar tidak terlalu kecil */
    }
    
    /* Mengatur posisi panah dropdown */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        right: 10px !important;
        padding: 10px;
    }
    
    .btn-filter { background-color: #6a5ae0; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; height: 48px; }
    .table-responsive { overflow-x: auto; }
    .table-data-siswa { width: 100%; border-collapse: collapse; }
    .table-data-siswa th, .table-data-siswa td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
    .table-data-siswa th { font-weight: 600; font-size: 14px; background-color: #f8f9fa; }
</style>
@endsection

@section('content')
<div class="header-laporan">
    <h1>{{ $title }} @if($mapelAktif) - <span style="color: #6a5ae0;">{{ $mapelAktif->nama_mapel }}</span> @endif</h1>
</div>

{{-- Filter Section --}}
<div class="filter-card">
    <form method="GET" action="{{ route('guru.data-siswa.index') }}" class="filter-form">
        <div class="filter-group">
            <label for="subject_id">Filter Kelas:</label>
            <select name="subject_id" id="subject_id" class="form-control" onchange="this.form.submit()">
                <option value="">Pilih Mata Pelajaran...</option>
                @foreach($listMapel as $mapel)
                    <option value="{{ $mapel->id }}" {{ optional($mapelAktif)->id == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

{{-- Tabel Daftar Siswa --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table-data-siswa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $index => $siswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $siswa->nama_lengkap }}</strong></td>
                        <td>{{ $siswa->user->email ?? 'N/A' }}</td>
                        <td>
                            {{-- Tambahkan link ke edit profil siswa jika diperlukan --}}
                            <a href="#" title="Edit Profil Siswa"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">
                            Pilih mata pelajaran untuk menampilkan data siswa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection