{{-- resources/views/auth/register.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Salin dan ganti seluruh blok <style> di file Anda dengan ini --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3E%3Cdefs%3E%3Cpattern id='p' width='500' height='500' patternUnits='userSpaceOnUse'%3E%3Cpath id='a' data-color='outline' fill='none' stroke='%235D5FEF' stroke-width='50' d='M-250 250a500 500 0 0 1 500 500v-1000a500 500 0 0 0-500 500zm500 0a500 500 0 0 1 500 500v-1000a500 500 0 0 0-500 500z'%3E%3C/path%3E%3C/pattern%3E%3C/defs%3E%3Crect fill='url(%23p)' width='100%25' height='100%25'%3E%3C/rect%3E%3C/svg%3E");
        }

        .form-container {
            background-color: #ffffff;
            padding: 35px 40px; /* <<< DIUBAH: Mengurangi padding vertikal */
            border-radius: 60px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            z-index: 1;
            height: 80vh
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px; /* Jarak antara gambar dan teks */
        }

       .logo-img {
            height: 60px; /* Mengatur tinggi gambar logo */
            width: 60px;  /* Mengatur lebar agar persegi seperti di desain */
            border-radius: 8px; /* Memberi sudut sedikit tumpul pada logo */
        }

        h1 {
            font-size: 25px;
            color: #333;
            margin-bottom: 10px; /* <<< DIUBAH: Jarak bawah judul dikurangi */
        }
        
        .input-group {
            text-align: left;
            margin-bottom: 10px; /* <<< DIUBAH: Jarak antar input dikurangi */
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 13px
        }

        .input-field {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s;
            font-size: 10px 
        }

        .input-field:focus {
            outline: none;
            border-color: #5D5FEF;
        }
        
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* 2. Beri ruang di kanan input untuk ikon */
        .password-wrapper .input-field {
            padding-right: 45px; 
        }

        /* 3. Atur posisi dan style ikon mata */
        .toggle-password {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: #888;
            font-size: 16px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            text-align: left;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .remember-me input {
            margin-right: 8px;
        }

        .btn-submit {
            background-color: #A962F7;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #8e4de6;
        }

        .bottom-text {
            margin-top: 5px; /* <<< DIUBAH: Jarak atas dikurangi */
            font-size: 14px;
            color: #777;
        }

        .bottom-text a {
            color: #5D5FEF;
            text-decoration: none;
            font-weight: 600;
        }
        .error-message {
            color: #e3342f;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="logo-container"></div>
            <img src="{{ asset('images/logohappyzone.png') }}" alt="Logo Happy Zone" class="logo-img">
        <h1>YUK! Daftar dan Masuk sekarang</h1>


        {{-- Formulir Registrasi --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf  {{-- Token keamanan wajib di Laravel --}}

            {{-- Input Nama Lengkap --}}
            <div class="input-group">
                <label for="name">Nama lengkap</label>
                <input id="name" type="text" class="input-field @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama lengkap anda">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Email --}}
            <div class="input-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="input-field @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="kamu@contoh.com">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Password --}}
            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input id="password" type="password" class="input-field @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    {{-- Ini adalah ikon mata --}}
                    <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Konfirmasi Pa.ssword --}}
            <div class="input-group">
                <label for="password-confirm">Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input id="password-confirm" type="password" class="input-field" name="password_confirmation" required autocomplete="new-password" placeholder="********">
                    {{-- Ini adalah ikon mata --}}
                    <i class="fas fa-eye-slash toggle-password" id="togglePassword-confirm"></i>
                </div>
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Daftar
            </button>
        </form>

        <p class="bottom-text">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </p>
    </div>

    <script>
    // 1. Ambil SEMUA ikon mata yang ada di halaman
    const togglePasswordIcons = document.querySelectorAll('.toggle-password');

    // 2. Terapkan logika pada setiap ikon yang ditemukan
    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            // Temukan input field yang berada tepat sebelum ikon ini
            const inputField = this.previousElementSibling;

            // Ganti tipe input dari password ke text atau sebaliknya
            const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
            inputField.setAttribute('type', type);
            
            // Ganti ikonnya (dari mata terbuka ke tertutup, atau sebaliknya)
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
    </script>
</body>
</html>