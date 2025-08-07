@extends('layouts.guru')
@section('title', $title)

@section('styles')
<style>
    .report-container { max-width: 900px; margin: 0 auto; }
    .report-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px;
    }
    .report-header h1 { font-size: 24px; font-weight: 700; margin: 0; }
    .report-header h1 span { color: #6a5ae0; }
    .back-button { display: flex; align-items: center; gap: 8px; text-decoration: none; color: #555; font-weight: 500; }
    .report-card { background-color: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .table-detail { width: 100%; border-collapse: collapse; }
    .table-detail th, .table-detail td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
    .table-detail th { font-weight: 600; font-size: 14px; background-color: #f8f9fa; }
    .badge-poin { background-color: #fff8e1; color: #f59e0b; padding: 4px 10px; border-radius: 20px; font-weight: 700; }
</style>
@endsection

@section('content')
<div class="report-container">
    <div class="report-header">
        <h1>Detail Laporan Penilaian : <span>{{ $mapelTerfilter->nama_mapel ?? 'Semua Mapel' }}</span></h1>
        <a href="{{ url()->previous() }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="report-card">
        <h4>Nama Siswa: <strong>{{ $siswa->nama_lengkap }}</strong></h4>
        <hr class="my-3">
        <div class="table-responsive">
            <table class="table-detail">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aktivitas</th>
                        <th>Tanggal</th>
                        <th>Nilai Siswa</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penilaian as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->aktivitas }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->nilai_siswa }}</td>
                        <td>{{ $item->feedback ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data penilaian untuk ditampilkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
