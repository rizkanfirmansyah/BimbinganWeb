<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\GuidanceController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use Laravel\Jetstream\Rules\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('awal', [
        "title" => "Web Bimbingan Skripsi"
    ]);
})->name('/');

Route::get('/loginMahasiswa', function () {
    return view('mahasiswa/loginMahasiswa', ['title' => 'Login Mahasiswa']);
})->name('login-mahasiswa');

Route::get('/registerMahasiswa', function () {
    return view('mahasiswa/registerMahasiswa', ['title' => 'Register Mahasiswa']);
});

Route::group(['prefix' => 'mahasiswa', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('mahasiswa/dashboardMahasiswa', ['title' => 'Dashboard Mahasiswa']);
    })->name('dashboard-mahasiswa');
    Route::get('/profile', [MahasiswaController::class, 'index'])->name('profile-mahasiswa');
});

Route::group(['prefix' => 'dosen', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', [DosenController::class, 'index'])->name('dashboard-dosen');
    Route::get('/list/bimbingan', [DosenController::class, 'list'])->name('list-bimbingan');
    Route::get('/mahasiswa/bimbingan', [DosenController::class, 'mahasiswa'])->name('mahasiswa-bimbingan');
    Route::get('/proses/bimbingan', [DosenController::class, 'proses'])->name('proses-bimbingan');
});


Route::group(['prefix' => 'bimbingan', 'middleware' => 'auth'], function () {
    Route::get('/pengajuan', [GuidanceController::class, 'submission'])->name('pengajuan-bimbingan');
    Route::get('/data', [GuidanceController::class, 'list'])->name('data-bimbingan');
    Route::get('/hasil', [GuidanceController::class, 'result'])->name('hasil-bimbingan');
});

Route::get('/redirects',  [HomeController::class, "index"]);


Route::get('/loginAdmin', function () {
    return view('admin/loginAdmin', ['title' => 'Login Admin']);
})->name('login-admin');


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, "store"])->name('register');
    Route::post('login', [AuthController::class, "login"])->name('login');
    Route::post('password', [AuthController::class, "password"])->name('password');
});

Route::get('/change/password', [AuthController::class, "changepassword"])->middleware('auth')->name('change-password');

Route::get('/loginDosen', function () {
    return view('dosen/loginDosen', ['title' => 'Login Mahasiswa']);
})->name('login-dosen');

Route::get('/logout', [AuthController::class, "logout"])->name('logout');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
