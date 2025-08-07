{{-- resources/views/auth/login.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    {{-- Ini adalah blok CSS yang sama persis dari halaman registrasi Anda --}}
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
            padding: 35px 40px;
            border-radius: 60px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            z-index: 1;
            /* Kita tidak perlu mengatur height secara spesifik untuk form login */
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
            margin-bottom: 25px; /* Memberi sedikit ruang lebih setelah judul */
        }
        
        .input-group {
            text-align: left;
            margin-bottom: 20px; /* Memberi ruang lebih antar input */
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
            font-size: 14px; /* Sedikit diperbesar agar mudah dibaca */
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
            color: #555;
        }

        .remember-me input {
            margin-right: 8px;
            /* Styling untuk checkbox agar lebih modern */
            width: 16px;
            height: 16px;
            accent-color: #5D5FEF;
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
            margin-top: 10px; /* Jarak dari 'Ingat Password' */
        }

        .btn-submit:hover {
            background-color: #8e4de6;
        }

        .bottom-text {
            margin-top: 20px; /* Jarak dari tombol 'Masuk' */
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
            text-align: left; /* Error message rata kiri */
        }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="logo-container"></div>
        <img src="{{ asset('images/logohappyzone.png') }}" alt="Happy Zone Logo" class="logo-img">
        <h1>Masuk ke Akun Anda</h1>
        
        {{-- Formulir Login --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf  {{-- Token keamanan wajib di Laravel --}}

            {{-- Input Email --}}
            <div class="input-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="input-field @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="kamu@contoh.com">
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

            {{-- Checkbox "Ingat Password" --}}
            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Ingat Password</label>
            </div>

            <button type="submit" class="btn-submit">
                Masuk
            </button>
        </form>

        <p class="bottom-text">
            Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
        </p>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // Ganti tipe input dari password ke text atau sebaliknya
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Ganti ikon mata (terbuka/tertutup)
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    </script>

</body>
</html>