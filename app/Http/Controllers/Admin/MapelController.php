<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
         return view('admin.mata-pelajaran.index', [
        'title' => 'Daftar Mata Pelajaran',
        // PERBAIKAN: Eloquent akan secara otomatis mengecualikan data yang sudah di-soft delete
        'mapels' => MataPelajaran::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('admin.mata-pelajaran.create', [
            'title' => 'Tambah Mata Pelajaran Baru'
        ]);
    }

    public function store(Request $request)
    {
         $validatedData = $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:subjects,nama_mapel'
        ]);

        // 2. Buat data baru menggunakan data yang sudah tervalidasi
        MataPelajaran::create($validatedData);

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran baru berhasil ditambahkan.');
      }

    public function show(MataPelajaran $mapel)
    {
        $kriterias = $mapel->kriterias;
        return view('admin.mata-pelajaran.show', compact('mapel', 'kriterias'));
    }

    public function edit(MataPelajaran $mata_pelajaran)
    {
       return view('admin.mata-pelajaran.edit', [
            'title' => 'Edit Mata Pelajaran',
            'mapel' => $mata_pelajaran // <-- PERBAIKAN: Samakan nama variabel
        ]);
    }

    public function update(Request $request, MataPelajaran $mata_pelajaran)
    {
        $request->validate(['nama_mapel' => 'required|string|max:255']);
        $mata_pelajaran->update($request->all());
        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mapel diperbarui.');
    }

    public function destroy(MataPelajaran $mata_pelajaran)
    {
       try {
            // Coba untuk menghapus data
            $deleted = $mata_pelajaran->delete();

            // Jika delete() gagal (mengembalikan false), kirim pesan error
            if (!$deleted) {
                return redirect()->route('admin.mata-pelajaran.index')->with('error', 'Gagal menghapus mata pelajaran. Silakan coba lagi.');
            }

            // Jika berhasil, kirim pesan sukses
            return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus.');

        } catch (\Exception $e) {
            // Jika terjadi error database (misalnya karena foreign key constraint),
            // tangkap errornya dan tampilkan pesannya.
            return redirect()->route('admin.mata-pelajaran.index')->with('error', 'Terjadi kesalahan: Mata pelajaran ini mungkin masih digunakan di data lain.');
        }
    }
}
