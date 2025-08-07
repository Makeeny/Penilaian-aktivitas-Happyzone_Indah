<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController; // <-- Jangan lupa tambahkan ini di atas
use App\Models\Feedback;
use App\Http\Controllers\LandingPageController;

// --- CONTROLLER UNTUK OTENTIKASI ---
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// --- CONTROLLER UNTUK ADMIN ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\ProfilSiswaController;

// --- CONTROLLER UNTUK GURU ---
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\LaporanController;
use App\Http\Controllers\Guru\NotificationController;
use App\Http\Controllers\Guru\PenilaianController;
use App\Http\Controllers\Guru\TeacherController;
use App\Http\Controllers\Guru\DataSiswaController; // <-- TAMBAHKAN INI

// --- CONTROLLER UNTUK SISWA ---
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROUTE PUBLIK (Bisa diakses siapa saja) ---
Route::get('/', function () {
    $testimonials = Feedback::where('is_tampil', true)->inRandomOrder()->get();
    return view('landing', ['testimonials' => $testimonials]);
})->name('landing');

Route::get('/', [LandingPageController::class, 'index']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');


// --- GRUP ROUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'checkrole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/admins', [UserController::class, 'indexAdmins'])->name('admins');
        Route::get('/gurus', [UserController::class, 'indexGurus'])->name('gurus');
        Route::get('/siswas', [UserController::class, 'indexSiswas'])->name('siswas');
        Route::get('/create', [UserController::class, 'create'])->name('create');
         // Rute untuk mengedit data (GET)
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        
        // Rute untuk memperbarui data (PUT)
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');

    });
    Route::prefix('profil-siswa')->name('profil-siswa.')->group(function () {
        Route::get('/', [ProfilSiswaController::class, 'index'])->name('index');
        Route::get('/create', [ProfilSiswaController::class, 'create'])->name('create');
        Route::post('/', [ProfilSiswaController::class, 'store'])->name('store');
    });
    // Route::resource akan secara otomatis membuat semua rute untuk
    // index, create, store, show, edit, update, dan destroy.
    Route::resource('mata-pelajaran', MapelController::class);
    
    // Route::resource akan secara otomatis membuat semua rute untuk
    // index, create, store, edit, update, dan destroy.
    Route::resource('kriteria', KriteriaController::class);
});


// --- GRUP ROUTE KHUSUS GURU ---
Route::middleware(['auth', 'checkrole:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/students/search', [PenilaianController::class, 'searchSiswa'])->name('students.search');
    Route::get('/data-siswa/{mapel?}', [DataSiswaController::class, 'index'])->name('data-siswa.index');
    Route::post('/notifications/{notification}/approve', [NotificationController::class, 'approveRequest'])->name('notifications.approve');
    Route::post('/notifications/{notification}/reject', [NotificationController::class, 'rejectRequest'])->name('notifications.reject');

    // Pastikan Anda memiliki route ini untuk menyimpan penilaian bulk
   Route::post('/penilaian/store-bulk', [PenilaianController::class, 'storeBulk'])->name('penilaian.store.bulk');

Route::get('/laporan/{profilSiswa}/show', [LaporanController::class, 'show'])->name('laporan.show');

// == RUTE BARU UNTUK MENGUNDUH PDF ==
    Route::get('/laporan/{profilSiswa}/download', [LaporanController::class, 'downloadPDF'])->name('laporan.download');

    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/{mapel?}', [PenilaianController::class, 'index'])->name('index');
        Route::get('/create/{mapel}', [PenilaianController::class, 'create'])->name('create');

        // Rute untuk menampilkan form edit (menggunakan ID assessment)
        Route::get('/{assessment}/edit', [PenilaianController::class, 'edit'])->name('edit');

        // Rute untuk memproses update data dari form edit
        Route::put('/{assessment}', [PenilaianController::class, 'update'])->name('update');
        
        // Rute untuk menghapus data penilaian
        Route::delete('/{assessment}', [PenilaianController::class, 'destroy'])->name('destroy');
    });
});


// --- GRUP ROUTE KHUSUS SISWA (POSISI SUDAH BENAR) ---
Route::middleware(['auth', 'checkrole:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/rekap-poin/{subject}', [\App\Http\Controllers\Siswa\DashboardController::class, 'rekapPoin'])->name('rekap-poin.show');
    Route::get('/laporan/{profilSiswa}/download', [\App\Http\Controllers\Guru\LaporanController::class, 'downloadPDF'])->name('laporan.download');
    // Rute untuk menandai notifikasi sebagai sudah dibaca dan disetujui
    Route::post('/notifications/{notification}/approve', [NotificationController::class, 'approveRequest'])->name('notifications.approve');
    // Rute untuk menandai notifikasi sebagai sudah dibaca dan ditolak
    Route::post('/notifications/{notification}/reject', [NotificationController::class, 'rejectRequest'])->name('notifications.reject');
    

    // Rute baru untuk menampilkan detail penilaian per mata pelajaran
    Route::get('/penilaian/{subject}', [SiswaDashboardController::class, 'showPenilaian'])->name('penilaian.show');
    Route::post('/tukar-poin', [SiswaDashboardController::class, 'tukarPoin'])->name('tukar-poin');
}); 

// --- GRUP ROUTE UNTUK PENGGUNA TERAUTENTIKASI ---
Route::middleware(['auth'])->group(function () {
    // Rute ini bisa diakses oleh role apa pun yang sudah login.
    // Kita akan menggunakan ID profil siswa dan ID mata pelajaran sebagai parameter.
    Route::get('/penilaian-detail/{profilSiswa}/{subject}', [\App\Http\Controllers\DetailPenilaianController::class, 'show'])
         ->name('penilaian.detail.show');
});
