<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReceiveController;
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

/* Access Level Admin */
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    // Route Data Master Barang
    Route::get('/master', [ProductController::class, 'index'])->name('admin.master');
    Route::post('/master/tambah', [ProductController::class, 'tambah'])->name('master.tambah');
    Route::post('/master/update', [ProductController::class, 'update'])->name('master.update');
    Route::post('/master/hapus', [ProductController::class, 'hapus'])->name('master.hapus');

    // Route Data Supplier
    Route::get('/supplier', [SupplierController::class, 'index'])->name('admin.supplier');
    Route::post('/supplier/tambah', [SupplierController::class, 'tambah'])->name('supplier.tambah');
    Route::post('/supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::post('/supplier/hapus', [SupplierController::class, 'hapus'])->name('supplier.hapus');

    // Route Data List Barang
    Route::get('/list-barang', function () {
        return view('admin.listbarang', ['title' => 'List Barang']);
    })->name('admin.list-barang');

    // Route Data Barang Masuk
    Route::get('/receive', [ReceiveController::class, 'index'])->name('admin.receive');
    Route::post('/receive/tambah', [ReceiveController::class, 'tambah'])->name('receive.tambah');
    Route::post('/receive/hapus', [ReceiveController::class, 'hapus'])->name('receive.hapus');

    // Route Data Barang Keluar
    Route::get('/barang-keluar', function () {
        return view('admin.barangkeluar', [
            'title' => 'Barang Keluar'
        ]);
    })->name('admin.barang-keluar');

    // Route Data Return
    Route::get('/return', function () {
        return view('admin.return', ['title' => 'Return']);
    })->name('admin.return');

    // Route Data User Management
    Route::get('/user-management', [UserController::class, 'index'])->name('admin.user-management');
    Route::post('/user-management/tambah', [UserController::class, 'tambah'])->name('user-management.tambah');
    Route::post('/user-management/update', [UserController::class, 'update'])->name('user-management.update');
    Route::post('/user-management/hapus', [UserController::class, 'hapus'])->name('user-management.hapus');
});
