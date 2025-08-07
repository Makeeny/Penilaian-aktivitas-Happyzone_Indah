<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        /* Reset & Body Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
        }

        /* Layout Utama Dashboard */
        .dashboard-layout {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Styling Header/Navbar Dashboard */
        .dashboard-header {
            padding: 15px 0;
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container { display: flex; align-items: center; gap: 12px; }
        .logo { background-color: #5D5FEF; color: white; font-size: 20px; font-weight: 700; width: 45px; height: 45px; border-radius: 8px; display: flex; justify-content: center; align-items: center; }
        .logo-text { font-weight: 600; font-size: 18px; color: #333; }

        .dashboard-nav a, .dashboard-nav .logout-button {
            color: #555;
            text-decoration: none;
            margin-left: 30px;
            font-weight: 500;
            transition: color 0.3s;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 16px; /* Samakan ukuran font */
            font-family: 'Poppins', sans-serif; /* Samakan font */
        }
        
        .dashboard-nav a:hover, .dashboard-nav .logout-button:hover {
            color: #5D5FEF;
        }
        
        /* Konten Utama */
        .main-content {
            flex-grow: 1; /* Membuat konten mengisi ruang yang tersedia */
            padding: 40px 0;
        }

        /* Styling Footer */
        .main-footer {
            background-color: #1e1e3a;
            color: #a0a0c0;
            padding: 40px 0;
            font-size: 14px;
            text-align: center;
        }
        .footer-bottom { display: flex; justify-content: center; gap: 30px; margin-top: 15px; }
        .footer-bottom a { color: #a0a0c0; text-decoration: none; transition: color 0.3s ease; }
        .footer-bottom a:hover { color: #ffffff; }

    </style>
</head>
<body>
    <div id="app" class="dashboard-layout">
        <header class="dashboard-header">
            <div class="container header-content">
                <div class="logo-container">
                    <div class="logo">HZ</div>
                    <span class="logo-text">Happy Zone</span>
                </div>
                <nav class="dashboard-nav">
                    <a href="{{ url('/home') }}">Dashboard</a>
                    <a href="#">Profil Saya</a>
                    
                    <a class="logout-button" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </nav>
            </div>
        </header>

        <main class="main-content">
            <div class="container">
                @yield('content')
            </div>
        </main>

        <footer class="main-footer">
            <div class="footer-top">
                <p>&copy; {{ date('Y') }} Happy Zone. Semua Hak Dilindungi.</p>
            </div>
            <div class="footer-bottom">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
            </div>
        </footer>
    </div>
</body>
</html>