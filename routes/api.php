<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/customers/list', [Controller::class, 'list'])->name('customers.list');
    Route::get('/costumer/{id}/detail', [Controller::class, 'ListById'])->name('customers.detail');
    Route::get('/transactions/{id}/details', [TransactionController::class, 'getTransactionDetails']);

    Route::post('/login', [AuthAPIController::class, 'login'])->name('api.login');

    Route::post('/register', [AuthAPIController::class, 'register'])->name('api.register');

    Route::post('/logout', [AuthAPIController::class, 'logout'])->name('api.logout')->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->get('/user', [AuthAPIController::class, 'user']);
});
