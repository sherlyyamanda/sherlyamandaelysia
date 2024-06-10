<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LaporanController;



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


Route::get('/',function(){
    return view('welcome',[
        "title"=>"Dashboard"
    ]);
});

Route::get('penjualan',function(){
    return view('penjualan.index',[
        "title"=>"Penjualan"
    ]);
})->name('penjualan');

Route::get('transaksi',function(){
    return view('penjualan.transaksis',[
        "title"=>"Transaksi"
    ]);
});


Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/',[WelcomeController::class,'welcome']);
Route::resource('pelanggan',PelangganController::class)->except('destroy');
Route::resource('produk',ProdukController::class)->except('produk.destroy');
Route::resource('pengguna',UserController::class)->except('destroy','create','show','update','edit');
Route::get('login',[LoginController::class,'loginView'])->name('login');
Route::post('login',[LoginController::class,'authenticate']);
Route::post('/logout',[LoginController::class,'logout']);
Route::get('cetakReceipt',[CetakController::class,'receipt'])->name('cetakReceipt');
