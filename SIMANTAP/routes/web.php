<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BarangLokasiController;
use App\Http\Controllers\JenisTeknisiController;



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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login', [AuthController::class,'postlogin']);
Route::get('logout', [AuthController::class,'logout'])->middleware('auth');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', [WelcomeController::class,'dashboard'])->name('dashboard');

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('user', [UserController::class,'index'])->name('user.index');
        Route::post('user/list', [UserController::class,'list'])->name('user.list');
        Route::get('user/create', [UserController::class,'create'])->name('user.create');
        Route::get('user/{id}/show/', [UserController::class,'show'])->name('user.show');
        Route::post('user/store', [UserController::class,'store'])->name('user.store');
        Route::get('user/{id}/edit/', [UserController::class,'edit'])->name('user.edit');
        Route::put('user/{id}/update/', [UserController::class,'update'])->name('user.update');
        Route::get('user/{id}/delete/', [UserController::class,'confirmDelete'])->name('user.confirmDelete');
        Route::delete('user/{id}/delete/', [UserController::class,'destroy'])->name('user.delete');
        Route::post('/user/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');

        //role
        Route::get('role', [RoleController::class,'index'])->name('role.index');
        Route::post('role/list', [RoleController::class,'list'])->name('role.list');
        Route::get('role/create', [RoleController::class,'create'])->name('role.create');
        Route::get('role/{id}/show/', [RoleController::class,'show'])->name('role.show');
        Route::post('role/store', [RoleController::class,'store'])->name('role.store');
        Route::get('role/{id}/edit/', [RoleController::class,'edit'])->name('role.edit');
        Route::put('role/{id}/update/', [RoleController::class,'update'])->name('role.update');
        Route::get('role/{id}/delete/', [RoleController::class,'confirmDelete'])->name('role.confirmDelete');
        Route::delete('role/{id}/delete/', [RoleController::class,'destroy'])->name('role.delete');

        //jenis teknisi
        Route::get('jenisteknisi', [JenisTeknisiController::class,'index'])->name('jenisteknisi.index');
        Route::post('jenisteknisi/list', [JenisTeknisiController::class,'list'])->name('jenisteknisi.list');
        Route::get('jenisteknisi/create', [JenisTeknisiController::class,'create'])->name('jenisteknisi.create');
        Route::get('jenisteknisi/{id}/show/', [JenisTeknisiController::class,'show'])->name('jenisteknisi.show');
        Route::post('jenisteknisi/store', [JenisTeknisiController::class,'store'])->name('jenisteknisi.store');
        Route::get('jenisteknisi/{id}/edit/', [JenisTeknisiController::class,'edit'])->name('jenisteknisi.edit');
        Route::put('jenisteknisi/{id}/update/', [JenisTeknisiController::class,'update'])->name('jenisteknisi.update');
        Route::get('jenisteknisi/{id}/delete/', [JenisTeknisiController::class,'confirmDelete'])->name('jenisteknisi.confirmDelete');
        Route::delete('jenisteknisi/{id}/delete/', [JenisTeknisiController::class,'destroy'])->name('jenisteknisi.delete');

        // Jenis Barang
        Route::get('jenisbarang', [JenisBarangController::class,'index'])->name('jenisbarang.index');
        Route::post('jenisbarang/list', [JenisBarangController::class,'list'])->name('jenisbarang.list');
        Route::get('jenisbarang/create', [JenisBarangController::class,'create'])->name('jenisbarang.create');
        Route::get('jenisbarang/{id}/show/', [JenisBarangController::class,'show'])->name('jenisbarang.show');
        Route::post('jenisbarang/store', [JenisBarangController::class,'store'])->name('jenisbarang.store');
        Route::get('jenisbarang/{id}/edit/', [JenisBarangController::class,'edit'])->name('jenisbarang.edit');
        Route::put('jenisbarang/{id}/update/', [JenisBarangController::class,'update'])->name('jenisbarang.update');
        Route::get('jenisbarang/{id}/delete/', [JenisBarangController::class,'confirmDelete'])->name('jenisbarang.confirmDelete');
        Route::delete('jenisbarang/{id}/delete/', [JenisBarangController::class,'destroy'])->name('jenisbarang.delete');

        // Lokasi Barang
        Route::get('lokasibarang', [BarangLokasiController::class, 'index'])->name('lokasibarang.index');
        Route::post('lokasibarang/list', [BarangLokasiController::class, 'list'])->name('lokasibarang.list');
        Route::get('lokasibarang/{tempat_id}/show', [BarangLokasiController::class, 'show'])->name('lokasibarang.show');
        Route::get('lokasibarang/{tempat_id}/create', [BarangLokasiController::class, 'create'])->name('lokasibarang.create');
        Route::post('lokasibarang/{tempat_id}/store', [BarangLokasiController::class, 'store'])->name('lokasibarang.store');
        Route::get('/lokasibarang/{tempat_id}/confirmDelete/{jenis_barang_id}', [BarangLokasiController::class, 'confirmDelete'])->name('lokasibarang.confirmDelete');
        Route::delete('/lokasibarang/{tempat_id}/delete/{jenis_barang_id}', [BarangLokasiController::class, 'delete'])->name('lokasibarang.delete');
    });

    Route::middleware(['authorize:MHS,DSN,TDK'])->group(function () {
        Route::get('laporan', [LaporanController::class,'index'])->name('laporan.index');
        Route::get('/riwayatlaporan', [LaporanController::class, 'riwayatLaporan'])->name('riwayatlaporan');
        Route::post('laporan/list', [LaporanController::class,'list'])->name('laporan.list');
        Route::get('/laporan/{id}/show', [LaporanController::class, 'show'])->name('laporan.show');
        Route::post('laporan/store', [LaporanController::class,'store'])->name('laporan.store');
        // Route::get('laporan/{id}/edit/', [LaporanController::class,'edit'])->name('laporan.edit');
        // Route::put('laporan/{id}/update/', [LaporanController::class,'update'])->name('laporan.update');
        Route::get('laporan/{id}/delete/', [LaporanController::class,'confirmDelete'])->name('laporan.confirmDelete');
        Route::delete('laporan/{id}/delete/', [LaporanController::class,'destroy'])->name('laporan.delete');
    });
});
