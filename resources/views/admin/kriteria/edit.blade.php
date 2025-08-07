@extends('layouts.admin')
@section('title', $title)

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .page-header h1 { font-size: 28px; font-weight: 600; }
    .btn { text-decoration: none; padding: 10px 22px; border-radius: 8px; font-weight: 500; }
    .btn-secondary { background-color: #f0f2f5; color: #555; border: 1px solid #ddd; }
    .form-card { background: #fff; padding: 30px; border-radius: 20px; max-width: 700px; margin: 0 auto; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Membuat 2 kolom */
        gap: 20px; /* Jarak antar kolom */
    }
    .form-group { margin-bottom: 20px; }
    .full-width { grid-column: 1 / -1; } /* Membuat elemen membentang penuh 2 kolom */
    .form-group label { display: block; font-weight: 500; margin-bottom: 8px; color: #555; }
    .form-control {
        width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;
        font-family: 'Poppins', sans-serif; font-size: 15px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        outline: none; border-color: #5D5FEF; box-shadow: 0 0 0 2px rgba(93, 95, 239, 0.2);
    }
    .btn-submit {
        background-color: #ff4d4f; color: white; border: none; padding: 12px 30px;
        border-radius: 8px; font-weight: 500; font-size: 16px; cursor: pointer;
    }
</style>

<div class="page-header">
    <h1>Edit Daftar Mata Pelajaran dan Kriteria Bobot penilaian SAW</h1>
    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    <form action="{{ route('admin.kriteria.update', ['kriterium' => $kriterium->id]) }}" method="POST">        @csrf
        @method('PUT') {{-- Penting: Metode untuk update adalah PUT atau PATCH --}}
    
        <div class="form-group">
            <label for="kode_kriteria">Kode Kriteria (Contoh: C1, C2)</label>
            <input type="text" name="kode_kriteria" class="form-control" value="{{ old('kode_kriteria', $kriterium->kode_kriteria) }}" required>
        </div>
        <div class="form-group">
            <label for="nama_kriteria">Nama Kriteria</label>
            <input type="text" name="nama_kriteria" class="form-control" value="{{ old('nama_kriteria', $kriterium->nama_kriteria) }}" required>
        </div>
        <div class="form-group">
            <label for="bobot">Bobot (Gunakan titik, contoh: 0.25)</label>
            <input type="text" name="bobot" class="form-control" value="{{ old('bobot', $kriterium->bobot) }}" required>
        </div>
        <div class="form-group">
            <label for="jenis">Jenis</label>
            <select name="jenis" class="form-control" required>
                <option value="benefit" {{ old('jenis', $kriterium->jenis) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                <option value="cost" {{ old('jenis', $kriterium->jenis) == 'cost' ? 'selected' : '' }}>Cost</option>
            </select>
        </div>
        <button type="submit" class="btn-submit">Update Kriteria</button>
    </form>
</div>
@endsection
