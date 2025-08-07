<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilSiswa;
use App\Models\User;
use App\Models\MataPelajaran; // Kita pertahankan ini untuk nanti
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfilSiswaController extends Controller
{
    /**
     * Menampilkan halaman daftar semua profil siswa.
     */
    public function index()
    {
        // PENYESUAIAN: Menambahkan latest() untuk menampilkan siswa terbaru di atas.
        $profils = ProfilSiswa::with(['user'])->latest()->get();
        $data = [
            'title' => 'Daftar Profil Siswa',
            'profils' => $profils
        ];
        // Tidak diubah: Tetap menggunakan path view Anda.
        return view('admin.profil-siswa.index', $data);
    }

    /**
     * Menampilkan halaman form untuk membuat profil siswa baru.
     */
    public function create()
    {
        // Tidak diubah: Kita tetap pertahankan logic Anda, meskipun form kita belum menggunakannya.
        $mapels = MataPelajaran::all();
        return view('admin.profil-siswa.create', [
            'title' => 'Tambah Profil Siswa Baru',
            'mapels' => $mapels
        ]);
    }

    /**
     * Menyimpan profil siswa baru (sekaligus membuat akun user baru).
     * PENYESUAIAN: Method ini diganti total dengan logika yang lebih lengkap.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'alamat' => 'nullable|string',
            'no_telepon_ortu' => 'nullable|string|max:15',
        ]);

        // 2. Menggunakan transaksi database agar aman.
        // Jika salah satu proses gagal, semua akan dibatalkan.
        DB::transaction(function () use ($validatedData) {
            // A. Buat Akun User baru untuk siswa/orang tua
            $userSiswa = User::create([
                'name' => $validatedData['nama_lengkap'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'siswa',
            ]);

            // B. Buat Profil Siswa dan hubungkan dengan user_id yang baru dibuat
            ProfilSiswa::create([
                'user_id' => $userSiswa->id,
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'alamat' => $validatedData['alamat'],
                'no_telepon_ortu' => $validatedData['no_telepon_ortu'],
            ]);
        });

        // 3. Kembali ke halaman daftar dengan pesan sukses.
        return redirect()->route('admin.profil-siswa.index')->with('success', 'Profil siswa baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman form untuk mengedit profil siswa.
     */
    public function edit(ProfilSiswa $profil_siswa)
    {
        $mapels = MataPelajaran::all();
        return view('admin.profil-siswa.edit', [
            'title' => 'Edit Profil Siswa',
            'profil_siswa' => $profil_siswa,
            'mapels' => $mapels
        ]);
    }

    /**
     * Memperbarui data profil siswa yang ada di database.
     */
    public function update(Request $request, ProfilSiswa $profil_siswa)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
        ]);
        $profil_siswa->update($request->only('nama', 'kelas'));
        return redirect()->route('admin.profil-siswa.index')->with('success', 'Profil siswa diperbarui.');
    }

    /**
     * Menghapus data profil siswa dari database.
     */
    public function destroy(ProfilSiswa $profil_siswa)
    {
        $profil_siswa->delete();
        return redirect()->route('admin.profil-siswa.index')->with('success', 'Profil siswa dihapus.');
    }
}