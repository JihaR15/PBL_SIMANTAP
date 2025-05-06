<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
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
    });
});