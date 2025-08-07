@extends('layouts.admin')
@section('title', $title)

@section('content')
<style>
    /* CSS Anda sudah bagus, tidak perlu diubah */
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .page-header h1 { font-size: 28px; font-weight: 600; }
    .btn { text-decoration: none; padding: 10px 22px; border-radius: 8px; font-weight: 500; }
    .btn-secondary { background-color: #f0f2f5; color: #555; border: 1px solid #ddd; }
    .form-card { background: #fff; padding: 30px; border-radius: 20px; max-width: 700px; margin: 0 auto; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 500; margin-bottom: 8px; color: #555; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; }
    .form-control:focus { outline: none; border-color: #5D5FEF; box-shadow: 0 0 0 2px rgba(93, 95, 239, 0.2); }
    .btn-submit { background-color: #5D5FEF; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 500; font-size: 16px; cursor: pointer; }
    .alert-danger { background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
</style>

<div class="page-header">
    <h1>{{ $title }}</h1>
    <div>
        <a href="{{ route('admin.users.admins') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="form-card">
    @if ($errors->any())
        <div class="alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ========================================================== --}}
    {{-- == PERBAIKAN UTAMA ADA DI SINI == --}}
    {{-- ========================================================== --}}
    
    {{-- 1. Form Action diubah ke route 'update' dengan mengirim ID user --}}
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- 2. Tambahkan method 'PUT' untuk update --}}

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            {{-- 3. Isi 'value' dengan data lama dari $user --}}
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
            <small style="color: #888">Biarkan kosong jika Anda tidak ingin mengganti password.</small>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">Pilih Role...</option>
                {{-- Logika 'selected' untuk menampilkan role yang sudah ada --}}
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
        </div>
        <button type="submit" class="btn-submit">Update Akun</button>
    </form>
</div>
@endsection