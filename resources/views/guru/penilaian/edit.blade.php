@extends('layouts.guru')
@section('title', 'Edit Penilaian Siswa')

{{-- Menggunakan style yang sama persis dengan halaman create --}}
@section('styles')
<style>
    /* Variabel warna agar konsisten */
    :root {
        --primary-color: #6a5ae0;
        --secondary-color: #FD259C;
        --text-dark: #333;
        --text-light: #555;
        --bg-light: #f4f7f6;
        --border-color: #ddd;
    }

    /* Styling khusus halaman ini */
    .form-container-custom {
        max-width: 900px;
        margin: 0 auto;
        font-family: 'Poppins', sans-serif;
    }

    .header-custom {
        background-color: var(--primary-color);
        color: white;
        padding: 20px 40px;
        border-radius: 20px;
        margin-bottom: 30px;
        text-align: center;
    }
    .header-custom h1 { font-size: 1.8rem; font-weight: 700; margin: 0; }
    .header-custom p { margin: 5px 0 0 0; opacity: 0.9; }

    .form-card-custom {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        position: relative;
    }
    
    .card-title-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .card-title-bar h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }

    .back-button-custom {
        display: flex; align-items: center; gap: 8px;
        text-decoration: none; color: var(--text-light);
        font-weight: 500; transition: color 0.3s;
    }
    .back-button-custom:hover { color: var(--primary-color); }
    .back-button-custom svg { width: 20px; height: 20px; }

    .form-grid-custom {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px 30px;
    }
    
    .grid-full-width { grid-column: 1 / -1; }

    .form-group-custom label {
        display: block; margin-bottom: 8px;
        font-weight: 600; color: var(--text-dark);
    }

    .form-control-custom {
        width: 100%; padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 10px; font-size: 1rem;
    }
    .form-control-custom:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(106, 90, 224, 0.2);
        outline: none;
    }
    .form-control-custom[readonly] {
        background-color: #e9ecef;
        cursor: not-allowed;
    }

    textarea.form-control-custom { min-height: 120px; resize: vertical; }
    
    .form-footer-custom {
        grid-column: 1 / -1;
        text-align: right;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn-submit-custom {
        background-color: var(--secondary-color);
        color: white; border: none; padding: 12px 30px;
        font-size: 1rem; font-weight: 600;
        border-radius: 25px; cursor: pointer;
        transition: all 0.2s;
    }
    .btn-submit-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(253, 37, 156, 0.3);
    }

    /* Info Kriteria */
    .kriteria-info-box {
        grid-column: 1 / -1;
        background-color: #f8f9fa;
        padding: 15px 20px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        margin-bottom: 10px;
    }
    .kriteria-info-box h4 {
        margin: 0 0 10px 0;
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary-color);
    }
    .kriteria-info-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 10px 20px;
        font-size: 0.9rem;
    }

    /* Styling untuk Select2 agar cocok dengan tema */
    .select2-container .select2-selection--single { height: 48px !important; border: 1px solid var(--border-color) !important; border-radius: 10px !important; display: flex; align-items: center; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: inherit !important; padding-left: 12px !important; color: #444; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { top: 50% !important; transform: translateY(-50%) !important; }
    .select2-container--default .select2-results__option--highlighted[aria-selected] { background-color: var(--primary-color); }
    
    /* Aturan untuk layar dengan lebar maksimal 768px (Tablet) */
@media (max-width: 1000px) {
    /* Ubah grid form menjadi 1 kolom */
    .form-grid-custom {
        grid-template-columns: 1fr;
    }
@media (max-width: 600px) {
        /* Untuk layar ponsel */
        .header-custom {
            padding: 20px;
            font-size: 90%; /* Kecilkan sedikit font di header */
        }
        .form-card-custom {
            padding: 20px; /* Kurangi padding di kartu form */
        }
        .card-title-bar {
            flex-direction: column; /* Buat judul dan tombol kembali menjadi vertikal */
            align-items: flex-start;
            gap: 15px;
    }

    /* Kurangi padding pada kartu form */
    .form-card-custom {
        padding: 25px;
    }

    /* Kurangi ukuran font judul header */
    .header-custom h1 {
        font-size: 1.5rem;
    }
    .header-custom p {
        font-size: 1rem;
    }
}

/* Aturan untuk layar dengan lebar maksimal 576px (HP) */
@media (max-width: 576px) {
    /* Kurangi lagi padding di header dan kartu */
    .header-custom {
        padding: 20px;
    }
    .form-card-custom {
        padding: 20px;
    }

    /* Buat tombol submit mengisi lebar penuh */
    .form-footer-custom {
        text-align: center;
    }
    .btn-submit-custom {
        width: 100%;
    }
}
</style>
@endsection

@section('content')
<div class="form-container-custom">
    <div class="header-custom">
        <h1>Edit Penilaian Siswa</h1>
        <p>Ubah data pada form di bawah ini untuk siswa <strong>{{ $assessment->profilSiswa->nama_lengkap }}</strong>.</p>
    </div>
    {{-- ========================================================== --}}
    {{-- == TAMBAHKAN BLOK KODE INI UNTUK MENAMPILKAN ERROR == --}}
    {{-- ========================================================== --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px;">
            <strong style="font-weight: bold;">Whoops! Ada beberapa masalah dengan input Anda:</strong>
            <ul style="margin-top: 10px; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- ========================================================== --}}

    <div class="form-card-custom">
        <div class="card-title-bar">
            <h3>Formulir Edit Penilaian</h3>
            <a href="{{ url()->previous() }}" class="back-button-custom">Kembali</a>
        </div>

        <form action="{{ route('guru.penilaian.update', $assessment->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-grid-custom">
                {{-- Detail Siswa, Pelajaran, dan Tanggal (Readonly) --}}
                <div class="form-group-custom">
                    <label>Nama Siswa</label>
                    <input type="text" class="form-control-custom" value="{{ $assessment->profilSiswa->nama_lengkap }}" readonly>
                </div>
                <div class="form-group-custom">
                    <label>Mata Pelajaran</label>
                    <input type="text" class="form-control-custom" value="{{ $assessment->subject->nama_mapel }}" readonly>
                </div>
                <div class="form-group-custom">
                    <label for="materi_pembelajaran">Materi Pembelajaran / Aktivitas</label>
                    <input type="text" name="materi_pembelajaran" id="materi_pembelajaran" class="form-control-custom" value="{{ old('materi_pembelajaran', $assessment->aktivitas) }}" required>
                </div>
                <div class="form-group-custom">
                    <label>Tanggal Penilaian</label>
                    <input type="text" class="form-control-custom" value="{{ \Carbon\Carbon::parse($assessment->tanggal)->format('d F Y') }}" readonly>
                </div>

                <div class="kriteria-info-box">
                    <h4>Informasi Bobot Kriteria</h4>
                    <ul class="kriteria-info-list">
                       @foreach($kriterias as $kriteria)
                            <li><strong>{{$kriteria->kode_kriteria}}:</strong> {{$kriteria->nama_kriteria}} ({{$kriteria->jenis}}, Bobot: {{$kriteria->bobot}})</li>
                       @endforeach
                    </ul>
                </div>

                {{-- Kriteria Penilaian --}}
                {{-- NOTE: Perubahan utama ada di dalam value dan option di bawah ini --}}
                <div class="form-group-custom">
                    <label for="indikator_c1">Partisipasi Akademik (C1) - Indikator</label>
                     <select name="indikator[C1]" id="indikator_c1" class="form-control-custom" required>
                        <option value="Sangat Aktif" {{ old('indikator.C1', $assessment->indikator_c1) == 'Sangat Aktif' ? 'selected' : '' }}>Sangat Aktif</option>
                        <option value="Aktif" {{ old('indikator.C1', $assessment->indikator_c1) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Cukup Aktif" {{ old('indikator.C1', $assessment->indikator_c1) == 'Cukup Aktif' ? 'selected' : '' }}>Cukup Aktif</option>
                        <option value="Kurang Aktif" {{ old('indikator.C1', $assessment->indikator_c1) == 'Kurang Aktif' ? 'selected' : '' }}>Kurang Aktif</option>
                        <option value="Tidak Aktif" {{ old('indikator.C1', $assessment->indikator_c1) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="form-group-custom">
                    <label for="nilai_c1">Partisipasi Akademik (C1) - Nilai</label>
                    <input type="number" name="nilai_mentah[1]" id="nilai_c1" class="form-control-custom nilai-kriteria" value="{{ old('nilai_mentah.1', $assessment->nilai_c1) }}" data-bobot="{{ $kriterias->firstWhere('kode_kriteria', 'C1')->bobot }}" required>
               </div>

                <div class="form-group-custom">
                    <label for="indikator_c2">Kedisiplinan (C2) - Indikator</label>
                    <select name="indikator[C2]" id="indikator_c2" class="form-control-custom" required>
                        <option value="Sangat Disiplin" {{ old('indikator.C2', $assessment->indikator_c2) == 'Sangat Disiplin' ? 'selected' : '' }}>Sangat Disiplin</option>
                        <option value="Disiplin" {{ old('indikator.C2', $assessment->indikator_c2) == 'Disiplin' ? 'selected' : '' }}>Disiplin</option>
                        <option value="Cukup Disiplin" {{ old('indikator.C2', $assessment->indikator_c2) == 'Cukup Disiplin' ? 'selected' : '' }}>Cukup Disiplin</option>
                        <option value="Kurang Disiplin" {{ old('indikator.C2', $assessment->indikator_c2) == 'Kurang Disiplin' ? 'selected' : '' }}>Kurang Disiplin</option>
                    </select>
                </div>
                <div class="form-group-custom">
                    <label for="nilai_c2">Kedisiplinan (C2) - Nilai</label>
                    <input type="number" name="nilai_mentah[2]" id="nilai_c2" class="form-control-custom nilai-kriteria" value="{{ old('nilai_mentah.2', $assessment->nilai_c2) }}" data-bobot="{{ $kriterias->firstWhere('kode_kriteria', 'C2')->bobot }}" required>
                </div>

                <div class="form-group-custom">
                    <label for="indikator_c3">Etika dan Perilaku (C3) - Indikator</label>
                    <select name="indikator[C3]" id="indikator_c3" class="form-control-custom" required>
                        <option value="Sangat baik" {{ old('indikator.C3', $assessment->indikator_c3) == 'Sangat baik' ? 'selected' : '' }}>Sangat baik</option>
                        <option value="Baik" {{ old('indikator.C3', $assessment->indikator_c3) == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Cukup baik" {{ old('indikator.C3', $assessment->indikator_c3) == 'Cukup baik' ? 'selected' : '' }}>Cukup baik</option>
                        <option value="Kurang baik" {{ old('indikator.C3', $assessment->indikator_c3) == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                    </select>
                </div>
                <div class="form-group-custom">
                    <label for="nilai_c3">Etika dan Perilaku (C3) - Nilai</label>
                    <input type="number" name="nilai_mentah[3]" id="nilai_c3" class="form-control-custom nilai-kriteria" value="{{ old('nilai_mentah.3', $assessment->nilai_c3) }}" data-bobot="{{ $kriterias->firstWhere('kode_kriteria', 'C3')->bobot }}" required>
                </div>

                <div class="form-group-custom">
                    <label for="indikator_c4">Tugas Tdk Dikerjakan (C4) - Indikator</label>
                    <select name="indikator[C4]" id="indikator_c4" class="form-control-custom" required>
                        <option value="≤ 5 Tugas" {{ old('indikator.C4', $assessment->indikator_c4) == '≤ 5 Tugas' ? 'selected' : '' }}>≤ 5 Tugas</option>
                        <option value="≥ 5 – 10 Tugas" {{ old('indikator.C4', $assessment->indikator_c4) == '≥ 5 – 10 Tugas' ? 'selected' : '' }}>≥ 5 – 10 Tugas</option>
                        <option value="≥ 10 – 15 Tugas" {{ old('indikator.C4', $assessment->indikator_c4) == '≥ 10 – 15 Tugas' ? 'selected' : '' }}>≥ 10 – 15 Tugas</option>
                    </select>
                </div>
                <div class="form-group-custom">
                   <label for="nilai_c4">Tugas Tdk Dikerjakan (C4) - Nilai</label>
                   <input type="number" name="nilai_mentah[4]" id="nilai_c4" class="form-control-custom nilai-kriteria" value="{{ old('nilai_mentah.4', $assessment->nilai_c4) }}" data-bobot="{{ $kriterias->firstWhere('kode_kriteria', 'C4')->bobot }}" required>
                </div>

                
                <div class="form-group-custom grid-full-width">
                    <label for="poin_hasil_display">Total Poin Hasil (Otomatis)</label>
                    <input type="text" id="poin_hasil_display" name="total_poin" class="form-control-custom" value="{{ old('total_poin', $assessment->total_poin) }}" readonly style="font-weight: bold; background-color: #e9ecef;">
                </div>

                <div class="form-group-custom grid-full-width">
                    <label for="feedback">Feedback:</label>
                    <textarea name="feedback" id="feedback" class="form-control-custom">{{ old('feedback', $assessment->feedback) }}</textarea>
                </div>

                <div class="form-footer-custom">
                    <button type="submit" class="btn-submit-custom">Update Penilaian</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // --- Inisialisasi Select2 ---
        $('#subject_id').select2({ width: '100%' });
        $('#profil_siswa_id').select2({
        placeholder: "Ketik nama siswa untuk mencari...",
        minimumInputLength: 2,
        width: '100%',
        ajax: {
            url: "{{ route('guru.students.search') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) { return { results: data }; },
            cache: true
        }
    });

        //--- Logika untuk Field Otomatis ---//
        const kriteriaSelect = document.getElementById('kriteria_id');
        const nilaiInput = document.getElementById('nilai_mentah');
        
        // Input untuk display (readonly)
        const kodeInput = document.getElementById('kode');
        const bobotInput = document.getElementById('bobot');
        const jenisInput = document.getElementById('jenis');
        const poinDisplayInput = document.getElementById('poin_hasil_display');

        // Input tersembunyi untuk dikirim ke controller
        const poinValueInput = document.getElementById('poin_hasil_value');

        
     // NOTE: Fungsi utama untuk menghitung total poin secara otomatis.
    function calculateTotalPoin() {
        let totalPoin = 0;
        // NOTE: Kita loop setiap input yang memiliki class '.nilai-kriteria'.
        $('.nilai-kriteria').each(function() {
            const nilaiInput = $(this).val();
            const bobot = $(this).data('bobot'); // Mengambil bobot dari data atribut

            // NOTE: Memastikan nilai dan bobot adalah angka yang valid sebelum menghitung.
            if (nilaiInput && !isNaN(parseFloat(nilaiInput)) && !isNaN(parseFloat(bobot))) {
                const nilai = parseFloat(nilaiInput);
                const poin = nilai * bobot; // Poin = Nilai x Bobot
                totalPoin += poin;
            }
        });

        // NOTE: Menampilkan hasil total poin di field readonly dengan 2 angka desimal.
        $('#poin_hasil_display').val(totalPoin.toFixed(2));
    }

    // NOTE: Memicu fungsi kalkulasi setiap kali ada perubahan pada input nilai
    // 'input' event akan berjalan setiap kali pengguna mengetik
    $(document).on('input', '.nilai-kriteria', calculateTotalPoin);
    });
</script>
@endpush