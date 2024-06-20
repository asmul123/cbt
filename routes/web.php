<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AllUserController;
use App\Http\Controllers\TahunPelajaranController;
use App\Http\Controllers\RombonganBelajarController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\BanksoalController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\AksesuserController;
use App\Http\Controllers\AnggotarombelController;
use App\Http\Controllers\PenjadwalanController;
use App\Http\Controllers\PengerjaanController;
use App\Http\Controllers\PengawasanController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\FastlogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/fastlog', [FastlogController::class, 'authenticate']);
Route::get('/logpengawas', [FastlogController::class, 'pengawas']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/pengawasan', [PengawasanController::class, 'index'])->middleware('auth');
Route::get('/pengawasanshow', [PengawasanController::class, 'show'])->middleware('auth');
Route::get('/pengawasancreate', [PengawasanController::class, 'create'])->middleware('auth');
Route::get('/akun', [UserController::class, 'ubahpassword'])->middleware('auth');
Route::post('/akun', [UserController::class, 'passwordupdate'])->middleware('auth');
Route::get('/user', [UserController::class, 'index'])->middleware('auth');
Route::post('/useradd', [UserController::class, 'store'])->middleware('auth');
Route::post('/users/import', [AllUserController::class, 'import'])->middleware('auth');
Route::post('/rombonganbelajar/import', [RombonganBelajarController::class, 'import'])->middleware('auth');
Route::post('/ruangan/import', [RuanganController::class, 'import'])->middleware('auth');
Route::post('/kelompok/import', [KelompokController::class, 'import'])->middleware('auth');
Route::get('/kelompok/format', [KelompokController::class, 'format'])->middleware('auth');
Route::post('/kelompok/importanggota', [KelompokController::class, 'importanggota'])->middleware('auth');
Route::get('/migrasi', [PenjadwalanController::class, 'migration'])->middleware('auth');
Route::get('/merge', [PenjadwalanController::class, 'merge'])->middleware('auth');
Route::get('/pemeriksaan', [PemeriksaanController::class, 'index'])->middleware('auth');
Route::get('/pemeriksaan-detail', [PemeriksaanController::class, 'detail'])->middleware('auth');
Route::post('/pemeriksaan-simpan', [PemeriksaanController::class, 'simpan'])->middleware('auth');
Route::resource('/users', AllUserController::class)->middleware('auth');
Route::resource('/tahunpelajaran', TahunpelajaranController::class)->middleware('auth');
Route::resource('/rombonganbelajar', RombonganBelajarController::class)->middleware('auth');
Route::resource('/ruangan', RuanganController::class)->middleware('auth');
Route::resource('/kelompok', KelompokController::class)->middleware('auth');
Route::resource('/banksoal', BanksoalController::class)->middleware('auth');
Route::resource('/soal', SoalController::class)->middleware('auth');
Route::resource('/aksesuser', AksesuserController::class)->middleware('auth');
Route::resource('/anggotarombel', AnggotarombelController::class)->middleware('auth');
Route::resource('/penjadwalan', PenjadwalanController::class)->middleware('auth');
Route::resource('/pengerjaan', PengerjaanController::class)->middleware('auth');
