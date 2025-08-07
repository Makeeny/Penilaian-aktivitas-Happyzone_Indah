<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

class UserController extends Controller
{
    // Method untuk menampilkan halaman daftar Admin (Tidak Diubah)
    public function indexAdmins()
    {
        $users = User::where('role', 'admin')->latest()->get();
        return view('admin.users.index', [
            'title' => 'Data Akun Admin',
            'users' => $users
        ]);
    }

    // Method untuk menampilkan halaman daftar Guru (Tidak Diubah)
    public function indexGurus()
    {
        $users = User::where('role', 'guru')->latest()->get();
        return view('admin.users.index', [
            'title' => 'Data Akun Guru',
            'users' => $users
        ]);
    }

    // Method untuk menampilkan halaman daftar Siswa (Tidak Diubah)
    public function indexSiswas()
    {
        $users = User::where('role', 'siswa')->latest()->get();
        return view('admin.users.index', [
            'title' => 'Data Akun Siswa (Orang Tua)',
            'users' => $users
        ]);
    }


    // --- LOGIKA BARU DIMULAI DARI SINI ---

    /**
     * Method untuk menampilkan halaman form tambah akun baru.
     */
    public function create()
    {
        return view('admin.users.create', ['title' => 'Tambah Akun Baru']);
    }

    /**
     * Method untuk menampilkan halaman form edit akun yang sudah ada.
     */
    public function edit(User $user)   
    {
        // Pastikan hanya admin yang bisa mengedit akun
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        return view('admin.users.edit', ['title' => 'Edit Akun', 'user' => $user]);
    }

    /**
     * Method untuk menyimpan data akun baru dari form ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['admin', 'guru', 'siswa'])],
        ]);

        // 2. Enkripsi password sebelum disimpan
        $validatedData['password'] = Hash::make($validatedData['password']);

        // 3. Simpan data user baru ke database
        User::create($validatedData);

        // 4. Arahkan kembali ke halaman daftar yang sesuai dengan pesan sukses
        // Penambahan 's' di akhir role agar cocok dengan nama route (admins, gurus, siswas)
        return redirect()->route('admin.users.' . $validatedData['role'] . 's')
                         ->with('success', 'Akun baru berhasil ditambahkan!');
    }

     public function update(Request $request, User $user)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate([
            'name' => 'required|string|max:255',
            // Pastikan email unik, tapi abaikan email user saat ini
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,guru,siswa',
            // Password tidak wajib diisi saat update
            'password' => 'nullable|string|min:8', 
        ]);

        // 2. Ambil semua data yang tervalidasi
        $dataToUpdate = $request->except('password');

        // 3. Cek apakah admin mengisi password baru
        if ($request->filled('password')) {
            // Jika ya, enkripsi password baru
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        // 4. Update data user di database
        $user->update($dataToUpdate);

        // 5. Arahkan kembali ke halaman daftar yang sesuai dengan role user
        $redirectRoute = 'admin.users.admins'; // Default
        if ($user->role === 'guru') {
            $redirectRoute = 'admin.users.gurus';
        } elseif ($user->role === 'siswa') {
            $redirectRoute = 'admin.users.siswas';
        }

        return redirect()->route($redirectRoute)->with('success', 'Data akun berhasil diperbarui!');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }
}