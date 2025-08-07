
<?php $__env->startSection('title', 'Buat Penilaian Baru'); ?>


<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="form-container-custom">
    <div class="header-custom">
        <h1>Penilaian Aktivitas Belajar Siswa</h1>
        <p>Isi form di bawah ini untuk menambahkan penilaian baru.</p>
    </div>

    <div class="form-card-custom">
        <div class="card-title-bar">
            
            <h3>Formulir Penilaian</h3>
            
            <a href="<?php echo e(route('guru.penilaian.index', $mapel)); ?>" class="back-button-custom">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                Kembali
            </a>
        </div>
    
        <?php if($errors->any()): ?>
        <div class="alert alert-danger mb-4" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px;">
            <strong style="font-weight: bold;">Whoops! Ada beberapa masalah dengan input Anda:</strong>
            <ul style="margin-top: 10px; padding-left: 20px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        
        <form action="<?php echo e(route('guru.penilaian.store.bulk')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-grid-custom">
                
                <div class="form-group-custom">
                    <label for="profil_siswa_id">Nama Siswa</label>
                    <select name="profil_siswa_id" id="profil_siswa_id" class="form-control-custom" required></select>
                </div>
                <div class="form-group-custom">
                    <label for="subject_id">Mata Pelajaran</label>
                    <select name="subject_id" id="subject_id" class="form-control-custom" required>
                        <?php $__currentLoopData = $mapels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e($item->id == $mapel->id ? 'selected' : ''); ?>><?php echo e($item->nama_mapel); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group-custom">
                    <label for="materi_pembelajaran">Materi Pembelajaran</label>
                    <input type="text" name="materi_pembelajaran" id="materi_pembelajaran" class="form-control-custom" placeholder="Contoh: Kuis Vocab 3" required>
                </div>
                <div class="form-group-custom">
                    <label for="tanggal">Tanggal Penilaian:</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control-custom" value="<?php echo e(date('Y-m-d')); ?>" required>
                </div>

                
                <div class="kriteria-info-box">
                    <h4>Informasi Bobot Kriteria</h4>
                    <ul class="kriteria-info-list">
                        <?php $__currentLoopData = $kriterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kriteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><strong><?php echo e($kriteria->kode_kriteria); ?>:</strong> <?php echo e($kriteria->nama_kriteria); ?> (<?php echo e($kriteria->jenis); ?>, Bobot: <?php echo e($kriteria->bobot); ?>)</li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                
                <div class="form-group-custom grid-full-width"><hr></div>
                
                <div class="form-group-custom">
                    <label for="penilaian_c1">Partisipasi Akademik (C1)</label>
                    <select name="penilaian[C1]" id="penilaian_c1" class="form-control-custom" required>
                        <option value="">Pilih Indikator...</option>
                        <option value="Sangat Aktif">Sangat Aktif</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Cukup Aktif">Cukup Aktif</option>
                        <option value="Kurang Aktif">Kurang Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="form-group-custom">
                    <label for="penilaian_c2">Kedisiplinan (C2)</label>
                    <select name="penilaian[C2]" id="penilaian_c2" class="form-control-custom" required>
                        <option value="">Pilih Indikator...</option>
                        <option value="Sangat Disiplin">Sangat Disiplin</option>
                        <option value="Disiplin">Disiplin</option>
                        <option value="Cukup Disiplin">Cukup Disiplin</option>
                        <option value="Kurang Disiplin">Kurang Disiplin</option>
                    </select>
                </div>
                
                <div class="form-group-custom">
                    <label for="penilaian_c3">Etika dan Perilaku (C3)</label>
                    <select name="penilaian[C3]" id="penilaian_c3" class="form-control-custom" required>
                        <option value="">Pilih Indikator...</option>
                        <option value="Sangat baik">Sangat baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Cukup baik">Cukup baik</option>
                        <option value="Kurang baik">Kurang baik</option>
                    </select>
                </div>

                <div class="form-group-custom">
                    <label for="penilaian_c4">Tugas Yang Tidak Dikerjakan (C4)</label>
                    <select name="penilaian[C4]" id="penilaian_c4" class="form-control-custom" required>
                        <option value="">Pilih Indikator...</option>
                        <option value="≤ 5 Tugas">≤ 5 Tugas</option>
                        <option value="≥ 5 – 10 Tugas">≥ 5 – 10 Tugas</option>
                     98    <option value="≥ 10 – 15 Tugas">≥ 10 – 15 Tugas</option>
                    </select>
                </div>

                <?php $__currentLoopData = $kriterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kriteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="form-group-custom">
                    <label for="penilaian_<?php echo e(strtolower($kriteria->kode_kriteria)); ?>"><?php echo e($kriteria->nama_kriteria); ?> (<?php echo e($kriteria->kode_kriteria); ?>)</label>
                    
                    <input type="number"
                           id="nilai_<?php echo e(strtolower($kriteria->kode_kriteria)); ?>"
                           name="nilai_mentah[<?php echo e($kriteria->id); ?>]"
                           class="form-control-custom nilai-kriteria"
                           placeholder="Nilai 1-100"
                           min="0" max="100" required
                           
                           data-bobot="<?php echo e($kriteria->bobot); ?>"
                           data-kode="<?php echo e($kriteria->kode_kriteria); ?>">
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <div class="form-group-custom grid-full-width">
                    <label for="poin_hasil_display">Total Poin Hasil (Preferensi)</label>
                    <input type="text" id="poin_hasil_display" class="form-control-custom" readonly style="font-weight: bold; background-color: #e9ecef;">
                </div>

                
                <div class="form-group-custom grid-full-width">
                    <label for="feedback">Feedback :</label>
                    <textarea name="feedback" id="feedback" class="form-control-custom" placeholder="Tulis feedback untuk siswa..."></textarea>
                </div>
                
                <div class="form-footer-custom">
                    <button type="submit" class="btn-submit-custom">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        // --- Inisialisasi Select2 ---
        $('#subject_id').select2({ width: '100%' });
        $('#profil_siswa_id').select2({
        placeholder: "Ketik nama siswa untuk mencari...",
        minimumInputLength: 2,
        width: '100%',
        ajax: {
            url: "<?php echo e(route('guru.students.search')); ?>",
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guru', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\happy-zone-final\resources\views/guru/penilaian/create.blade.php ENDPATH**/ ?>