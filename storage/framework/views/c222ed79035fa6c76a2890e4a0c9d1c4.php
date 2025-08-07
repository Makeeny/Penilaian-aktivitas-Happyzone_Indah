<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard Guru'); ?> - Happy Zone</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #333; }
        .wrapper { display: flex; min-height: 100vh; }

        /* --- Sidebar --- */
        .sidebar {
            width: 280px;
            background-color: #ffffff;
            border-right: 1px solid #e9ecef;
            flex-shrink: 0; /* Mencegah sidebar 'gepeng' saat layar sempit */
            transition: margin-left 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            z-index: 200;
            display: flex; flex-direction: column;
        }
        .sidebar.collapsed { margin-left: -280px; }
        .sidebar .sidebar-header {
            padding: 20px 25px; text-align: left; border-bottom: 1px solid #e9ecef; background-color: #7A70FF ;
            display: flex; align-items: center; gap: 15px; height: 70px;
        }
        .sidebar .sidebar-header img { height: 40px; }
        .sidebar .sidebar-header .logo-name { font-size: 22px; font-weight: 700; color: #ffffff; }
        .sidebar .nav-list { list-style: none; margin-top: 20px; flex-grow: 1; }
        .sidebar .nav-item { background-color: #f8f8fa; border: 1px solid #e9eaef; border-radius: 12px; margin: 0 15px 15px; overflow: hidden; }
        .sidebar .nav-link-toggle, .sidebar .nav-link {
            display: flex;
            align-items: center; /* REVISI: Menambahkan ini untuk perataan vertikal */
            gap: 15px; /* REVISI: Menambahkan gap untuk jarak ikon dan teks yang konsisten */
            padding: 15px; cursor: pointer; font-weight: 600; color: #333;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }
        .sidebar .nav-link-toggle .dropdown-icon { margin-left: auto; } /* Mendorong panah ke kanan */
        /* REVISI: Menambahkan warna hover pada menu */
        .sidebar .nav-item:hover > .nav-link-toggle,
        .sidebar .nav-item:hover > .nav-link {
            background-color: #7A70FF;
            color: white;
        }
        .sidebar .nav-item.active > .nav-link-toggle,
        .sidebar .nav-item.active > .nav-link{
            background-color: #7A70FF; color: white;
        }
        .sidebar .nav-link i, .sidebar .nav-link-toggle i {
             margin-right: 0; /* REVISI: Dihapus agar menggunakan gap */
             font-size: 18px; width: 20px; text-align: center;
        }
        
        /* --- Sub Menu Dropdown --- */
        .sidebar .sub-menu { list-style: none; padding: 5px 15px 15px 15px; display: none; }
        .sidebar .nav-item.active .sub-menu { display: block; }
        .sidebar .sub-menu a {
            display: flex; align-items: center; padding: 12px 15px;
            margin-bottom: 4px; text-decoration: none; color: #555;
            border-radius: 8px; font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
        }
        .sidebar .sub-menu a:hover, .sidebar .sub-menu a.active { background-color: #7A70FF; color: white; }
        .sidebar .sub-menu a i { margin-right: 12px; width: 15px; text-align: center; }
        .dropdown-icon { transition: transform 0.3s ease; }
        .sidebar .nav-item.active .dropdown-icon { transform: rotate(180deg); color: white; }

        /* --- Konten Utama --- */
        .main-content {
            flex-grow: 1; 
            display: flex; 
            flex-direction: column;
            min-width: 0;
            width: 100%;
            transition: width 0.3s ease;
        }
        .main-content.sidebar-open { width: calc(100% - 280px); }

        /* --- Header --- */
        .header {
            background-color: #7A70FF; color: white; padding: 15px 30px;
            display: flex; align-items: center; justify-content: space-between; height: 70px;
        }
        .header-left { display: flex; align-items: center; gap: 20px; }
        .menu-toggle { font-size: 24px; background: none; border: none; color: white; cursor: pointer; }
        /* REVISI: Perbaikan style logo di header */
        .header-logo {
            display: none; /* Disembunyikan oleh JS saat awal */
            align-items: center;
            gap: 15px;
        }
        .header-logo img { height: 40px; }
        .header-logo .header-title { font-size: 22px; font-weight: 700; color: white; }
        .header-nav { display: flex; align-items: center; gap: 30px; }
        .header-nav a { color: white; text-decoration: none; font-weight: 500; }
        .profile-info { position: relative; }
        .profile-info-button { background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 15px; color: white; font-family: 'Poppins', sans-serif; font-size: 16px; }
        .profile-info .avatar { width: 40px; height: 40px; border-radius: 50%; background-color: rgba(255,255,255,0.8); color: #7A70FF; display: flex; align-items: center; justify-content: center; font-weight: 700; }
        
        .profile-dropdown-content {
            display: block; position: absolute; right: 0; top: 55px; background-color: white;
            min-width: 180px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            z-index: 100; border-radius: 8px; overflow: hidden; opacity: 0; visibility: hidden;
            transform: translateY(10px); transition: all 0.3s ease;
        }
        .profile-info:hover .profile-dropdown-content { opacity: 1; visibility: visible; transform: translateY(0); }
        .profile-dropdown-content a, .logout-button { font-size: 14px; color: #333; padding: 12px 20px; text-decoration: none; display: flex; align-items: center; gap: 10px; background: none; border: none; width: 100%; text-align: left; cursor: pointer; }
        .logout-button:hover, .profile-dropdown-content a:hover { background-color: #f5f5f5; }
        .content { padding: 30px; }

        @media (max-width: 992px) {
    .header-nav a {
        display: none; /* Sembunyikan link navigasi di header */
    }
    .header-nav a:last-child {
        display: flex; /* Tetap tampilkan icon notifikasi */
    }
    
    
    /* Buat banner sambutan menjadi vertikal */
    .welcome-banner {
        flex-direction: column;
        text-align: center;
    }
    .welcome-image {
        width: 80% !important;
        margin-top: 20px;
    }
}

/* Aturan untuk layar dengan lebar maksimal 768px (Ponsel Besar) */
@media (max-width: 768px) {
    /* Perkecil sidebar agar tidak terlalu memakan tempat saat dibuka */
    .sidebar {
        width: 260px;
    }
    .sidebar.collapsed {
        margin-left: -260px;
    }
    .main-content.sidebar-open {
        width: calc(100% - 260px);
    }

    /* Kurangi padding di header dan konten utama */
    .header, .content {
        padding-left: 15px;
        padding-right: 15px;
    }
}

/* Aturan untuk layar dengan lebar maksimal 576px (Ponsel) */
@media (max-width: 576px) {
    /* Sembunyikan teks di samping logo header */
    .header-logo .header-title {
        display: none;
    }
    
    /* Sembunyikan nama di samping avatar profile */
    .profile-info-button span {
        display: none;
    }
    
    /* Atur ulang ukuran banner sambutan */
    .welcome-text h1 {
        font-size: 28px;
    }
    .welcome-text p {
        font-size: 16px;
    }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>
    <div class="wrapper">
        
        <aside class="sidebar collapsed" id="sidebar">
            <div class="sidebar-header" id="sidebar-logo">
                <img src="<?php echo e(asset('images/logohappyzone.png')); ?>" alt="Logo">
                <span class="logo-name">Happy Zone</span>
            </div>
    <ul class="nav-list">
    
    
    <li class="nav-item <?php echo e(request()->is('guru/penilaian*') ? 'active' : ''); ?>">
        <div class="nav-link-toggle">
            <i class="fas fa-book"></i>
            <span>Mata Pelajaran</span>
            <i class="fas fa-chevron-down dropdown-icon"></i>
        </div>
        <ul class="sub-menu">
            <?php if(isset($listMapelForSidebar)): ?>
                <?php $__currentLoopData = $listMapelForSidebar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mapel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    
                    
                    <a href="<?php echo e(route('guru.penilaian.index', $mapel->id)); ?>"
                       class="<?php echo e(optional(request()->route('mapel'))->id == $mapel->id ? 'active' : ''); ?>">
                        
                        <?php if($mapel->nama_mapel == 'Bahasa Inggris'): ?>
                            <i class="fas fa-language"></i>
                        <?php elseif($mapel->nama_mapel == 'Calistung'): ?>
                            <i class="fas fa-calculator"></i>
                        <?php elseif($mapel->nama_mapel == 'Art / Kesenian'): ?>
                            <i class="fas fa-palette"></i>
                        <?php elseif($mapel->nama_mapel == 'Mandarin'): ?>
                            <i class="fas fa-globe-asia"></i>
                        <?php elseif($mapel->nama_mapel == 'Matematika'): ?>
                            <i class="fas fa-square-root-alt"></i>
                        <?php elseif($mapel->nama_mapel == 'Gucheng'): ?>
                            <i class="fas fa-music"></i>
                        <?php else: ?>
                            <i class="fas fa-book"></i> 
                        <?php endif; ?>

                        <?php echo e($mapel->nama_mapel); ?>

                    </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </ul>
    </li>
    <li class="nav-item <?php echo e(Route::is('guru.data-siswa.*') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('guru.data-siswa.index')); ?>" class="nav-link"><i class="fas fa-users"></i><span>Data Nama Siswa</span></a>
    </li>
    <li class="nav-item <?php echo e(Route::is('guru.laporan.*') ? 'active' : ''); ?>">
       <a href="<?php echo e(route('guru.laporan.index')); ?>" class="nav-link"><i class="fas fa-file-signature"></i><span>Laporan Penilaian Siswa</span></a>
    </li>
</ul>
</aside>
        <div class="main-content full-width" id="main-content">
            <header class="header">
                <div class="header-left">
                    <button class="menu-toggle" id="menu-toggle-btn"><i class="fas fa-bars"></i></button>
                    
                    <a href="<?php echo e(route('guru.dashboard')); ?>" class="header-logo" id="header-logo" style="text-decoration: none;">
                        <img src="<?php echo e(asset('images/logohappyzone.png')); ?>" alt="Logo">
                        <span class="header-title">Happy Zone</span>
                    </a>
                </div>
                <nav class="header-nav">
                    <a href="<?php echo e(route('guru.notifications.index')); ?>"><i class="fas fa-bell"></i></a>
                    <div class="profile-info">
                        <button class="profile-info-button">
                            <span><?php echo e(Auth::user()->name); ?></span>
                            <div class="avatar"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></div>
                        </button>
                        <div class="profile-dropdown-content">
                            <a href="#"><i class="fas fa-user-circle"></i> Profile</a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?></form>
                            <button class="logout-button"
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            </button>
                        </div>
                    </div>
                </nav>
            </header>
            
            <main class="content">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                    <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('menu-toggle-btn');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const headerLogo = document.getElementById('header-logo');

            // Fungsi untuk mengatur visibilitas logo di header
            function toggleHeaderLogo() {
                if (sidebar.classList.contains('collapsed')) {
                    headerLogo.style.display = 'flex';
                } else {
                    headerLogo.style.display = 'none';
                }
            }

            // Panggil fungsi saat halaman pertama kali dimuat
            toggleHeaderLogo();

            // Panggil fungsi setiap kali tombol di klik
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('sidebar-open'); // Menggunakan class yang berbeda untuk kejelasan
                toggleHeaderLogo();
            });

            // Logika dropdown menu (tidak berubah)
            document.querySelectorAll('.nav-link-toggle').forEach(item => {
                item.addEventListener('click', event => {
                    document.querySelectorAll('.nav-item.active').forEach(activeItem => {
                        if(activeItem !== item.parentElement) {
                            activeItem.classList.remove('active');
                        }
                    });
                    item.parentElement.classList.toggle('active');
                });
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
    function bukaModal(idModal) {
        document.getElementById(idModal).classList.add('show');
    }
    function tutupModal(idModal) {
        document.getElementById(idModal).classList.remove('show');
    }
    </script>
</body>
</html><?php /**PATH C:\laragon\www\happy-zone-final\resources\views/layouts/guru.blade.php ENDPATH**/ ?>