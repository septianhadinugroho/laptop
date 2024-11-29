<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AwalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\LaporController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AdminVotingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::middleware('only_guest')->group(function() {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authentication']);
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function(){
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/', function () {
        return view('awal');
    });
});
Route::get('awal', [AwalController::class, 'awal'])->name('awal');

Route::middleware('only_user')->group(function(){
    Route::get('lapor', [LaporController::class, 'lapor']);
    Route::get('akun', [AkunController::class, 'akun']);
    Route::get('history', [HistoryController::class, 'history']);
    Route::get('user/history', [HistoryController::class, 'history'])->name('user.history');
    Route::get('about', [AboutController::class, 'about']);
    Route::get('/voting', [VotingController::class, 'voting'])->name('voting.index');
    //Route::post('/voting/{id}', [VotingController::class, 'vote'])->name('voting.vote');
    Route::post('/vote/{id}', [VotingController::class, 'vote'])->name('vote');
    //Route::post('/vote/{id}/{type}', [VotingController::class, 'vote'])->name('vote.vote');
    Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');
    Route::post('/laporan', [LaporanController::class, 'store']);
    Route::get('/getKategori/{jenis_id}', [LaporanController::class, 'getKategori']);
});

Route::middleware('only_admin')->group(function(){
    Route::get('dashboard', [DashboardController::class, 'dashboard']);
    Route::get('jenis', [JenisController::class, 'jenis'])->name('jenis');
    Route::post('jenis/store', [JenisController::class, 'store'])->name('jenis.store');
    Route::get('pengguna', [PenggunaController::class, 'pengguna'])->name('pengguna');
    Route::get('laporan', [LaporanController::class, 'admin'])->name('admin.laporan');
    Route::get('profile', [AkunController::class, 'profile']);
    Route::get('historylaporan', [HistoryController::class, 'historylaporan'])->name('historylaporan');
    Route::get('laporan/{id}', [LaporanController::class, 'admin'])->name('admin.laporan_detail');
    Route::post('/laporan/{id}/update-status', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
    Route::get('/admin/laporan/{id}', [LaporanController::class, 'deleteLaporan'])->name('admin.deleteLaporan');
    Route::post('/pengguna/add', [PenggunaController::class, 'tambahAkun'])->name('pengguna.add');
    Route::delete('/pengguna/delete/{id}', [PenggunaController::class, 'hapusAkun'])->name('pengguna.delete');
    Route::get('admin/voting', [AdminVotingController::class, 'index'])->name('admin.voting');
});