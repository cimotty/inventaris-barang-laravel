<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

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
    return redirect ('/items');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/export-qr', [ItemController::class, 'exportQR']);
    Route::get('/export-report', [ItemController::class, 'exportReport']);
    Route::get('/user/profile', [UserController::class, 'index']);
});

Route::get('/items/{item:id}', [ItemController::class, 'show']);

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);