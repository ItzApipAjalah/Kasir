<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PetugasGudangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\DisplayTransactionController;

// redirect ke dasboard ketika sudah login
Route::middleware('redirect_if_authenticated:admin,petugas,petugas_gudang,pelanggan')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('pelanggan.register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Rute untuk dashboard admin
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

    Route::get('produk/{id}/barcode', [ProdukController::class, 'showBarcode'])->name('produk.showBarcode');
    Route::get('produk/{id}/download-barcode', [ProdukController::class, 'downloadBarcode'])->name('admin.produk.downloadBarcode');

});


// Rute untuk dashboard petugas
Route::middleware('petugas')->group(function () {
    // Route::get('/petugas/dashboard', function () {
    //     return view('petugas.dashboard');
    // })->name('petugas.dashboard');

    Route::get('/petugas/dashboard', [Controller::class, 'dashboard_petugas'])->name('petugas.dashboard');

    Route::get('/petugas/history', [Controller::class, 'history_petugas'])->name('petugas.history');
    Route::get('/petugas/get-petugas-id', function () {
        return response()->json(Auth::guard('petugas')->user()->id);
    });
});

// route untuk dashboard petugas gudang
Route::middleware(['auth:petugas_gudang'])->group(function () {
    Route::get('/petugas-gudang/dashboard', [Controller::class, 'dashboard_gudang'])->name('petugas_gudang.dashboard');
    // Routes for Produk
    Route::get('/petugas-gudang/produk', [GudangController::class, 'index'])->name('gudang.produk.index');
    Route::get('/petugas-gudang/produk/create', [GudangController::class, 'create'])->name('gudang.produk.create');
    Route::post('/petugas-gudang/produk', [GudangController::class, 'store'])->name('gudang.produk.store');
    Route::get('/petugas-gudang/produk/{id}/edit', [GudangController::class, 'edit'])->name('gudang.produk.edit');
    Route::put('/petugas-gudang/produk/{id}', [GudangController::class, 'update'])->name('gudang.produk.update');
    Route::delete('/petugas-gudang/produk/{id}', [GudangController::class, 'destroy'])->name('gudang.produk.destroy');

    Route::get('produk/{id}/download-barcode', [ProdukController::class, 'downloadBarcode'])->name('gudang.produk.downloadBarcode');
});

// route dasboard pelanggan
Route::middleware(['auth:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', [Controller::class, 'dashboard_pelanggan'])->name('pelanggan.dashboard');

    Route::get('pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::put('pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::get('pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');
});

Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

Route::get('/customers/list', [Controller::class, 'list'])->name('customers.list');
Route::get('/transactions/{id}/details', [TransactionController::class, 'getTransactionDetails']);

// Add this new route
Route::get('/latest-transaction', [TransactionController::class, 'getLatestTransaction'])->name('transactions.latest');

Route::get('/latest-transaction-display', function () {
    return view('transactions.latest-transaction');
})->name('transactions.latest-display');

// Add these new routes
Route::post('/display-transactions', [DisplayTransactionController::class, 'store']);
Route::get('/display-transactions', [DisplayTransactionController::class, 'index']);
Route::delete('/display-transactions', [DisplayTransactionController::class, 'destroy']);

Route::get('/petugas/transaction/{id}/pdf', [PetugasController::class, 'generatePdf'])->name('petugas.transaction.pdf');
