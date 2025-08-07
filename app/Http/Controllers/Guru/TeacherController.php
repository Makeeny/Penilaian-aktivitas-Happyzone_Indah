<?php
namespace App\Http\Controllers\Guru;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TeacherController extends Controller {
    public function index() {
        $gurus = User::where('role', 'guru')->get();
        // Kita bisa gunakan lagi view dashboard untuk menampilkan panel guru
        return view('guru.dashboard', compact('gurus'));
    }
}