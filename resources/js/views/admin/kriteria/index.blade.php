@extends('layouts.admin')
@section('title', $title)
@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .page-header h1 { font-size: 28px; font-weight: 600; }
    .sub-header { color: #6c757d; margin-bottom: 25px; }
    .btn { text-decoration: none; padding: 10px 22px; border-radius: 8px; font-weight: 500; font-size: 14px; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; }
    .btn-primary { background-color: #ff4d4f; color: white; }
    .btn-secondary { background-color: #f0f2f5; color: #555; border: 1px solid #ddd; }
    .data-table-card { background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 16px 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
    .table th { font-weight: 600; font-size: 14px; color: #888; text-transform: uppercase; }
    .table td { font-size: 15px; vertical-align: middle; }
    .table tbody tr:last-child td { border-bottom: none; }
    .bobot-badge { background-color: #e7f7f4; color: #20a17b; padding: 6px 15px; border-radius: 15px; font-weight: 600; }
    .action-buttons a { margin: 0 8px; color: #888; font-size: 18px; text-decoration: none; }
    .action-buttons a.delete:hover { color: #ff4d4f; }
    .action-buttons a.edit:hover { color: #5D5FEF; }
    .alert-success { background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
</style>
<div class="page-header">
    <h1>Daftar Mata Pelajaran dan Kriteria Bobot penilaian SAW</h1>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
    </div>
</div>
<p class="sub-header">Bobot ini berlaku sama untuk semua mata pelajaran.</p>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="data-table-card">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Tipe</th>
                <th>Bobot</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kriterias as $kriteria)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kriteria->nama_kriteria }}</td>
                <td>{{ ucfirst($kriteria->jenis) }}</td>
                <td><span class="bobot-badge">{{ $kriteria->bobot * 100 }}%</span></td>
                <td class="action-buttons" style="text-align: right;">
                    <a href="{{ route('admin.kriteria.edit', $kriteria->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.kriteria.destroy', $kriteria->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus kriteria ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Hapus"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Belum ada data kriteria.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection