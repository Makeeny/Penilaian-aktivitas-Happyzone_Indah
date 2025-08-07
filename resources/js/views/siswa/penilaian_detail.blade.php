@extends('layouts.siswa')
@section('title', $title)

@section('styles')
<style>
 .page-container { max-width: 1100px; margin: 0 auto; }
    .header-laporan { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px; }
    .header-laporan h1 { font-size: 24px; font-weight: 700; margin: 0; flex-grow: 1; }
    .header-laporan h1 span { color: #6a5ae0; }
    .back-button { display: flex; align-items: center; gap: 8px; text-decoration: none; color: #555; font-weight: 500; }
    
    /* Grup untuk tombol-tombol agar menyatu */
    .header-actions {
        display: flex;
        gap: 10px; /* Jarak antar tombol */
    }

    .btn-header-action {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        font-weight: 500;
        padding: 8px 15px;
        border-radius: 8px;
        transition: background-color 0.2s;
        border: 1px solid transparent;
    }
    .btn-detail { background-color: #e6f7ff; color: #1890ff; border-color: #91d5ff; }
    .btn-kembali { background-color: #f5f5f5; color: #555; border-color: #d9d9d9; }
    .btn-header-action:hover { opacity: 0.8; }

    /* Style untuk filter card */
    .filter-card {
        background-color: #fff;
        padding: 20px 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-end; /* Menjaga elemen sejajar di bagian bawah */
    }
    .filter-group {
        flex: 1; /* Membuat setiap grup fleksibel */
    }
    .filter-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .form-control {
        width: 100%;
        padding: 10px 15px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        height: 48px;
    }
    .btn-filter {
        background-color: #6a5ae0;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        height: 48px;
    }
.table-card { background-color: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .table-detail { width: 100%; border-collapse: separate; border-spacing: 0 10px; } /* Menggunakan border-spacing */
    
    /* Hapus border-bottom default */
    .table-detail th, .table-detail td { text-align: left; padding: 15px; }

    .table-detail th { font-weight: 600; font-size: 14px; color: #777; text-transform: uppercase; border-bottom: 2px solid #f0f0f0; }
    
    /* Styling untuk setiap baris data */
    .table-detail tbody tr {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: transform 0.2s;
    }
    .table-detail tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }
    .table-detail td:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
    .table-detail td:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
    
    /* Menghilangkan garis bawah pada nama siswa dan menambahkan hover */
    .nama-siswa-link {
        font-weight: 700;
        text-decoration: none;
        color: #333;
        transition: color 0.2s;
    }
    .nama-siswa-link:hover {
        color: #6a5ae0;
    }

    /* Styling untuk badge Nilai, Poin, dan Ranking */
    .badge {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 14px;
        text-align: center;
        min-width: 50px;
    }
    .badge-nilai { background-color: #e6f7ff; color: #1890ff; }
    .badge-poin { background-color: #fffbe6; color: #faad14; }
    .badge-rank { background-color: #f6ffed; color: #52c41a; }

    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .page-header h1 { font-size: 24px; font-weight: 700; margin: 0; }
    .page-header h1 span { color: #6a5ae0; }
    .back-button { display: flex; align-items: center; gap: 8px; text-decoration: none; color: #6a5ae0; font-weight: 500; }
    .table-card { background-color: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .table-detail { width: 100%; border-collapse: collapse; }
    .table-detail th, .table-detail td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
    .table-detail th { font-weight: 600; font-size: 14px; color: #777; text-transform: uppercase; }
    .table-detail tr:last-child td { border-bottom: none; }
    .badge-poin { background-color: #fff8e1; color: #f59e0b; padding: 4px 12px; border-radius: 20px; font-weight: 700; }

     @media (max-width: 992px) {
        /* Untuk layar tablet */
        .filter-form {
            flex-direction: column; /* Filter menjadi vertikal */
            align-items: stretch; /* Buat elemen filter mengisi lebar */
        }
        .btn-filter {
            width: 100%;
        }
    }
    @media (max-width: 768px) {
        /* Untuk layar ponsel */
        .header-laporan h1 {
            font-size: 20px; /* Kecilkan judul */
        }
        .filter-card, .table-card {
            padding: 15px; /* Kurangi padding */
        }
        .table-responsive {
            overflow-x: auto; /* Aktifkan scroll horizontal untuk tabel */
        }
        .table-detail {
            min-width: 700px; /* Beri lebar minimal agar tabel tidak gepeng */
        }
    }
</style>
@endsection

@section('content')
<div class="header-laporan">
    <h1>Detail Laporan Penilaian : <span>{{ $subject->nama_mapel }}</span></h1>
    
    {{-- Grup untuk tombol-tombol aksi --}}
    <div class="header-actions">
        <a href="{{ route('siswa.rekap-poin.show', $subject->id) }}" class="btn-header-action btn-detail">
            <i class="fas fa-chart-pie"></i>
            <span>Detail Poin</span>
        </a>

        <a href="{{ route('siswa.dashboard') }}" class="btn-header-action btn-kembali">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

<div class="filter-card">
        <form method="GET" action="{{ route('siswa.penilaian.show', $subject->id) }}" class="filter-form">
            <div class="filter-group">
                <label for="start_date">Dari Tanggal:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="filter-group">
                <label for="end_date">Sampai Tanggal:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="btn-filter">Terapkan Filter</button>
        </form>
    </div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table-detail">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Aktivitas</th>
                <th>Tanggal</th>
                <th>Nilai</th>
                <th>Poin</th>
                <th>Feedback</th>
                <th>Peringkat Harian</th>
            </tr>
        </thead>
            <tbody>
                @forelse($penilaian as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                        {{-- Nama Siswa tanpa garis bawah --}}
                        <td><a href="#" class="nama-siswa-link">{{ $item->profilSiswa->nama_lengkap }}</a></td>
                        <td>{{ $item->aktivitas }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        {{-- Nilai dengan badge --}}
                        <td><span class="badge badge-nilai">{{ $item->nilai_siswa }}</span></td>
                        {{-- Poin dengan badge --}}
                        <td><span class="badge badge-poin">+{{ round($item->poin) }}</span></td>
                        <td>{{ $item->feedback ?? '-' }}</td>
                        {{-- Ranking Harian dengan badge --}}
                        <td>
                            @if(isset($peringkatHarian[$item->tanggal]))
                                <span class="badge badge-rank">#{{ $peringkatHarian[$item->tanggal] }}</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding: 40px;">Belum ada data penilaian untuk mata pelajaran ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
