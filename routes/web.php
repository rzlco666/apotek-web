<?php

use App\Http\Controllers\Faktur\DataFakturController;
use App\Http\Controllers\Obat\DataObatController;
use App\Http\Controllers\Obat\ExpObatController;
use App\Http\Controllers\Obat\InObatController;
use App\Http\Controllers\Obat\KategoriObatController;
use App\Http\Controllers\Obat\OutObatController;
use App\Http\Controllers\Obat\StokObatController;
use App\Http\Controllers\Pesanan\SuratPesananController;
use App\Http\Controllers\Setting\ProfileController;
use App\Http\Controllers\Setting\RoleController;
use App\Http\Controllers\Setting\PermissionController;
use App\Http\Controllers\Setting\UserController;
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

    //stok obat
    Route::get('stok-obat', [StokObatController::class, 'index'])->name('stok-obat');
    Route::get('stok-obat/datatable', [StokObatController::class, 'datatable'])->name('stok-obat-datatable');
    Route::get('stok-obat/{id}', [StokObatController::class, 'show'])->name('stok-obat-detail');
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

Route::prefix('faktur')->middleware(['auth'])->group(function () {
    //kategori obat
    Route::get('data-faktur', [DataFakturController::class, 'index'])->name('data-faktur');
    Route::get('data-faktur/datatable', [DataFakturController::class, 'datatable'])->name('data-faktur-datatable');
    Route::post('data-faktur', [DataFakturController::class, 'store'])->name('data-faktur-create');
    Route::get('data-faktur/{id}', [DataFakturController::class, 'show'])->name('data-faktur-detail');
    Route::post('data-faktur/{id}', [DataFakturController::class, 'update'])->name('data-faktur-update');
    Route::delete('data-faktur/{id}', [DataFakturController::class, 'destroy'])->name('data-faktur-delete');
});

Route::prefix('pesanan')->middleware(['auth'])->group(function () {
    //kategori obat
    Route::get('surat-pesanan', [SuratPesananController::class, 'index'])->name('surat-pesanan');
    Route::get('surat-pesanan/datatable', [SuratPesananController::class, 'datatable'])->name('surat-pesanan-datatable');
    Route::post('surat-pesanan', [SuratPesananController::class, 'store'])->name('surat-pesanan-create');
    Route::get('surat-pesanan/{id}', [SuratPesananController::class, 'show'])->name('surat-pesanan-detail');
    Route::post('surat-pesanan/{id}', [SuratPesananController::class, 'update'])->name('surat-pesanan-update');
    Route::delete('surat-pesanan/{id}', [SuratPesananController::class, 'destroy'])->name('surat-pesanan-delete');
    Route::get('surat-pesanan/pdf/{id}', [SuratPesananController::class, 'pdf'])->name('surat-pesanan-pdf');
});

Route::prefix('setting')->middleware(['auth'])->group(function () {
    //profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('user-profile');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');

    //role
    Route::get('role', [RoleController::class, 'index'])->name('role');
    Route::get('role/datatable', [RoleController::class, 'datatable'])->name('role-datatable');
    Route::post('role', [RoleController::class, 'store'])->name('role-create');
    Route::get('role/{id}', [RoleController::class, 'show'])->name('role-detail');
    Route::post('role/{id}', [RoleController::class, 'update'])->name('role-update');
    Route::delete('role/{id}', [RoleController::class, 'destroy'])->name('role-delete');

    //Permission
    Route::get('permission', [PermissionController::class, 'index'])->name('permission');
    Route::get('permission/datatable', [PermissionController::class, 'datatable'])->name('permission-datatable');
    Route::post('permission', [PermissionController::class, 'store'])->name('permission-create');
    Route::get('permission/{id}', [PermissionController::class, 'show'])->name('permission-detail');
    Route::post('permission/{id}', [PermissionController::class, 'update'])->name('permission-update');
    Route::delete('permission/{id}', [PermissionController::class, 'destroy'])->name('permission-delete');
    Route::get('permission/all/data', [PermissionController::class, 'allPermission'])->name('permission-all');

     //User
     Route::get('user', [UserController::class, 'index'])->name('user');
     Route::get('user/datatable', [UserController::class, 'datatable'])->name('user-datatable');
     Route::post('user', [UserController::class, 'store'])->name('user-create');
     Route::get('user/{id}', [UserController::class, 'show'])->name('user-detail');
     Route::post('user/{id}', [UserController::class, 'update'])->name('user-update');
     Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user-delete');
});
