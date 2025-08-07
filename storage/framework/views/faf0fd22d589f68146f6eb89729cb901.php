
<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
<style>
    .page-title { font-size: 28px; font-weight: 600; margin-bottom: 25px; }
    .filter-card { background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .filter-grid { display: grid; grid-template-columns: 1.5fr 1fr auto; gap: 20px; align-items: flex-end; }
    .form-group label { display: block; font-weight: 500; margin-bottom: 8px; color: #555; }
    
    /* --- REVISI 2: Perbaikan Tampilan Dropdown --- */
    .form-control {
        width: 100%; padding: 12px 15px; border: 1px solid #ccc;
        border-radius: 8px; font-size: 14px;
        -webkit-appearance: none; -moz-appearance: none; appearance: none; /* Menghilangkan panah default */
        background-color: white;
    }
    .select-wrapper {
        position: relative;
        width: 100%;
    }
    .select-wrapper::after {
        content: '\f078'; /* Kode ikon panah ke bawah dari Font Awesome */
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 15px; /* Jarak dari kanan */
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none; /* Agar bisa diklik tembus ke select */
        color: #888;
        font-size: 14px;
    }
    /* --- AKHIR REVISI 2 --- */
    
    .btn-filter { background-color: #7A70FF; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; }
    .btn-filter:hover { background-color: #5a52d1; }
    .report-header { display: flex; justify-content: space-between; align-items: center; margin-top: 40px; margin-bottom: 20px; }
    .report-header h2 { font-size: 22px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
    .report-header h2 span { color: #7A70FF; }
    .btn-new { background-color: #ff4d4f; color: white; padding: 8px 15px; border-radius: 10px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background-color 0.2s;}
    .btn-new:hover { background-color: #d9363e; }
    .data-table-card { background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 16px 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
    .table th { font-weight: 600; font-size: 14px; color: #888; text-transform: uppercase; }
    .table td { font-size: 15px; vertical-align: middle; }
    .table a.student-link { color: #333; text-decoration: none; font-weight: 500; }
    .table a.student-link:hover { color: #7A70FF; }
    .table thead { background-color: #f8f9fa; }
    .table tbody tr:last-child td { border-bottom: none; }
    .nilai-badge { background-color: #e7f7f4; color: #20a17b; padding: 5px 12px; border-radius: 15px; font-weight: 600; }
    .poin-badge { background-color: #FFFBE6; color: #b48c0a; padding: 5px 12px; border-radius: 15px; font-weight: 600; }
    .action-buttons a { margin: 0 8px; color: #888; font-size: 18px; text-decoration: none; transition: color 0.2s; }
    .action-buttons a.edit:hover { color: #7A70FF; }
    .action-buttons a.download:hover { color: #007bff; }
    .action-buttons a.delete:hover { color: #ff4d4f; }

   /* Aturan untuk layar dengan lebar maksimal 992px (Tablet) */
@media (max-width: 992px) {
    /* Ubah grid filter menjadi 1 kolom penuh */
    .filter-grid {
        grid-template-columns: 1fr;
        gap: 15px; /* Kurangi jarak antar elemen filter */
    }

    /* Pastikan tombol filter lebarnya penuh */
    .btn-filter {
        width: 100%;
        justify-content: center;
    }

    /* Ubah header laporan menjadi vertikal */
    .report-header {
        flex-direction: column;
        align-items: flex-start; /* Rata kiri */
        gap: 15px;
    }
}

/* Aturan untuk layar dengan lebar maksimal 768px (HP) */
@media (max-width: 768px) {
    /* Buat tabel bisa di-scroll ke samping jika tidak muat */
    .data-table-card {
        overflow-x: auto;
    }
    .table {
        min-width: 600px; /* Lebar minimal tabel agar tidak terlalu gepeng */
    }

    /* Kurangi padding */
    .filter-card, .data-table-card {
        padding: 20px;
    }
    .page-title {
        font-size: 24px;
    }
    .report-header h2 {
        font-size: 20px;
    }
}

</style>

<h1 class="page-title">Form Nilai Siswa</h1>

<div class="filter-card">
    <form method="GET" action="<?php echo e(route('guru.penilaian.index')); ?>">
        <div class="filter-grid">
            <div class="form-group">
                <label for="filter-kelas">Filter Kelas:</label>
                    <div class="select-wrapper">
                    <select name="subject_id" id="subject_id" class="form-control">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        <?php $__currentLoopData = $listMapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mapelItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($mapelItem->id); ?>" <?php echo e(request('subject_id') == $mapelItem->id ? 'selected' : ''); ?>>
                                <?php echo e($mapelItem->nama_mapel); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Periode Waktu:</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo e(request('tanggal')); ?>">
            </div>
            
            <button type="submit" class="btn-filter">Terapkan Filter</button>
        </div>
    </form>
</div>

<div class="report-header">
    
    <h2>Laporan Penilaian: <span><i class="fas fa-language"></i> <?php echo e($mapelAktif->nama_mapel ?? 'Semua Kelas'); ?></span></h2>
    <a href="<?php echo e(route('guru.penilaian.create', ['mapel' => $mapelAktif->id ?? 1])); ?>" class="btn-new">
        <i class="fas fa-plus"></i> New
    </a>
</div>


<div class="data-table-card">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th> 
                <th>Aktivitas</th>
                <th>Tanggal</th>
                <th>Nilai</th>
                <th>Poin</th>
                <th>Feedback</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $penilaian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><a href="#" class="student-link"><?php echo e($item->profilSiswa->nama_lengkap ?? 'Siswa Dihapus'); ?></a></td>
                <td><?php echo e($item->aktivitas); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('Y-m-d')); ?></td>
                <td><span class="nilai-badge"><?php echo e($item->rata_rata_nilai); ?></span></td>
                <td><span class="poin-badge">+<?php echo e($item->poin_bulat); ?></span></td>
               
                <td><?php echo e($item->feedback); ?></td>
                <td class="action-buttons" style="text-align: center;">
                
                <a href="<?php echo e(route('guru.penilaian.edit', $item->id)); ?>" title="Edit Data">
                    <i class="fas fa-edit"></i>
                </a>

                
                <form action="<?php echo e(route('guru.penilaian.destroy', $item->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penilaian ini secara permanen?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" style="background:none; border:none; color:#555; cursor:pointer; padding:0; font-size:16px;" title="Hapus Data">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">Belum ada data penilaian untuk filter ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guru', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\happy-zone-final\resources\views/guru/penilaian/index.blade.php ENDPATH**/ ?>