<?php

use App\Http\Controllers\DataMobilController;
use App\Http\Controllers\DataPeminjamanController;
use App\Http\Controllers\HomeController;
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

        Route::prefix('data-peminjaman')->group(function(){
            Route::get('/', [DataPeminjamanController::class, 'peminjaman'])->name('dataPeminjamanAdmin');
        });

        Route::prefix('data-pengembalian')->group(function(){
            Route::get('/', [DataPeminjamanController::class, 'pengembalian'])->name('dataPengembalianAdmin');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
