<?php

use App\Http\Controllers\Obat\KategoriObatController;
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
    Route::post('store-kategori-obat', [KategoriObatController::class, 'store']);
    Route::post('edit-kategori-obat', [KategoriObatController::class, 'edit']);
    Route::post('delete-kategori-obat', [KategoriObatController::class, 'destroy']);

});
