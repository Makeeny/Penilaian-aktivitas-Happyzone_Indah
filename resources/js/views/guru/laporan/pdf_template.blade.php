<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Laporan Penilaian</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .header h1 { font-size: 18px; text-align: center; }
        .header h1 span { color: #6a5ae0; }
        .info { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detail Laporan Penilaian : <span>{{ $mapelTerfilter->nama_mapel ?? 'Semua Mapel' }}</span></h1>
    </div>
    <div class="info">
        <p>Nama Siswa: <strong>{{ $siswa->nama_lengkap }}</strong></p>
    </div>
    <table class="table">
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
                <td colspan="5" style="text-align: center;">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
