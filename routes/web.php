<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiveController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ListProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RequestProductController;

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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

/* Access Level Admin & SuperAdmin */
Route::middleware(['role:admin|superadmin|testing'])->group(function () {

    //Chart
    Route::get('/chart', [DashboardController::class, 'chart']);

    // Route Data Master Barang
    Route::get('/master', [ProductController::class, 'index'])->name('master.index');
    Route::post('/master/tambah', [ProductController::class, 'tambah'])->name('master.tambah');
    Route::post('/master/update', [ProductController::class, 'update'])->name('master.update');
    Route::post('/master/hapus', [ProductController::class, 'hapus'])->name('master.hapus');
    Route::post('/master/cetak-pdf', [ProductController::class, 'cetakPdf'])->name('master.cetak');

    // Route Data List Barang
    Route::post('/list-barang/tambah', [ListProductController::class, 'tambah'])->name('list-barang.tambah');
    Route::post('/list-barang/update', [ListProductController::class, 'update'])->name('list-barang.update');
    Route::post('/list-barang/hapus', [ListProductController::class, 'hapus'])->name('list-barang.hapus');

    // Route Data Barang Masuk
    Route::get('/receive', [ReceiveController::class, 'index'])->name('receive.index');
    Route::post('/receive/tambah', [ReceiveController::class, 'tambah'])->name('receive.tambah');
    Route::post('/receive/update', [ReceiveController::class, 'update'])->name('receive.update');
    Route::post('/receive/hapus', [ReceiveController::class, 'hapus'])->name('receive.hapus');
    Route::post('/receive/cetak-pdf', [ReceiveController::class, 'cetakPdf'])->name('receive.cetak');

    // Route Data Barang Keluar
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::post('/transaction/tambah', [TransactionController::class, 'tambah'])->name('transaction.tambah');
    Route::post('/transaction/update', [TransactionController::class, 'update'])->name('transaction.update');
    Route::post('/transaction/hapus', [TransactionController::class, 'hapus'])->name('transaction.hapus');
    Route::post('/transaction/cetak-pdf', [TransactionController::class, 'cetakPdf'])->name('transaction.cetak');

    // Route Data Return
    Route::post('/return/tambah', [ReturnController::class, 'tambah'])->name('return.tambah');
    Route::post('/return/update', [ReturnController::class, 'update'])->name('return.update');
    Route::post('/return/hapus', [ReturnController::class, 'hapus'])->name('return.hapus');
});

Route::middleware(['role:admin|superadmin|purchasing|testing'])->group(function () {
    // Route Data Return
    Route::get('/return', [ReturnController::class, 'index'])->name('return.index');
    Route::post('/return', [ReturnController::class, 'updateStatus']);
    Route::post('/return/cetak-pdf', [ReturnController::class, 'cetakPdf'])->name('return.cetak');

    // Route Data Supplier
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
});

Route::middleware(['role:purchasing|testing'])->group(function () {
    Route::post('/supplier/tambah', [SupplierController::class, 'tambah'])->name('supplier.tambah');
    Route::post('/supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::post('/supplier/hapus', [SupplierController::class, 'hapus'])->name('supplier.hapus');
    Route::get('/supplier/cetak-pdf', [SupplierController::class, 'cetakPdf'])->name('supplier.cetak');
});

/* Access Level Admin */
Route::middleware(['role:superadmin|testing'])->group(function () {
    // Route Data User Management
    Route::get('/user-management', [UserController::class, 'index'])->name('admin.user-management');
    Route::post('/user-management/tambah', [UserController::class, 'tambah'])->name('user-management.tambah');
    Route::post('/user-management/update', [UserController::class, 'update'])->name('user-management.update');
    Route::post('/user-management/hapus', [UserController::class, 'hapus'])->name('user-management.hapus');
});

Route::middleware(['role:admin|superadmin|purchasing|testing'])->group(function () {
    Route::get('/request-barang', [RequestProductController::class, 'index'])->name('request-barang.index');
    Route::get('/request-barang/tambah', [RequestProductController::class, 'tambah'])->name('request-barang.tambah');
    Route::post('/request-barang/store', [RequestProductController::class, 'store'])->name('request-barang.store');
    Route::post('/request-barang/detail/update-status', [RequestProductController::class, 'updateStatus'])->name('request-barang.update-status');
    Route::post('/request-barang/detail/update-produk', [RequestProductController::class, 'updateDetailProduct'])->name('request-barang.update-produk');
    Route::post('/request-barang/detail/hapus-produk', [RequestProductController::class, 'deleteDetailProduct'])->name('request-barang.hapus-produk');
    Route::post('/request-barang/cetak-pdf', [RequestProductController::class, 'cetakPdf'])->name('request-barang.cetak');
});

Route::middleware(['role:admin|superadmin|warehouse|purchasing|testing'])->group(function () {
    // Route Data List Barang
    Route::get('/list-barang', [ListProductController::class, 'index'])->name('list-barang.index');
    Route::post('/list-barang', [ListProductController::class, 'updateStatus']);
    Route::post('/list-barang/update-po', [ListProductController::class, 'updateNoPo']);
    Route::post('/list-barang/cetak-pdf', [ListProductController::class, 'cetakPdf'])->name('list-barang.cetak');
    Route::post('/list-barang/update-supplier', [ListProductController::class, 'updateSupplier'])->name('list-barang.update-supplier');

    Route::get('/request-barang/detail/{id}', [RequestProductController::class, 'detail'])->name('request-barang.detail');
    Route::post('/request-barang/detail/add-note-produk', [RequestProductController::class, 'addNoteDetailProduct'])->name('request-barang.add-note-produk');
});