<?php

use App\Http\Controllers\Obat\DataObatController;
use App\Http\Controllers\Obat\ExpObatController;
use App\Http\Controllers\Obat\InObatController;
use App\Http\Controllers\Obat\KategoriObatController;
use App\Http\Controllers\Obat\OutObatController;
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

    //data obat
    Route::get('data-obat', [DataObatController::class, 'index'])->name('data-obat');
    Route::get('data-obat/datatable', [DataObatController::class, 'datatable'])->name('data-obat-datatable');
    Route::post('data-obat', [DataObatController::class, 'store'])->name('data-obat-create');
    Route::get('data-obat/{id}', [DataObatController::class, 'show'])->name('data-obat-detail');
    Route::post('data-obat/{id}', [DataObatController::class, 'update'])->name('data-obat-update');
    Route::delete('data-obat/{id}', [DataObatController::class, 'destroy'])->name('data-obat-delete');

    //exp obat
    Route::get('exp-obat', [ExpObatController::class, 'index'])->name('exp-obat');
    Route::get('exp-obat/datatable', [ExpObatController::class, 'datatable'])->name('exp-obat-datatable');
    Route::post('exp-obat', [ExpObatController::class, 'store'])->name('exp-obat-create');
    Route::get('exp-obat/{id}', [ExpObatController::class, 'show'])->name('exp-obat-detail');
    Route::post('exp-obat/{id}', [ExpObatController::class, 'update'])->name('exp-obat-update');
    Route::delete('exp-obat/{id}', [ExpObatController::class, 'destroy'])->name('exp-obat-delete');

    //in obat
    Route::get('in-obat', [InObatController::class, 'index'])->name('in-obat');
    Route::get('in-obat/datatable', [InObatController::class, 'datatable'])->name('in-obat-datatable');
    Route::post('in-obat', [InObatController::class, 'store'])->name('in-obat-create');
    Route::get('in-obat/{id}', [InObatController::class, 'show'])->name('in-obat-detail');
    Route::post('in-obat/{id}', [InObatController::class, 'update'])->name('in-obat-update');
    Route::delete('in-obat/{id}', [InObatController::class, 'destroy'])->name('in-obat-delete');

    //out obat
    Route::get('out-obat', [OutObatController::class, 'index'])->name('out-obat');
    Route::get('out-obat/datatable', [OutObatController::class, 'datatable'])->name('out-obat-datatable');
    Route::post('out-obat', [OutObatController::class, 'store'])->name('out-obat-create');
    Route::get('out-obat/{id}', [OutObatController::class, 'show'])->name('out-obat-detail');
    Route::post('out-obat/{id}', [OutObatController::class, 'update'])->name('out-obat-update');
    Route::delete('out-obat/{id}', [OutObatController::class, 'destroy'])->name('out-obat-delete');
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
