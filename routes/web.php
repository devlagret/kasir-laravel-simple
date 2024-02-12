<?php

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    // * masukan route disini
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('index');
        Route::get('add', [PelangganController::class, 'create'])->name('add');
        Route::post('add', [PelangganController::class, 'processCreate'])->name('process-add');
        Route::get('edit/{PelangganID?}', [PelangganController::class, 'update'])->name('update');
        Route::post('edit', [PelangganController::class, 'processUpdate'])->name('process-update');
        Route::get('delete/{PelangganID?}', [PelangganController::class, 'delete'])->name('delete');
        Route::post('element-add', [PelangganController::class, 'elemenAdd'])->name('element-add');
    });
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('index');
        Route::get('add', [PenjualanController::class, 'create'])->name('add');
        Route::post('add', [PenjualanController::class, 'processCreate'])->name('process-add');
        Route::post('add-item', [PenjualanController::class, 'addSalesItem'])->name('add-item');
        Route::post('delete-item', [PenjualanController::class, 'deleteSalesItem'])->name('delete-item');
        Route::post('change-qty-item', [PenjualanController::class, 'changeQtySalesItem'])->name('change-qty-item');
        Route::get('edit/{PenjualanID?}', [PenjualanController::class, 'update'])->name('update');
        Route::post('edit', [PenjualanController::class, 'processUpdate'])->name('process-update');
        Route::get('delete/{PenjualanID?}', [PenjualanController::class, 'delete'])->name('delete');
        Route::post('element-add', [PenjualanController::class, 'elemenAdd'])->name('element-add');
    });
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::get('add', [ProdukController::class, 'create'])->name('add');
        Route::post('add', [ProdukController::class, 'processCreate'])->name('process-add');
        Route::get('edit/{ProdukID?}', [ProdukController::class, 'update'])->name('update');
        Route::post('edit', [ProdukController::class, 'processUpdate'])->name('process-update');
        Route::get('delete/{ProdukID?}', [ProdukController::class, 'delete'])->name('delete');
        Route::post('element-add', [ProdukController::class, 'elemenAdd'])->name('element-add');
    });
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('add', [UserController::class, 'create'])->name('add');
        Route::post('add', [UserController::class, 'processCreate'])->name('process-add');
        Route::get('edit/{UserID?}', [UserController::class, 'update'])->name('update');
        Route::post('edit', [UserController::class, 'processUpdate'])->name('process-update');
        Route::get('delete/{UserID?}', [UserController::class, 'delete'])->name('delete');
        Route::post('element-add', [UserController::class, 'elemenAdd'])->name('element-add');
    });
});