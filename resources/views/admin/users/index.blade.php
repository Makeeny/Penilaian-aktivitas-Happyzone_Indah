@extends('layouts.admin')

{{-- Judul halaman akan diambil dinamis dari Controller ($title) --}}
@section('title', $title)

@section('content')
<style>
    /* Style ini spesifik untuk halaman daftar akun */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .page-header h1 {
        font-size: 28px;
        font-weight: 600;
        color: #333;
    }
    .btn {
        text-decoration: none;
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
    }
    .btn-primary {
        background-color: #ff4d4f;
        color: white;
    }
    .btn-primary:hover {
        background-color: #d9363e;
    }
    .btn-secondary {
        background-color: #f0f2f5;
        color: #555;
        border: 1px solid #ddd;
    }
    .btn-secondary:hover {
        background-color: #e9ecef;
    }
    .data-table-card {
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.05);
    }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 16px 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
    .table th { font-weight: 600; font-size: 14px; color: #888; text-transform: uppercase; }
    .table td { font-size: 15px; color: #333; vertical-align: middle; }
    .table tbody tr:last-child td { border-bottom: none; }
    .role-badge { padding: 5px 12px; border-radius: 15px; font-size: 13px; color: #fff; font-weight: 500; }
    .role-admin { background: #ffc107; color: #333; }
    .role-guru { background: #8c5de6; }
    .role-siswa { background: #28a745; }
    .action-buttons a { margin: 0 8px; color: #888; font-size: 18px; text-decoration: none; }
    .action-buttons a:hover { color: #5D5FEF; }
    .alert-success { background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
</style>

<div class="page-header">
    <h1>{{ $title }}</h1>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
    </div>
</div>

{{-- Notifikasi jika ada pesan sukses --}}
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="data-table-card">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                </td>
                <td class="action-buttons">
                    <a href="{{ route('admin.users.edit', $user->id) }}"><i class="fas fa-edit"></i></a>
                    {{-- Tombol hapus tidak muncul untuk role admin sesuai desain --}}
                    @if($user->role !== 'admin')
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#888; cursor:pointer; padding:0; font-size:16px;" title="Hapus Data">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection