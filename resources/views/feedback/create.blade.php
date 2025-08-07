@extends('layouts.siswa') {{-- Gunakan layout landing page Anda --}}
@section('title', $title)
@section('content')
<style>
    /* Mengimpor font yang sama dengan halaman lain */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    .feedback-page-container {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f7fc;
        padding: 60px 15px;
    }
    .form-card {
        max-width: 500px;
        margin: 0 auto;
        background-color: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.07);
        text-align: center;
    }
    .form-card h1 {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }
    .form-card p {
        color: #777;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #555;
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        font-family: 'Poppins', sans-serif;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #6a5ae0;
        box-shadow: 0 0 0 3px rgba(106, 90, 224, 0.2);
    }
    .btn-submit {
        background-color: #6a5ae0;
        color: white;
        border: none;
        padding: 15px;
        width: 100%;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 10px;
    }
    .btn-submit:hover {
        background-color: #5548c7;
    }
</style>

<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="form-card" style="max-width: 600px;">
        <h1>Beri Kami Feedback</h1>
        <p>Bagikan pengalaman Anda bersama Happy Zone!</p>
        <hr style="margin: 20px 0;">
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_orang_tua">Nama Orang Tua</label>
                <input type="text" name="nama_orang_tua" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nama_siswa">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="pesan">Pesan Anda</label>
                <textarea name="pesan" rows="5" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Kirim Feedback</button>
        </form>
    </div>
</div>
@endsection