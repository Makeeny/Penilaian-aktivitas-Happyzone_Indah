<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penilaian {{ $siswa->nama_lengkap }}</title>
    <style>
        /* CSS untuk PDF */
        @page { margin: 25px; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            position: relative;
        }
        .header img {
            position: absolute;
            left: 0;
            top: 0;
            height: 60px;
        }
        .header .address {
            display: inline-block;
            text-align: center;
        }
        .header h1 { font-size: 18px; margin: 0; }
        .header p { font-size: 10px; margin: 2px 0; }

        .student-info {
            margin-top: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 5px;
        }
        .student-info table { width: 300px; border-collapse: collapse; }
        .student-info td { padding: 3px 5px; }
        
        .detail-title { margin-top: 30px; font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        .detail-title span { color: #6a5ae0; }
        
        .table-detail { width: 100%; border-collapse: collapse; }
        .table-detail th, .table-detail td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .table-detail th { background-color: #f2f2f2; font-weight: bold; }
        .badge-poin { background-color: #fffbe6; color: #faad14; padding: 2px 8px; border-radius: 10px; font-weight: bold; }

        .page-break { page-break-after: always; }

        .points-grid h3 { text-align: center; margin-bottom: 20px; font-size: 16px; font-weight: bold;}
        .grid-container {
            width: 100%;
            border-collapse: collapse;
        }
        .grid-container td {
            border: 1px solid #ccc;
            height: 50px; /* Tinggi setiap kotak poin */
            width: 12.5%; /* Membagi menjadi 8 kolom */
        }
    </style>
</head>
<body>
    {{-- Halaman 1: Detail Penilaian --}}
    <div class="header">
        <img src="{{ public_path('images/logohappyzone.png') }}" alt="Logo">
        <div class="address">
            <h1>Happy Zone For Education</h1>
            <p>Jl. Residen H. Najamuddin, Komplek Raflessia, Suka maju, Kec. Sako, Kota Palembang</p>
            <p>Telp: (0711) 123-456 | Email: info@happyzone.com</p>
        </div>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td><strong>Nama Siswa</strong></td>
                <td>: {{ $siswa->nama_lengkap }}</td>
            </tr>
            <tr>
                <td><strong>Kelas/Mapel</strong></td>
                <td>: {{ $subject->nama_mapel ?? 'Semua Mapel' }}</td>
            </tr>
             <tr>
                <td><strong>Guru</strong></td>
                <td>: {{ $guru }}</td>
            </tr>
        </table>
    </div>

    <h2 class="detail-title">Detail Laporan Penilaian</h2>
    <table class="table-detail">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Aktivitas</th>
                <th>Nilai</th>
                <th>Total Poin</th>
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penilaian as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $item->aktivitas }}</td>
                <td>{{ $item->nilai_siswa }}</td>
                <td><span class="badge-poin">+{{ round($item->poin) }}</span></td>
                <td>{{ $item->feedback ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data penilaian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Perintah untuk pindah ke halaman baru --}}
    <div class="page-break"></div>

    {{-- Halaman 2: Point Siswa --}}
    <div class="header">
        <img src="{{ public_path('images/logohappyzone.png') }}" alt="Logo">
        <div class="address">
            <h1>Happy Zone For Education</h1>
            <p>Jl. Residen H. Najamuddin, Komplek Raflessia, Suka maju, Kec. Sako, Kota Palembang</p>
            <p>Telp: (0711) 123-456 | Email: info@happyzone.com</p>
        </div>
    </div>
    
    <div class="points-grid">
        <h3>Point Siswa</h3>
        <table class="grid-container">
            {{-- Membuat 3 baris grid --}}
            @for ($i = 0; $i < 3; $i++)
            <tr>
                {{-- Membuat 8 kolom grid --}}
                @for ($j = 0; $j < 8; $j++)
                <td></td>
                @endfor
            </tr>
            @endfor
        </table>
    </div>

</body>
</html>