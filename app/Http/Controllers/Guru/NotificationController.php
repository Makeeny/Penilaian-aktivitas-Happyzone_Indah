<?php
namespace App\Http\Controllers\Guru;

use App\Models\Notification; // Import the Notification model
use App\Models\User; // Import the User model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Pastikan ini ada
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller {
    public function index()
    {
        $user = Auth::user();

        // Ambil semua notifikasi yang ditujukan untuk user yang sedang login
        $notifications = Notification::where('user_id', $user->id)->latest()->paginate(15); // Ambil 15 notifikasi per halaman
        return view('guru.notifications.index', [
            'title' => 'Halaman Notifikasi',
            'notifications' => $notifications,
        ]);
    }

    // ==========================================================
    // == METHOD BARU 1: Menyetujui Permintaan ==
    // ==========================================================
    public function approveRequest(Notification $notification)
    {

        // Pastikan notifikasi ini milik guru yang sedang login
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

       // Coba temukan siswa dari pesan notifikasi
        // Asumsi format pesan: "Siswa [Nama_Siswa] mengajukan..."
        preg_match('/Siswa (\w+)/', $notification->message, $matches);
        $namaSiswa = $matches[1] ?? null;

        if ($namaSiswa) {
            $siswaUser = User::where('name', $namaSiswa)->where('role', 'siswa')->first();
            
            if ($siswaUser) {
                // Tentukan jumlah poin yang akan ditukar (antara 100-600)
                $poinYangDitukar = rand(1, 6) * 100;

                // Gunakan DB Transaction untuk memastikan keamanan data
                DB::beginTransaction();
                try {
                    // Cek apakah poin siswa mencukupi
                    // Asumsi ada kolom 'total_points' di tabel users
                                
                if ($siswaUser->total_points >= $poinYangDitukar) {
                    $siswaUser->total_points -= $poinYangDitukar;
                    $siswaUser->save();

                    // Tandai notifikasi sebagai sudah dibaca
                    $notification->read_at = now();
                    $notification->save();

                    DB::commit();
                    // Arahkan ke dashboard guru dengan pesan sukses
                    return redirect()->route('guru.dashboard')->with('success', "Poin siswa {$namaSiswa} berhasil ditukar.");
                    } else {
                        throw new \Exception('Poin siswa tidak mencukupi.');
                    }
                } catch (\Exception $e) {
                    DB::rollBack(); // Batalkan semua perubahan jika ada error
                    return redirect()->route('guru.notifications.index')->with('error', 'Gagal: ' . $e->getMessage());
                }
            }
        }
        // Jika siswa tidak ditemukan atau poin tidak cukup
        $notification->read_at = now();
        $notification->save();
        return redirect()->route('guru.notifications.index')->with('error', 'Gagal memproses permintaan: Siswa tidak ditemukan atau poin tidak mencukupi.');
    }

    // ==========================================================
    // == METHOD BARU 2: Menolak Permintaan ==
    // ==========================================================
    public function rejectRequest(Notification $notification)
    {
        // Pastikan notifikasi ini milik guru yang sedang login
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Tandai notifikasi ini sebagai sudah dibaca
        $notification->read_at = Carbon::now();
        $notification->save();

        return redirect()->route('guru.dashboard')->with('success', 'Permintaan tukar poin telah ditolak.');
    }
}