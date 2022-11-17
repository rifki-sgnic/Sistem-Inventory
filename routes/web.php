<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::get('/master', [ProductController::class, 'index'])->name('admin.master');
    Route::post('/master/tambah', [ProductController::class, 'tambah'])->name('master.tambah');
    Route::post('/master/update', [ProductController::class, 'update'])->name('master.update');
    Route::post('/master/hapus', [ProductController::class, 'hapus'])->name('master.hapus');

    Route::get('/supplier', [SupplierController::class, 'index'])->name('admin.supplier');

    // Route::get('/list-barang', [DashboardController::class, 'adminDashboard'])->name('admin.list-barang');
    Route::get('/list-barang', function () {
        return view('admin.listbarang');
    })->name('admin.list-barang');

    Route::get('/barang-masuk', [DashboardController::class, 'adminDashboard'])->name('admin.barang-masuk');

    Route::get('/barang-keluar', [DashboardController::class, 'adminDashboard'])->name('admin.barang-keluar');

    Route::get('/return', [DashboardController::class, 'adminDashboard'])->name('admin.return');

    Route::get('/user-management', [UserController::class, 'index'])->name('admin.user-management');
    Route::post('/user-management/tambah', [UserController::class, 'tambah'])->name('user-management.tambah');
    Route::post('/user-management/hapus', [UserController::class, 'hapus'])->name('user-management.hapus');

});
