@extends('layouts.siswa')
@section('title', $title)

@section('styles')
<style>
    .report-container { max-width: 900px; margin: 0 auto; }
    .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .report-header h1 { font-size: 24px; font-weight: 700; margin: 0; }
    .report-header h1 span { color: #6a5ae0; }
    .back-button { display: flex; align-items: center; gap: 8px; text-decoration: none; color: #555; font-weight: 500; }
    .report-card { background-color: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px;}
    .table-detail { width: 100%; border-collapse: separate; border-spacing: 0 5px; }
    .table-detail th, .table-detail td { padding: 15px; text-align: left; }
    .table-detail th { font-weight: 600; font-size: 14px; color: #777; text-transform: uppercase; border-bottom: 2px solid #f0f0f0; }
    .table-detail tbody tr { background-color: #fdfdfd; }
    .table-detail td:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
    .table-detail td:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
    .table-detail td a { color: #333; text-decoration: none; font-weight: 600; }
    .badge-poin { background-color: #fffbe6; color: #faad14; padding: 4px 12px; border-radius: 20px; font-weight: 700; }
    
    .points-grid { border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px; }
    .points-grid h3 { text-align: center; margin-bottom: 20px; font-size: 1.5rem; font-weight: 600; }
    .grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); gap: 10px; }
    .point-box { background: #f8f9fa; border: 1px solid #eee; border-radius: 8px; padding: 15px; text-align: center; font-weight: 700; font-size: 1.2rem; }
    .action-buttons { display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px; }
    .btn-action { padding: 12px 25px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;}
    .btn-unduh { background-color: #ff4d4f; color: white; height: 48px; }
    .btn-unduh:hover { background-color: #bf0710; }
    .btn-tukar { background-color: #6a5ae0; color: white; height: 48px; }
    .btn-tukar:hover { background-color: #5505d6; }

    /* ========================================================== */
    /* == CSS POP-UP SEKARANG ADA DI SINI == */
    /* ========================================================== */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex; justify-content: center; align-items: center;
        z-index: 1000; opacity: 0; visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
    }
    .modal-overlay.show {
        opacity: 1; visibility: visible;
    }
    .modal-content {
        background-color: white; padding: 30px; border-radius: 15px;
        width: 90%; max-width: 400px; text-align: center;
        transform: scale(0.9); transition: transform 0.3s;
    }
    .modal-overlay.show .modal-content { transform: scale(1); }
    .modal-icon { width: 40px; height: 40px; line-height: 40px; background-color: #fefce8; color: #facc15; border-radius: 50%; margin: 0 auto 15px auto; font-size: 20px; }
    .modal-title { background-color: #fefce8; color: #a16207; padding: 5px 15px; border-radius: 20px; font-weight: 700; display: inline-block; margin-bottom: 15px; }
    .modal-body p { color: #555; line-height: 1.6; margin-bottom: 25px; }
    .modal-buttons { display: flex; gap: 15px; justify-content: center; }
    .modal-button { border: none; padding: 10px 30px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 15px; }
    .btn-danger { background-color: #ff4d4f; color: white; }


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
<div class="report-container">
    <div class="report-header">
        <h1>Detail Laporan Penilaian : <span>{{ $subject->nama_mapel }}</span></h1>
        {{-- Tombol ini kembali ke halaman daftar penilaian sebelumnya --}}
        <a href="{{ route('siswa.penilaian.show', $subject->id) }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="report-card">
        <div class="table-responsive">
            <table class="table-detail">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Aktivitas</th>
                        <th>Tanggal</th>
                        <th>Nilai Siswa</th>
                        <th>Total Poin</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penilaian as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><a href="#">{{ $item->profilSiswa->nama_lengkap }}</a></td>
                        <td>{{ $item->aktivitas }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->nilai_siswa }}</td>
                        <td><span class="badge-poin">+{{ round($item->poin) }}</span></td>
                        <td>{{ $item->feedback ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 40px;">Belum ada data penilaian untuk ditampilkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="report-card points-grid">
        <h3>Point Siswa</h3>
        <div class="grid-container">
            {{-- Menampilkan total poin siswa di mapel ini --}}
            <div class="point-box" style="grid-column: 1 / -1; font-size: 2rem; background-color: #f0f0ff;">
                Total: {{ round($totalPoin) }} Poin
            </div>
        </div>
        <div class="action-buttons">
            <a href="{{ route('siswa.laporan.download', ['profilSiswa' => $siswa->id, 'subject_id' => $subject->id]) }}" class="btn-action btn-unduh">
                <i class="fas fa-download"></i> Unduh
            </a>
            {{-- Form ini sekarang memiliki ID dan akan di-submit oleh JavaScript --}}
            <form id="formTukarPoin" action="{{ route('siswa.tukar-poin') }}" method="POST" style="display: none;">
                @csrf
            </form>

            {{-- Tombol ini sekarang hanya bertugas untuk memanggil fungsi bukaModal() --}}
            <button type="button" class="btn-action btn-tukar" onclick="bukaModal('konfirmasiTukarPoinModal')">
                <i class="fas fa-exchange-alt"></i> Tukar Poin
            </button>

            {{-- ========================================================== --}}
            {{-- == HTML POP-UP SEKARANG ADA DI SINI == --}}
            {{-- ========================================================== --}}
            <div id="konfirmasiTukarPoinModal" class="modal-overlay">
                <div class="modal-content">
                    <div class="modal-icon"><i class="fas fa-info"></i></div>
                    <h3 class="modal-title">KONFIRMASI Tukar Poin</h3>
                    <div class="modal-body">
                        <p>Konfirmasi Penukaran Poin kamu? Jika Kamu memilih "Ya" maka Poinmu akan berkurang dan kamu akan mendapatkan stuffs, dan jika memilih "Tidak" maka Poinmu akan kembali tersimpan.</p>
                    </div>
                    <div class="modal-buttons">
                        <button type="button" class="modal-button btn-primary" onclick="tutupModal('konfirmasiTukarPoinModal')">Tidak</button>
                        <button type="button" id="btnYaTukarPoin" class="modal-button btn-danger">Ya</button>
                    </div>
                </div>
            </div>

            @push('scripts')
            <script>
                 // Fungsi untuk menampilkan dan menyembunyikan pop-up
                function bukaModal(idModal) {
                    document.getElementById(idModal).classList.add('show');
                }
                function tutupModal(idModal) {
                    document.getElementById(idModal).classList.remove('show');
                }

                // Hanya dijalankan setelah halaman siap
                $(document).ready(function() {
                    // Event listener untuk tombol "Ya" di dalam pop-up
                    $('#btnYaTukarPoin').on('click', function() {
                        // Submit form tersembunyi
                        $('#formTukarPoin').submit();
                    });
                });
            </script>
            @endpush
        </div>
    </div>
</div>
@endsection