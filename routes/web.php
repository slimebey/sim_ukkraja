<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\KategoriController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});


Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
 
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
    });
    

    Route::prefix('aspirasi')->name('aspirasi.')->group(function () {
        Route::get('/', [AdminController::class, 'daftarAspirasi'])->name('index');
        Route::get('/{id}', [AdminController::class, 'detailAspirasi'])->name('detail');
        Route::post('/{id}/status', [AdminController::class, 'updateStatus'])->name('update-status');
        Route::post('/{id}/feedback', [AdminController::class, 'beriFeedback'])->name('feedback');
    });
 
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
}); 


    Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {
 
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    

    Route::get('/buat', [AspirasiController::class, 'create'])->name('buat');
    Route::post('/store', [AspirasiController::class, 'store'])->name('store');
    Route::get('/histori', [AspirasiController::class, 'histori'])->name('histori');
    Route::get('/{id}', [AspirasiController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [AspirasiController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AspirasiController::class, 'update'])->name('update');
    Route::delete('/{id}', [AspirasiController::class, 'destroy'])->name('destroy');
});