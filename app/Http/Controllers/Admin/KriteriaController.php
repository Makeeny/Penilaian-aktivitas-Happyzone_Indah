<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria; // Pastikan model Kriteria sudah di-import
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KriteriaController extends Controller
{
    /**
     * Menampilkan halaman daftar semua kriteria.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data kriteria dari database
        $kriterias = Kriteria::all();

        // Mengirim data ke view
        return view('admin.kriteria.index', [
            'title' => 'Daftar Kriteria Bobot Penilaian SAW',
            'kriterias' => $kriterias
        ]);
    }

    /**
     * Menampilkan halaman form untuk membuat kriteria baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.kriteria.create', ['title' => 'Tambah Kriteria Baru']);
    }

    /**
     * Menyimpan kriteria baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'kode_kriteria' => 'required|string|max:10|unique:kriterias,kode_kriteria',
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1', // Bobot harus antara 0 dan 1 (misal: 0.25 untuk 25%)
            'jenis' => ['required', Rule::in(['benefit', 'cost'])], // Jenis harus 'benefit' atau 'cost'
        ]);

        // Membuat record baru di database
        Kriteria::create($validatedData);

        // Kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman form untuk mengedit kriteria.
     * (Fungsi ini untuk nanti saat fitur edit diaktifkan)
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\View\View
     */
    public function edit(Kriteria $kriterium)
    {
        return view('admin.kriteria.edit', [
            'title' => 'Edit Kriteria',
            'kriterium' => $kriterium
        ]);
    }

    /**
     * Memperbarui data kriteria yang ada di database.
     * (Fungsi ini untuk nanti saat fitur edit diaktifkan)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        // Validasi data (kode kriteria tidak perlu unik saat update)
        $validatedData = $request->validate([
            'kode_kriteria' => ['required', 'string', 'max:10', Rule::unique('kriterias')->ignore($kriteria->id)],
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1',
            'jenis' => ['required', Rule::in(['benefit', 'cost'])],
        ]);

        $kriteria->update($validatedData);

        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui!');
    }

    /**
     * Menghapus data kriteria dari database.
     * (Fungsi ini untuk nanti saat fitur hapus diaktifkan)
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();

        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil dihapus!');
    }
}
