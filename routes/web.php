<?php

use App\Http\Controllers\DataMobilController;
use App\Http\Controllers\DataPeminjamanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\ProfileController;
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

Route::post('check-email', [HomeController::class, 'checkEmail']);
Route::post('check-sim', [HomeController::class, 'checkSim']);

Route::prefix('get-data')->group(function(){
    Route::get('/mobil', [HomeController::class, 'getDataMobil'])->name('getDataMobil');
    Route::get('/metode-pembayaran', [HomeController::class, 'getMetodePembayaran'])->name('getMetodePembayaran');
    Route::post('/cek-tanggal-peminjaman', [HomeController::class, 'cekTanggalPeminjaman'])->name('cekTanggalPeminjaman');

    Route::get('/pinjaman', [HomeController::class, 'getPinjaman'])->name('getPinjaman');
    Route::get('/pengembalian', [HomeController::class, 'getPengembalian'])->name('getPengembalian');

    Route::get('/all-pinjaman', [HomeController::class, 'getAllPinjaman'])->name('getAllPinjaman');

    Route::get('/pinjamanku/{userId}', [HomeController::class, 'getDataPinjamanku'])->name('getDataPinjaman');
    Route::get('/pengembalianku/{userId}', [HomeController::class, 'getDataPengembalianku'])->name('getDataPengembalian');
});

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth', 'verified'])->prefix('/')->group(function(){
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::middleware(['admin'])->prefix('admin')->group(function(){
        
        // Done
        Route::prefix('data-mobil')->group(function(){
            Route::get('/', [DataMobilController::class, 'index'])->name('dataMobilAdmin');
            
            Route::get('/modal-tambah', [DataMobilController::class, 'modalTambahMobil'])->name('modalTambahMobil');
            Route::post('/tambah', [DataMobilController::class, 'store'])->name('postDataMobil');

            Route::get('/modal-edit/{id}', [DataMobilController::class, 'modalEditMobil'])->name('modalEditMobil');
            Route::put('/update/{id}', [DataMobilController::class, 'update'])->name('updateDataMobil');

            Route::get('/modal-hapus/{id}', [DataMobilController::class, 'modalHapusMobil'])->name('modalHapusMobil');
            Route::delete('/hapus/{id}', [DataMobilController::class, 'destroy'])->name('destroyDataMobil');
        });

        // Done
        Route::prefix('metode-pembayaran')->group(function(){
            Route::get('/', [MetodePembayaranController::class, 'index'])->name('metodePembayaran');
            
            Route::get('/modal-tambah', [MetodePembayaranController::class, 'modalTambahMetode'])->name('modalTambahMetode');
            Route::post('/tambah', [MetodePembayaranController::class, 'store'])->name('postDataMetode');

            Route::get('/modal-edit/{id}', [MetodePembayaranController::class, 'modalEditMetode'])->name('modalEditMetode');
            Route::put('/update/{id}', [MetodePembayaranController::class, 'update'])->name('updateDataMetode');

            Route::get('/modal-hapus/{id}', [MetodePembayaranController::class, 'modalHapusMetode'])->name('modalHapusMetode');
            Route::delete('/hapus/{id}', [MetodePembayaranController::class, 'destroy'])->name('destroyDataMetode');
        });

        Route::prefix('data-peminjaman')->group(function(){
            Route::get('/', [DataPeminjamanController::class, 'peminjamanAdmin'])->name('dataPeminjamanAdmin');

            Route::post('/modal-status-mobil/{peminjamanId}', [DataPeminjamanController::class, 'modalStatusMobil'])->name('modalStatusMobil');
            Route::put('/update-status-mobil/{peminjamanId}', [DataPeminjamanController::class, 'updateStatusMobil'])->name('updateStatusMobil');

            Route::post('/modal-status-bayar/{peminjamanId}', [DataPeminjamanController::class, 'modalStatusBayar'])->name('modalStatusBayar');
            Route::put('/update-status-bayar/{peminjamanId}', [DataPeminjamanController::class, 'updateStatusBayar'])->name('updateStatusBayar');

            Route::post('/modal-hapus/{peminjamanId}', [DataPeminjamanController::class, 'modalHapusPeminjaman'])->name('modalHapusPeminjaman');
            Route::delete('/hapus/{peminjamanId}', [DataPeminjamanController::class, 'hapusPeminjaman'])->name('hapusPeminjaman');
        });

        Route::prefix('data-pengembalian')->group(function(){
            Route::get('/', [DataPeminjamanController::class, 'pengembalianAdmin'])->name('dataPengembalianAdmin');
        });
    });
});

Route::middleware('auth')->group(function () {
    // Done
    Route::prefix('data-mobil')->group(function(){
        Route::get('/', [DataPeminjamanController::class, 'dataMobil'])->name('dataMobilUser');
        Route::get('/calendar/all', [DataPeminjamanController::class, 'allCalendarJadwal'])->name('allCalendarJadwal');
    });

    Route::prefix('data-peminjaman')->group(function(){
        Route::get('/', [DataPeminjamanController::class, 'peminjaman'])->name('dataPeminjamanUser');

        Route::post('/modal-tambah', [DataPeminjamanController::class, 'modalTambahSewa'])->name('modalTambahSewa');
        Route::post('/ajukan', [DataPeminjamanController::class, 'store'])->name('postDataSewa');

        Route::post('/modal-bayar/{peminjamanId}', [DataPeminjamanController::class, 'modalBayarSewa'])->name('modalBayarSewa');
        Route::put('/update-bayar/{peminjamanId}', [DataPeminjamanController::class, 'updateBayar'])->name('updateBayar');
    });

    Route::prefix('data-pengembalian')->group(function(){
        Route::get('/', [DataPeminjamanController::class, 'pengembalian'])->name('dataPengembalianUser');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
