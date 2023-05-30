<?php

use App\Http\Controllers\Obat\KategoriObatController;
use App\Http\Controllers\Supplier\SupplierController;
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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::prefix('obat')->middleware(['auth'])->group(function () {
    //kategori obat
    Route::get('kategori-obat', [KategoriObatController::class, 'index'])->name('kategori-obat');
    Route::get('kategori-obat/datatable', [KategoriObatController::class, 'datatable'])->name('kategori-obat-datatable');
    Route::post('kategori-obat', [KategoriObatController::class, 'store'])->name('kategori-obat-create');
    Route::get('kategori-obat/{id}', [KategoriObatController::class, 'show'])->name('kategori-obat-detail');
    Route::post('kategori-obat/{id}', [KategoriObatController::class, 'update'])->name('kategori-obat-update');
    Route::delete('kategori-obat/{id}', [KategoriObatController::class, 'destroy'])->name('kategori-obat-delete');
});

Route::prefix('supplier')->middleware(['auth'])->group(function () {
    //kategori obat
    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier');
    Route::get('supplier/datatable', [SupplierController::class, 'datatable'])->name('supplier-datatable');
    Route::post('supplier', [SupplierController::class, 'store'])->name('supplier-create');
    Route::get('supplier/{id}', [SupplierController::class, 'show'])->name('supplier-detail');
    Route::post('supplier/{id}', [SupplierController::class, 'update'])->name('supplier-update');
    Route::delete('supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier-delete');
});
