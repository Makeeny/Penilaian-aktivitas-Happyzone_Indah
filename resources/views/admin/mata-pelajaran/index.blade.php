@extends('layouts.admin')
@section('title', 'Daftar Mata Pelajaran')
@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .page-header h1 { font-size: 28px; font-weight: 600; }
    .btn-tambah { background-color: #ff4d4f; color: white; }
    .btn { text-decoration: none; padding: 10px 22px; border-radius: 8px; font-weight: 500; font-size: 14px; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; }
    .btn-edit { background-color: #5D5FEF; color: white; }
    .data-table-card { background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 15px 20px; text-align: left; border-bottom: 1px solid #f0f0f0; vertical-align: middle;}
    .table th { font-weight: 600; font-size: 14px; color: #888; text-transform: uppercase; }
    .table td { font-size: 15px; vertical-align: middle; }
    .table thead { background-color: #f8f9fa; }
    .table tbody tr:last-child td { border-bottom: none; }
    .alert-success { background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    .table th:first-child, .table td:first-child { /* Kolom "NO" */
        width: 10%;
        text-align: center;
    }
    .table th:last-child, .table td:last-child { /* Kolom "AKSI" */
        width: 20%;
        padding: 5px;
        text-align: center;
    }
    /* Kolom "NAMA MATA PELAJARAN" akan mengisi sisa ruang secara otomatis */
    
    .action-buttons a, .action-buttons button {
        margin: 0 5px;
        color: #888;
        font-size: 16px;
        text-decoration: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
    }
    .action-buttons a:hover { color: #5D5FEF; }
    .action-buttons button:hover { color: #ff4d4f; }
    .alert-success { padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; }
    .alert-danger { padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px; }

</style>

@section('content')
<div class="page-header">
    <h1>Daftar Mata Pelajaran</h1>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.mata-pelajaran.create') }}" class="btn btn-tambah"><i class="fas fa-plus"></i> Tambah</a>
    </div>
</div>

<div class="data-table-card">
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

@if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mata Pelajaran</th>
                    <th style="text-align: flex;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mapels as $mapel)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $mapel->nama_mapel }}</strong></td>
                    <td class="action-buttons" style="text-align: flex;">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.mata-pelajaran.edit', $mapel->id) }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.mata-pelajaran.destroy', $mapel->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus mata pelajaran ini? Ini mungkin akan mempengaruhi data penilaian yang ada.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 20px;">Belum ada data mata pelajaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection