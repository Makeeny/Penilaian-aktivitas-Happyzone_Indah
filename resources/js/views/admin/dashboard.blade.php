@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    /* Style spesifik untuk elemen di halaman dashboard (tidak diubah) */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 10px;
    }
    .stat-card {
        background: linear-gradient(135deg, #868CFF, #5D5FEF);
        color: #fff;
        padding: 30px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 25px;
        box-shadow: 0 10px 20px rgba(93, 95, 239, 0.2);
    }
    .stat-card .icon {
        font-size: 48px;
        opacity: 0.8;
    }
    .stat-card .info h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 500;
    }
    .stat-card .info p {
        margin: 5px 0 0;
        font-size: 36px;
        font-weight: 700;
    }
    
    /* === BAGIAN STYLE BARU UNTUK PENGGANTI PANEL === */
    .section-header {
        margin-top: 40px;
        margin-bottom: 20px;
        font-size: 22px;
        font-weight: 600;
        color: #343a40;
    }
    .data-table-card {
        background: #fff;
        padding: 20px 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid #e9ecef;
    }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
    .table th { font-weight: 600; font-size: 14px; color: #888; text-transform: uppercase; }
    .table td { font-size: 15px; vertical-align: middle; }
    .table tbody tr:last-child td { border-bottom: none; }
    .role-badge { padding: 5px 12px; border-radius: 15px; font-size: 13px; color: #fff; font-weight: 500; }
    .role-admin { background: #ffc107; color: #333; }
    .role-guru { background: #8c5de6; }
    .role-siswa { background: #28a745; }
</style>

{{-- Kartu Statistik (Tidak Diubah) --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="info">
            <h4>Total Guru</h4>
            <p>{{ $totalGuru }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon"><i class="fas fa-user-graduate"></i></div>
        <div class="info">
            <h4>Total Siswa</h4>
            <p>{{ $totalSiswa }}</p>
        </div>
    </div>
</div>

{{-- === BAGIAN PANEL PENGELOLAAN DIHAPUS DAN DIGANTI DENGAN KODE DI BAWAH INI === --}}
<h2 class="section-header">Pengguna Terbaru</h2>
<div class="data-table-card">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Bergabung Pada</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penggunaTerbaru as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px;">Belum ada pengguna yang terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection