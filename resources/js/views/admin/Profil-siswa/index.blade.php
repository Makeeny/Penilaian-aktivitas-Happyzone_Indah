@extends('layouts.admin')

@section('title', 'Daftar Profil Siswa')

@section('content')
<style>
    /* Menggunakan style yang mirip dengan halaman daftar akun untuk konsistensi */
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .page-header h1 { font-size: 28px; font-weight: 600; }
    .btn { text-decoration: none; padding: 10px 22px; border-radius: 8px; font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; }
    .btn-primary { background-color: #ff4d4f; color: white; }
    .btn-secondary { background-color: #f0f2f5; color: #555; border: 1px solid #ddd; }
    .data-table-card { background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 16px 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
    .table th { font-weight: 600; font-size: 14px; color: #888; text-transform: uppercase; }
    .table td { font-size: 15px; vertical-align: middle; }
    .table thead { background-color: #f8f9fa; }
    .table tbody tr:last-child td { border-bottom: none; }
    .role-badge { padding: 5px 12px; border-radius: 15px; font-size: 13px; font-weight: 500; }
    .role-siswa { background-color: #e7f7f4; color: #20a17b; }
    .action-buttons a { margin: 0 8px; color: #888; font-size: 18px; text-decoration: none; }
    .action-buttons a:hover { color: #5D5FEF; }
    .action-buttons a.delete:hover { color: #ff4d4f; }
    .alert-success { background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
</style>

<div class="page-header">
    <h1>Daftar Profil Siswa</h1>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.profil-siswa.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="data-table-card">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Email</th>
                {{-- Catatan: Kolom Mapel akan ditambahkan nanti setelah ada relasinya --}}
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($profils as $profil)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $profil->nama_lengkap }}</td>
                <td>{{ $profil->user->email ?? 'Email tidak tersedia' }}</td>
                <td>
                    <span class="role-badge role-siswa">{{ ucfirst($profil->user->role ?? 'Siswa') }}</span>
                </td>
                <td class="action-buttons">
                {{-- Tombol Edit mengarah ke rute 'users.edit' --}}
                <a href="{{ route('admin.users.edit', $profil->user) }}" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>

                {{-- Form untuk Tombol Hapus mengarah ke rute 'users.destroy' --}}
                <form action="{{ route('admin.users.destroy', $profil->user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Anda yakin ingin menghapus akun ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:#888; cursor:pointer; padding:0;" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
            </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data profil siswa ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
