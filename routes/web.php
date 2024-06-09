<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AllUserController;
use App\Http\Controllers\TahunPelajaranController;
use App\Http\Controllers\RombonganBelajarController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\RekappembelajaranController;
use App\Http\Controllers\RekapadministrasiController;
use App\Http\Controllers\PembelajaranpdController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\PenugasanpdController;
use App\Http\Controllers\BanksoalController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\AdministrasikaprodiController;
use App\Http\Controllers\HakaksesController;
use App\Http\Controllers\AksesuserController;
use App\Http\Controllers\AnggotarombelController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\DokumenkurikulumController;
use App\Http\Controllers\DokumenkaprodiController;
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
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index']);

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/akun', [UserController::class, 'ubahpassword'])->middleware('auth');
Route::post('/akun', [UserController::class, 'passwordupdate'])->middleware('auth');
Route::get('/user', [UserController::class, 'index'])->middleware('auth');
Route::post('/useradd', [UserController::class, 'store'])->middleware('auth');
Route::post('/users/import', [AllUserController::class, 'import'])->middleware('auth');
Route::post('/rombonganbelajar/import', [RombonganBelajarController::class, 'import'])->middleware('auth');
Route::resource('/users', AllUserController::class)->middleware('auth');
Route::resource('/tahunpelajaran', TahunpelajaranController::class)->middleware('auth');
Route::resource('/rombonganbelajar', RombonganBelajarController::class)->middleware('auth');
Route::resource('/pembelajaran', PembelajaranController::class)->middleware('auth');
Route::resource('/rekappembelajaran', RekappembelajaranController::class)->middleware('auth');
Route::resource('/rekapadministrasi', RekapadministrasiController::class)->middleware('auth');
Route::resource('/pembelajaranpd', PembelajaranpdController::class)->middleware('auth');
Route::resource('/penugasan', PenugasanController::class)->middleware('auth');
Route::resource('/penugasanpd', PenugasanpdController::class)->middleware('auth');
Route::resource('/banksoal', BanksoalController::class)->middleware('auth');
Route::resource('/soal', SoalController::class)->middleware('auth');
Route::resource('/administrasi', AdministrasiController::class)->middleware('auth');
Route::resource('/administrasikaprodi', AdministrasikaprodiController::class)->middleware('auth');
Route::resource('/hakakses', HakaksesController::class)->middleware('auth');
Route::resource('/aksesuser', AksesuserController::class)->middleware('auth');
Route::resource('/anggotarombel', AnggotarombelController::class)->middleware('auth');
Route::resource('/kurikulum', KurikulumController::class)->middleware('auth');
Route::resource('/dokumenkurikulum', DokumenkurikulumController::class)->middleware('auth');
Route::resource('/dokumenkaprodi', DokumenkaprodiController::class)->middleware('auth');
