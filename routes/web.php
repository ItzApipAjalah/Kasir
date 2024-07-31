<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PetugasGudangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Controller;

Route::middleware('redirect_if_authenticated:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('pelanggan.register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::middleware('redirect_if_authenticated:petugas')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('pelanggan.register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::middleware('redirect_if_authenticated:petugas_gudang')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('pelanggan.register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/', function () {
        return redirect()->route('login');
    });
});


Route::middleware('redirect_if_authenticated:pelanggan')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('pelanggan.register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('admin')->group(function () {
    // Route::get('/admin/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('admin.dashboard');

    Route::get('/admin/dashboard', [Controller::class, 'dashboard_admin'])->name('admin.dashboard');

    Route::get('/admin/petugas', [PetugasController::class, 'index'])->name('petugas.index');
    Route::get('/admin/petugas/create', [PetugasController::class, 'create'])->name('petugas.create');
    Route::post('/admin/petugas', [PetugasController::class, 'store'])->name('petugas.store');
    Route::get('/admin/petugas/{id}/edit', [PetugasController::class, 'edit'])->name('petugas.edit');
    Route::put('/admin/petugas/{id}', [PetugasController::class, 'update'])->name('petugas.update');
    Route::delete('/admin/petugas/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');

    Route::get('/admin/petugasgudang', [PetugasGudangController::class, 'index'])->name('petugas_gudang.index');
    Route::get('/admin/petugasgudang/create', [PetugasGudangController::class, 'create'])->name('petugas_gudang.create');
    Route::post('/admin/petugasgudang', [PetugasGudangController::class, 'store'])->name('petugas_gudang.store');
    Route::get('/admin/petugasgudang/{id}/edit', [PetugasGudangController::class, 'edit'])->name('petugas_gudang.edit');
    Route::put('/admin/petugasgudang/{id}', [PetugasGudangController::class, 'update'])->name('petugas_gudang.update');
    Route::delete('/admin/petugasgudang/{id}', [PetugasGudangController::class, 'destroy'])->name('petugas_gudang.destroy');

    // Routes for Produk
    Route::get('/admin/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/admin/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/admin/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/admin/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/admin/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});


// Rute untuk dashboard petugas
Route::middleware('petugas')->group(function () {
    // Route::get('/petugas/dashboard', function () {
    //     return view('petugas.dashboard');
    // })->name('petugas.dashboard');

    Route::get('/petugas/dashboard', [Controller::class, 'dashboard_petugas'])->name('petugas.dashboard');
});

Route::middleware(['auth:petugas_gudang'])->group(function () {
    Route::get('/petugas-gudang/dashboard', [Controller::class, 'dashboard_gudang'])->name('petugas_gudang.dashboard');
});


Route::prefix('pelanggan')->group(function () {
    Route::get('/dashboard', [Controller::class, 'dashboard_pelanggan'])->name('pelanggan.dashboard');
});

