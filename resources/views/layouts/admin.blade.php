<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Happy Zone</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* CSS Anda yang lain tidak diubah */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #333; }
        .wrapper { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; position: fixed; top: 0; left: 0; height: 100%; background-color: #ffffff; border-right: 1px solid #e9ecef; transition: margin-left 0.3s ease-in-out; z-index: 200; display: flex; flex-direction: column; }
        .sidebar.collapsed { margin-left: -260px; }
        .sidebar .logo-details { padding: 20px 25px; text-align: center; border-bottom: 1px solid #e9ecef; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .sidebar .logo-details img { height: 40px; }
        .sidebar .logo-details .logo-name { font-size: 22px; font-weight: 700; color: #5D5FEF; }
        .sidebar .nav-links { list-style: none; margin-top: 20px; overflow-y: auto; flex-grow: 1; }
        .sidebar .nav-links a { text-decoration: none; }
        .sidebar .nav-links .nav-link, .sidebar .nav-links .nav-link-toggle { display: flex; align-items: center; padding: 15px 25px; color: #5a6a7a; font-weight: 500; transition: background-color 0.2s, color 0.2s; cursor: pointer; }
        .sidebar .nav-links .nav-link:hover, .sidebar .nav-links .nav-link-toggle:hover, .sidebar .nav-links li.active > .nav-link-toggle, .sidebar .nav-links li > a.active { background-color: #f3e8ff; color: #5D5FEF; }
        .sidebar .nav-links i.fa-solid { margin-right: 15px; font-size: 18px; width: 20px; text-align: center; }
        .sidebar .nav-item.active > .nav-link-toggle,
        .sidebar .nav-item.active > .nav-link{
            background-color: #7A70FF; color: white;
        }

        .dropdown-icon { margin-left: auto; transition: transform 0.3s ease; }
        li.active .dropdown-icon { transform: rotate(180deg); }
        .sub-menu { list-style: none; max-height: 0; overflow: hidden; transition: max-height 0.3s ease-in-out; background-color: #f8f9fa; }
        li.active .sub-menu { max-height: 500px; }
        .sub-menu a { display: block; padding: 12px 25px 12px 65px; color: #5a6a7a; font-size: 14px; }
        .sub-menu a:hover { color: #5D5FEF; }
        .main-content { flex-grow: 1; margin-left: 260px; display: flex; flex-direction: column; transition: margin-left 0.3s ease-in-out; }
        .main-content.full-width { margin-left: 0; }
        .header { background-color: #ffffff; padding: 0 30px; height: 70px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e9ecef; }
        .header-left { display: flex; align-items: center; gap: 20px; }
        .sidebar-toggle { font-size: 22px; background: none; border: none; cursor: pointer; color: #333; }
        .header-logo { align-items: center; gap: 10px; }
        .header-logo img { height: 35px; }
        .header-logo .logo-name { font-size: 22px; font-weight: 700; color: #5D5FEF; }
        .profile-dropdown { position: relative; }
        .profile-button { background: none; border: none; cursor: pointer; display: flex; align-items: center; font-family: 'Poppins', sans-serif; font-size: 16px; }
        .profile-button .avatar { width: 40px; height: 40px; border-radius: 50%; background-color: #5D5FEF; color: white; display: flex; align-items: center; justify-content: center; margin-left: 15px; font-weight: 600; }
        
        /* --- PENYESUAIAN 1: MEMPERBAIKI INTERAKSI DROPDOWN --- */
        .profile-dropdown-content {
            display: block; /* Diubah dari none */
            position: absolute; right: 0; top: 55px; background-color: white;
            min-width: 180px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            z-index: 100; border-radius: 8px; overflow: hidden;
            /* Tambahkan properti transisi untuk animasi */
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
        }
        .profile-dropdown:hover .profile-dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }


        /* --- AKHIR PENYESUAIAN 1 --- */

        .profile-dropdown-content a, .logout-button { font-size: 14px; color: #333; padding: 12px 20px; text-decoration: none; display: block; background: none; border: none; width: 100%; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 10px; }
        .logout-button:hover, .profile-dropdown-content a:hover { background-color: #f5f5f5; }
        .content-area { padding: 30px; flex-grow: 1; }
        .footer { padding: 20px 30px; text-align: center; font-size: 14px; color: #888; border-top: 1px solid #e9ecef; background-color: #fff; }
        .panel-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-top: 20px; }
        .panel-grid a { text-decoration: none; color: inherit; display: flex; }
        .panel-card { background-color: #fff; padding: 25px; border-radius: 15px; border: 1px solid #e9ecef; transition: transform 0.2s, box-shadow 0.2s; width: 100%; }
        .panel-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
        .panel-card h4 { margin-top: 0; margin-bottom: 8px; font-size: 18px; font-weight: 600; }
        .panel-card p { font-size: 14px; color: #6c757d; line-height: 1.6; }
        .panel-card.purple { background-color: #f2eefc; }
        .panel-card.purple h4 { color: #8c5de6; }
        .panel-card.pink { background-color: #fff0ed; }
        .panel-card.pink h4 { color: #f06a4b; }
        .panel-card.green { background-color: #e7f7f4; }
        .panel-card.green h4 { color: #20a17b; }
    </style>
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar" id="sidebar">
            <a href="{{ route('admin.dashboard') }}" style="text-decoration: none;">
                <div class="logo-details" id="sidebar-logo">
                    <img src="{{ asset('images/logohappyzone.png') }}" alt="Logo">
                    <span class="logo-name">HAPPY ZONE</span>
                </div>
            </a>
            <ul class="nav-links">
                {{-- 1. Dashboard --}}
                {{-- Menu aktif jika URL persis 'admin/dashboard' --}}
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-columns"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- 2. Daftar Akun (dengan Submenu) --}}
                {{-- Menu utama akan aktif jika URL diawali dengan 'admin/users' --}}
                <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <div class="nav-link-toggle">
                        <i class="fa-solid fa-users-gear"></i>
                        <span>Daftar Akun</span>
                        <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </div>
                    <ul class="sub-menu">
                        {{-- Submenu aktif jika URL-nya cocok --}}
                        <li><a href="{{ route('admin.users.admins') }}" class="{{ request()->is('admin/users/admins') ? 'active' : '' }}">Akun Admin</a></li>
                        <li><a href="{{ route('admin.users.gurus') }}" class="{{ request()->is('admin/users/gurus') ? 'active' : '' }}">Akun Guru</a></li>
                        <li><a href="{{ route('admin.users.siswas') }}" class="{{ request()->is('admin/users/siswas') ? 'active' : '' }}">Akun Siswa</a></li>
                    </ul>
                </li>

                {{-- 3. Data Profil Siswa --}}
                {{-- Menu aktif jika URL diawali dengan 'admin/profil-siswa' --}}
                <li>
                    <a href="{{ route('admin.profil-siswa.index') }}" class="nav-link {{ request()->is('admin/profil-siswa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-id-card"></i>
                        <span>Data Profil Siswa</span>
                    </a>
                </li>
                
                {{-- 4. Penilaian (dengan Submenu) --}}
                {{-- Menu utama akan aktif jika URL diawali dengan 'admin/mata-pelajaran' atau 'admin/kriteria' --}}
                <li class="nav-item {{ (request()->is('admin/mata-pelajaran*') || request()->is('admin/kriteria*')) ? 'active' : '' }}">
                    <div class="nav-link-toggle">
                        <i class="fa-solid fa-calculator"></i>
                        <span>Penilaian</span>
                        <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a href="{{ route('admin.mata-pelajaran.index') }}" class="{{ request()->is('admin/mata-pelajaran*') ? 'active' : '' }}">Data Mapel</a></li>
                        <li><a href="{{ route('admin.kriteria.index') }}" class="{{ request()->is('admin/kriteria*') ? 'active' : '' }}">Kriteria SAW</a></li>
                    </ul>
                </li>
            </ul>
        </aside>

        <div class="main-content" id="main-content">
            <header class="header">
                <div class="header-left">
                    <button class="sidebar-toggle" id="sidebar-toggle-btn"><i class="fas fa-bars"></i></button>
                    <a href="{{ route('admin.dashboard') }}" class="header-logo" id="header-logo" style="display: none; text-decoration: none;">
                        <img src="{{ asset('images/logohappyzone.png') }}" alt="Logo">
                        <span class="logo-name">HAPPY ZONE</span>
                    </a>
                </div>
                
                <div class="profile-dropdown">
                    <button class="profile-button">
                        <span>{{ Auth::user()->name }}</span>
                        <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    </button>
                    <div class="profile-dropdown-content">
                        <a href="#"><i class="fas fa-user-circle"></i> Profile</a>
                        {{-- PENYESUAIAN 2: Memperbaiki action pada form logout --}}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        <button class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </div>
                </div>
            </header>
            
            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Script JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const sidebarLogo = document.getElementById('sidebar-logo');
            const headerLogo = document.getElementById('header-logo');

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('full-width');
                if (sidebar.classList.contains('collapsed')) {
                    headerLogo.style.display = 'flex';
                } else {
                    headerLogo.style.display = 'none';
                }
            });

            const dropdownToggles = document.querySelectorAll('.nav-link-toggle');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const parentNavItem = this.parentElement;
                    parentNavItem.classList.toggle('active');
                });
            });
        });
    </script>
</body>
</html>
