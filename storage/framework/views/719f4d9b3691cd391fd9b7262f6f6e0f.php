
<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* CSS untuk membuat halaman responsif dan memperbaiki layout */
    :root {
        --primary-color: #6a5ae0;
        --primary-light: #f0f0ff;
    }
    .header-laporan {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .header-laporan h1 { font-size: 24px; font-weight: 700; margin: 0; }
    .back-button { display: flex; align-items: center; gap: 8px; text-decoration: none; color: #555; font-weight: 500; padding: 8px 12px; border-radius: 8px; transition: background-color 0.2s; }
    .back-button:hover { background-color: #eee; }
    
    /* === BAGIAN YANG DIUBAH: Layout Filter Horizontal === */
    .filter-card {
        background-color: #fff;
        padding: 20px 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    .filter-form {
        display: flex;
        flex-wrap: wrap; /* Agar responsif di layar kecil */
        gap: 20px;
        align-items: center;
    }
    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .filter-group label {
        font-weight: 600;
        font-size: 15px;
        white-space: nowrap; /* Mencegah label turun baris */
    }
    .filter-group .form-control {
        padding: 10px 15px;      /* Memberi ruang di dalam box agar lebih besar */
        font-size: 15px;         /* Menyamakan ukuran font */
        border: 1px solid #ccc;  /* Memberi batas yang jelas */
        border-radius: 8px;      /* Menyamakan lengkungan sudut */
        height: 48px;            /* Menyamakan tinggi dengan tombol */
        box-sizing: border-box;  /* Kalkulasi ukuran yang benar */
        background-color: #fff;  /* Pastikan background putih */
        min-width: 300px;        /* Beri lebar minimal */
    }
    .btn-filter {
        background-color: var(--primary-color);
        color: white; border: none; padding: 12px 25px;
        border-radius: 8px; font-weight: 600; cursor: pointer;
        height: 48px; margin-left: auto; /* Mendorong tombol ke kanan */
    }
    
    .table-card { background-color: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .table-responsive { overflow-x: auto; }
    .table-laporan { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .table-laporan th, .table-laporan td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
    .table-laporan th { font-weight: 600; font-size: 14px; background-color: #f8f9fa; }
    .table-laporan td { font-size: 15px; }
    .badge-nilai { display: inline-block; padding: 5px 12px; border-radius: 20px; font-weight: 700; background-color: var(--primary-light); color: var(--primary-color); }
    .action-icons a { color: #555; margin: 0 5px; text-decoration: none; }

    /* Tampilan Responsif */
    @media (max-width: 992px) {
        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }
        .btn-filter {
            margin-left: 0;
            width: 100%;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="header-laporan">
    <h1><?php echo e($title); ?></h1>
    <a href="<?php echo e(route('guru.dashboard')); ?>" class="back-button">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Dashboard</span>
    </a>
</div>


<div class="filter-card">
    <form method="GET" action="<?php echo e(route('guru.laporan.index')); ?>" class="filter-form">
        <div class="filter-group">
            <label for="subject_id">Mata Pelajaran:</label>
            <select name="subject_id" id="subject_id" class="form-control">
                <option value="">Semua</option>
                <?php $__currentLoopData = $mapels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mapel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($mapel->id); ?>" <?php echo e(request('subject_id') == $mapel->id ? 'selected' : ''); ?>>
                        <?php echo e($mapel->nama_mapel); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="filter-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo e(request('tanggal')); ?>">
        </div>
        <button type="submit" class="btn-filter">Terapkan Filter</button>
    </form>
</div>


<div class="table-card">
    <div class="table-responsive">
        <table class="table-laporan">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Nilai Akhir (V)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $hasilPeringkat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peringkat => $hasil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                    <?php if($hasil['nilai_akhir'] > 1 || request()->hasAny(['subject_id', 'tanggal'])): ?>
                        <tr>
                            <td><?php echo e($peringkat + 1); ?></td>
                            <td><strong><?php echo e($hasil['siswa']->nama_lengkap); ?></strong></td>
                            <td><?php echo e($hasil['siswa']->user->email); ?></td>
                            <td><span class="badge-nilai"><?php echo e(number_format($hasil['nilai_akhir'], 2)); ?></span></td>
                            <td class="action-icons">

                                
                                <a href="<?php echo e(route('guru.laporan.show', ['profilSiswa' => $hasil['siswa']->id, 'subject_id' => request('subject_id'), 'tanggal' => request('tanggal')])); ?>" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="<?php echo e(route('guru.laporan.download', ['profilSiswa' => $hasil['siswa']->id, 'subject_id' => request('subject_id'), 'tanggal' => request('tanggal')])); ?>" title="Unduh Laporan">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">
                            Tidak ada data penilaian yang ditemukan untuk filter yang dipilih.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guru', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\happy-zone-final\resources\views/guru/laporan/index.blade.php ENDPATH**/ ?>