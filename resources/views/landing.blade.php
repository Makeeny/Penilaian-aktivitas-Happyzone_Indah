<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Happy Zone</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        /* Reset Dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            background-image: 
                radial-gradient(circle at 100% 0%, rgba(169, 98, 247, 0.1) 0%, transparent 30%),
                radial-gradient(circle at 0% 100%, rgba(93, 95, 239, 0.1) 0%, transparent 30%);
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* === PERUBAHAN PADA HEADER === */
        .main-header {
            padding: 15px 0;
            position: sticky;
            top: 0;
            width: 100%; /* Memastikan background membentang penuh */
            background-color: #5d5fefe6; /* Sedikit transparan */
            backdrop-filter: blur(10px);
            z-index: 1000;
            border-bottom: 1px solid #5d5fefe6;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px; /* Jarak antara gambar dan teks */
        }

       .logo-img {
            height: 45px; /* Mengatur tinggi gambar logo */
            width: 45px;  /* Mengatur lebar agar persegi seperti di desain */
            border-radius: 8px; /* Memberi sudut sedikit tumpul pada logo */
        }
        
        .logo-text {
            font-weight: 700;
            font-size: 18px;
            color: #ffffff;
        }

        .main-nav a {
            color: #ffffff;
            text-decoration: none;
            margin-left: 35px; /* Jarak antar menu diatur */
            font-weight: 500;
            transition: all 0.3s ease;
            padding-bottom: 5px;
            position: relative;
        }
        
        .main-nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #5D5FEF;
            transition: width 0.3s ease;
        }

        .main-nav a:hover {
            color: #5D5FEF;
            transform: translateY(-2px);
        }
        
        .main-nav a:hover::after {
            width: 100%;
        }

        .main-nav .nav-button {
            background-color: #7519cb;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
        }

        .main-nav .nav-button:hover, .main-nav .nav-button:hover::after {
            color: white;
            background-color: #b027f0;
            width: auto;
            transform: translateY(-2px);
        }
        /* === AKHIR PERUBAHAN HEADER === */

        /* Bagian Hero (Konten Utama) */
        .hero-section {
            position: relative; /* Diperlukan untuk overlay */
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            /* Gambar background diatur di sini */
            background-image: url("{{ asset('images/elementary.png') }}");
            background-size: cover;
            background-position: center;
        }
        /* Lapisan gelap semi-transparan untuk membuat teks lebih mudah dibaca */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4); 
        }
        .hero-content {
            position: relative; /* Agar konten berada di atas overlay */
            z-index: 2;
            max-width: 700px;
        }
        .hero-content h1 {
            font-size: 52px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        .hero-content p {
            font-size: 18px;
            margin-bottom: 30px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }
        .hero-section h1 { font-size: 55px; font-weight: 900; color: #cd9fff; margin-bottom: 20px; line-height: 1.2; }
        .hero-section p { font-size: 18px; max-width: 600px; margin: 0 auto 30px; color: #f7eeee; }
        .hero-button {
            background-color: #A962F7;
            color: white;
            padding: 15px 35px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s;
        }
        .hero-button:hover {
            background-color: #8e4de6;
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(169, 98, 247, 0.4);
        }
        /* Bagian Konten Lainnya */
        .info-section { padding: 30px 0; }
        .content-card { background-color: #ffffff; padding: 40px; border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05); transition: transform 0.3s, box-shadow 0.3s; }
        .content-card:hover { transform: translateY(-10px); box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08); }
        .grid-2-col { display: grid; grid-template-columns: 1fr 1.5fr; gap: 40px; align-items: center; }
        .section-image {
            width: 100%;
            height: auto;
            border-radius: 15px;
            object-fit: cover;
        }
        .text-content h2 { font-size: 32px; color: #1e1e3a; margin-bottom: 20px; }
        .text-content h3 { font-size: 20px; color: #5D5FEF; margin-top: 25px; margin-bottom: 10px; }
        .text-content p, .text-content ul { color: #555; margin-bottom: 15px; }
        .tips-banner { background-color: #fffbe6; border: 1px solid #ffe58f; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 40px; font-weight: 500; }
        .features-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: flex-start; }
        .features-grid .image-placeholder { background-color: #dbeaff; color: #5D5FEF; }
        .features-grid a { color: #5D5FEF; font-weight: 600; text-decoration: none; }
        .testimonial-card { background-color: #e6f4ea; border: 1px solid #b7ebc7; padding: 25px; border-radius: 12px; margin-bottom: 20px; }
        .testimonial-card p { font-style: italic; }
        .testimonial-card span { font-weight: 600; color: #276a3f; margin-top: 10px; display: block; }
        
        /* CSS untuk Animasi Scroll */
        .fade-in-element { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .fade-in-element.is-visible { opacity: 1; transform: translateY(0); }
        
        /* === CSS FOOTER (DIPINDAHKAN DARI MEDIA QUERY) === */
        .main-footer {
            background-color: #1e1e3a; /* Warna gelap yang konsisten */
            color: #a0a0c0;
            padding: 40px 0;
            margin-top: 60px;
            font-size: 14px;
        }
        .footer-content {
            text-align: center;
        }
        .footer-top {
            margin-bottom: 15px;
        }
        .footer-bottom {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap; /* Agar responsif di mobile */
        }
        .footer-bottom a {
            color: #a0a0c0;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer-bottom a:hover {
            color: #ffffff;
        }
        
        /* Responsif untuk Mobile */
        @media (max-width: 768px) {
            .grid-2-col, .features-grid { grid-template-columns: 1fr; }
            .hero-section h1 { font-size: 36px; }
            .header-content { flex-direction: column; gap: 15px; }
            .main-nav { margin-top: 10px; }
            /* Penyesuaian footer untuk mobile */
            .main-footer { text-align: center; }
        }

    /* CSS TAMBAHAN UNTUK EFEK FADE PADA TEKS TIPS */
    #learning-tip {
             transition: opacity 0.4s ease-in-out;
    }

    .landing-page-body {
        /* 1. Menentukan gambar background */
        background-image: url("{{ asset('images/elementary.png') }}"); /* Ganti dengan nama file gambar Anda */

        /* 2. Mengatur agar gambar menutupi seluruh layar */
        background-size: cover;

        /* 3. Mengatur posisi gambar agar selalu di tengah */
        background-position: center center;

        /* 4. Mencegah gambar berulang */
        background-repeat: no-repeat;

        /* 5. (Opsional) Membuat gambar tetap di tempat saat di-scroll */
        background-attachment: fixed;

        /* Beri tinggi minimal agar background terlihat jika konten sedikit */
        min-height: 100vh;
    }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="container header-content">
            <div class="logo-container">
                <img src="{{ asset('images/logohappyzone.png') }}" alt="Happy Zone Logo" class="logo-img" />
                <span class="logo-text">HAPPY ZONE</span>
            </div>
            <nav class="main-nav">
                <a href="#tentang">Tentang Kami</a>
                <a href="{{ route('login') }}">Log in</a>
                <a href="{{ route('register') }}" class="nav-button">Register</a>
            </nav>
        </div>
    </header>

    <main class="hero-section">
        <div class="hero-content">
            <h1>Selamat Datang di Happy Zone</h1>
            <p>Tempat terbaik untuk mengembangkan potensi anak anda dengan cara yang menyenangkan dan interaktif.</p>
        </div>
    </main>

    <section id="tentang" class="info-section container">
        <div class="content-card grid-2-col fade-in-element">
            <div class="image-placeholder">
                <img src="{{ asset('images/suasana-belajar.jpg') }}" alt="Suasana Belajar" class="section-image" />
            </div>
            <div class="text-content">
                <h2>Tentang Happy Zone</h2>
                <p>Selamat datang di Happy Zone, tempat di mana belajar menjadi petualangan yang menyenangkan! Kami percaya bahwa setiap anak memiliki potensi luar biasa yang menunggu untuk digali...</p>
                <p>Di Happy Zone For Education, kami tidak hanya fokus pada pencapaian akademis, tetapi juga pada pengembangan karakter, kreativitas, dan rasa percaya diri...</p>
                <h3>Mata Pelajaran Unggulan:</h3>
                <p>Bahasa Inggris, Calistung (Baca, Tulis, Hitung), Kelas Art/Kesenian, Matematika, Mandarin, dan Gucheng.</p>
                <h3>Tingkatan Kelas:</h3>
                <p>Kami menyediakan kelas untuk berbagai tingkatan, mulai dari persiapan TK hingga Sekolah Menengah Pertama, yang terbagi menjadi Kelas Dasar, Menengah, dan Lanjutan.</p>
            </div>
        </div>
    </section>

    <section id="fitur" class="info-section container">
        <div class="tips-banner fade-in-element">
            💡 <b>Tips Belajar Seru!</b> <span id="learning-tip">Jangan lupa istirahat setiap 30 menit belajar ya, agar otak tetap segar! Semangat!</span>
        </div>
        <div class="features-grid">
            <div class="content-card fade-in-element">
                <div class="image-placeholder">
                    <img src="{{ asset('images/pendidikan-dini.jpg') }}" alt="Pendidikan Dini" class="section-image" />
                </div>
                <div class="text-content" style="margin-top: 20px;">
                    <h2>Mengapa Pendidikan Dini Penting?</h2>
                    <p>Pendidikan dini membentuk dasar yang kuat untuk perkembangan kognitif, sosial, dan emosional anak, mempersiapkan mereka untuk kesuksesan di masa depan.</p>
                    <a href="https://disdikpora.bulelengkab.go.id/informasi/detail/artikel/18_pentingnya-pendidikan-anak-usia-dini">Baca Selengkapnya ></a>
                </div>
            </div>

            <div class="content-card fade-in-element">
                <div class="text-content">
                    <h2>Kata Orang Tua Siswa</h2>
                    {{-- Testimoni dari database --}}
                    @if($feedback->isNotEmpty())
                        <div id="feedback-container">
                            @foreach($feedback as $item)
                                <div class="testimonial-card" style="display: none;">
                                    <p>"{{ $item->pesan }}"</p>
                                    <span>- {{ $item->nama_orang_tua }}, Orang Tua {{ $item->nama_siswa }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="testimonial-card">
                            <p>"Metode pengajarannya interaktif dan gurunya sabar. Terima kasih!"</p>
                            <span>- Bapak Agus, Orang Tua Citra</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="container footer-content">
            <div class="footer-top">
                <p>&copy; 2025 Indah Febrianti Makini . Happy Zone. Semua Hak Dilindungi.</p>
            </div>
            <div class="footer-bottom">
                <a href="https://www.instagram.com/happyzone1010/">Happy Zone Instagram</a>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Hubungi Kami: +62 822-6903-0208</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const feedbackContainer = document.getElementById('feedback-container');
            if (feedbackContainer) {
                const feedbackItems = feedbackContainer.querySelectorAll('.testimonial-card');
                if (feedbackItems.length > 0) {
                    let currentIndex = 0;
                    feedbackItems[currentIndex].style.display = 'block';

                    setInterval(() => {
                        feedbackItems[currentIndex].style.display = 'none';
                        currentIndex = (currentIndex + 1) % feedbackItems.length;
                        feedbackItems[currentIndex].style.display = 'block';
                    }, 7000);
                }
            }

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.fade-in-element').forEach(el => observer.observe(el));

            // Tips belajar dinamis
            const tips = [
                "Jangan lupa istirahat setiap 30 menit belajar ya, agar otak tetap segar! Semangat!",
                "Cari tempat yang nyaman dan bebas gangguan agar lebih fokus.",
                "Gunakan teknik Pomodoro: 25 menit fokus, 5 menit istirahat.",
                "Jangan takut bertanya kepada guru jika ada materi yang belum dipahami.",
                "Minum air yang cukup! Otak kita butuh hidrasi untuk bekerja maksimal.",
                "Buat ringkasan atau peta konsep dari materi yang sudah dipelajari."
            ];
            const tipElement = document.getElementById('learning-tip');
            if (tipElement) {
                setInterval(() => {
                    let newTip = tipElement.textContent;
                    while (newTip === tipElement.textContent) {
                        newTip = tips[Math.floor(Math.random() * tips.length)];
                    }
                    tipElement.style.opacity = 0;
                    setTimeout(() => {
                        tipElement.textContent = newTip;
                        tipElement.style.opacity = 1;
                    }, 400);
                }, 7000);
            }
        });
    </script>
</body>
</html>
