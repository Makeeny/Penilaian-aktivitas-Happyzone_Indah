@extends('layouts.admin')

@section('title', $title)

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .page-header h1 { font-size: 28px; font-weight: 600; }
    .btn { text-decoration: none; padding: 10px 22px; border-radius: 8px; font-weight: 500; }
    .btn-secondary { background-color: #f0f2f5; color: #555; border: 1px solid #ddd; }
    .form-card { background: #fff; padding: 30px; border-radius: 20px; max-width: 800px; margin: 0 auto; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 20px; }
    .full-width { grid-column: 1 / -1; }
    .form-group label { display: block; font-weight: 500; margin-bottom: 8px; color: #555; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; transition: border-color 0.2s, box-shadow 0.2s; }
    .form-control:focus { outline: none; border-color: #5D5FEF; box-shadow: 0 0 0 2px rgba(93, 95, 239, 0.2); }
    .btn-submit { background-color: #ff4d4f; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 500; font-size: 16px; cursor: pointer; }
    .alert-danger { background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    .alert-danger ul { margin: 0; padding-left: 20px; }
</style>

<div class="page-header">
    <h1>{{ $title }}</h1>
    <div>
        <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-secondary">Batal</a>
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

    <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST">
        @csrf
        <div class="form-group full-width">
            <label for="nama-mata-pelajaran">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mata_pelajaran" id="nama-mata-pelajaran" class="form-control" value="{{ old('nama_mata_pelajaran') }}" required>
        </div>

        <button type="submit" class="btn-submit" style="margin-top: 10px;">Simpan Data mata pelajaran</button>
    </form>
</div>
@endsection
