<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\UsulanPklController;
use App\Http\Controllers\VerifBimbinganController;
use App\Http\Controllers\VerifUsulanPklController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// -----------------------------------------------
// RUTE APLIKASI BIMBINGAN PKL MAHASISWA
// -----------------------------------------------

// Rute default diarahkan ke landing page
Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');


// Menampilkan halaman login
Route::get('/login', function () {
    return view('login');
});

// Rute Login proses Laravel
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // Tampilkan form login
Route::post('/login', [LoginController::class, 'login']); // Proses login

// Logout pengguna
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login')->with('success', 'Anda berhasil logout.');
})->name('logout');

// Rute dashboard untuk semua role
Route::group(['middleware' => ['role:superAdmin|admin|mahasiswa|mahasiswaPkl|pengujiPkl|pembimbingPkl|kaprodi|dosen']], function () {
    Route::get('/dashboard', function () {
        return view('layouts.dashboard');
    });
});

// --------------------------------------------------------
// RUTE UNTUK ADMIN (CRUD Jurusan, Prodi, Dosen, Mahasiswa)
// --------------------------------------------------------
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::group(['middleware' => ['role:admin']], function () {
    // --- Jurusan ---
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan');
    Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::get('/jurusan/{id}/edit', [JurusanController::class, 'edit'])->name('data_jurusan.edit_jurusan');
    Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

    // --- Prodi ---
    Route::get('/prodi', [ProdiController::class, 'index'])->name('prodi');
    Route::get('/prodi/create', [ProdiController::class, 'create'])->name('prodi.create');
    Route::post('/prodi', [ProdiController::class, 'store'])->name('prodi.store');
    Route::get('/prodi/edit/{id}', [ProdiController::class, 'edit'])->name('data_prodi.edit_prodi');
    Route::put('/prodi/{id}', [ProdiController::class, 'update'])->name('prodi.update');
    Route::delete('/prodi/{id}', [ProdiController::class, 'destroy'])->name('prodi.destroy');
    Route::get('/getProdi/{jurusan_id}', [ProdiController::class, 'getProdi']); // AJAX: Ambil data prodi berdasarkan jurusan

    // --- Dosen ---
    Route::get('/dosen', [DosenController::class, 'index'])->name('dosen');
    Route::get('/dosen/create', [DosenController::class, 'create'])->name('dosen.create');
    Route::post('/dosen', [DosenController::class, 'store'])->name('dosen.store');
    Route::get('/dosen/edit/{id}', [DosenController::class, 'edit'])->name('data_dosen.dosen_edit');
    Route::put('/dosen/{id}', [DosenController::class, 'update'])->name('dosen.update');
    Route::delete('/dosen/{id}', [DosenController::class, 'destroy'])->name('dosen.destroy');
    Route::get('/getProdi/{jurusan_id}', [DosenController::class, 'getProdi']); // AJAX: Ambil data prodi untuk dosen
    Route::get('/dosen/{id}', [DosenController::class, 'show'])->name('dosen.show');
    Route::get('dosen/export/excel', [DosenController::class, 'export_excel'])->name('dosen.export'); // Ekspor ke Excel
    Route::post('/dosen/import', [DosenController::class, 'import_excel'])->name('dosen.import');     // Import dari Excel

    // --- Mahasiswa ---
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa');
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/mahasiswa/edit/{id}', [MahasiswaController::class, 'edit'])->name('data_mahasiswa.mahasiswa_edit');
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
    Route::get('/getProdi/{jurusan_id}', [MahasiswaController::class, 'getProdi']); // AJAX
    Route::get('mahasiswa/export/excel', [MahasiswaController::class, 'export_excel'])->name('mahasiswa.export');
    Route::post('/mahasiswa/import', [MahasiswaController::class, 'import_excel'])->name('mahasiswa.import');
});

// -------------------------------------------------
// MAHASISWA - Usulan Tempat PKL
// -------------------------------------------------
Route::group(['middleware' => ['role:mahasiswa']], function () {
    Route::get('/usulanpkl', [UsulanPklController::class, 'index'])->name('usulanpkl');
    Route::get('usulanpkl/create', [UsulanPklController::class, 'create'])->name('usulanpkl.create');
    Route::post('/usulanpkl', [UsulanPklController::class, 'store'])->name('usulanpkl.store');
});

// -------------------------------------------------
// MAHASISWA PKL - Edit PKL dan Bimbingan
// -------------------------------------------------
Route::group(['middleware' => ['role:mahasiswaPkl']], function () {
    Route::get('/usulanpkl/{id}', [UsulanPklController::class, 'edit'])->name('usulanpkl.edit');
    Route::put('/usulanpkl/{id}', [UsulanPklController::class, 'update'])->name('usulanpkl.update');
    Route::delete('/usulanpkl/{id}', [UsulanPklController::class, 'destroy'])->name('usulanpkl.destroy');

    // Bimbingan PKL
    Route::get('/bimbinganPkl/create/{id}', [BimbinganController::class, 'create'])->name('bimbinganPkl.create');
    Route::post('/bimbinganPkl/store/{id}', [BimbinganController::class, 'store'])->name('bimbinganPkl.store');
    Route::get('/bimbingan-pkl/{id}/edit', [BimbinganController::class, 'edit'])->name('bimbinganPkl.edit');
    Route::put('/bimbingan-pkl/{id}', [BimbinganController::class, 'update'])->name('bimbinganPkl.update');
    Route::delete('/bimbinganPkl/{id}', [BimbinganController::class, 'destroy'])->name('bimbinganPkl.destroy');
});

// -------------------------------------------------
// KAPRODI - Verifikasi Usulan PKL
// -------------------------------------------------
Route::group(['middleware' => ['role:kaprodi']], function () {
    Route::get('/verif_usulan_pkl', [VerifUsulanPklController::class, 'index'])->name('verif_usulan_pkl');
    Route::put('/verif_usulan_pkl/{id}/konfirmasi', [VerifUsulanPklController::class, 'konfirmasi'])->name('verif_usulan_pkl.konfirmasi');
    Route::put('/verif-usulan-pkl/batalkan/{id}', [VerifUsulanPklController::class, 'batalkan'])->name('verif_usulan_pkl.batalkan');
    Route::put('/usulanpkl/{id}/verifikasi', [UsulanPklController::class, 'verifikasi'])->name('usulanpkl.verifikasi');
    Route::put('usulanpkl/batalkan/{id}', [UsulanPklController::class, 'batalkanKonfirmasi'])->name('usulanpkl.batalkan');
});

// -------------------------------------------------
// PEMBIMBING - Verifikasi Bimbingan PKL
// -------------------------------------------------
Route::group(['middleware' => ['role:pembimbingPkl']], function () {
    Route::get('/verif_bimbingan_pkl', [VerifBimbinganController::class, 'index'])->name('verif_bimbingan_pkl');
    Route::put('/verif_bimbingan_pkl/{id}', [VerifBimbinganController::class, 'verifikasiBimbingan'])->name('verif.bimbinganPkl');
    Route::put('/verif_bimbingan_pkl/{id}/batal-verif', [VerifBimbinganController::class, 'batalVerifikasi'])->name('batal.verif');
});

// -------------------------------------------------
// MAHASISWA PKL & PEMBIMBING - Akses Logbook PKL
// -------------------------------------------------
Route::group(['middleware' => ['role:mahasiswaPkl|pembimbingPkl']], function () {
    Route::get('/bimbinganPkl', [BimbinganController::class, 'index'])->name('bimbinganPkl');
    Route::get('/logbook/{id}', [BimbinganController::class, 'show'])->name('logbook.view');
});

// Route::group(['middleware' => ['role:mahasiswaPkl|pembimbingPkl|dosen|kaprodi']], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
// });
