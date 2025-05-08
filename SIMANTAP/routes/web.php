<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\JenisTeknisiController;
use App\Http\Controllers\AuthController;



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

Route::middleware(['auth'])->group(function () {
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
    });
});