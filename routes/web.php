<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
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

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function () {
    Route::view('login', 'login')->name('login');
    Route::view('register', 'register')->name('register');

    Route::post('login', [LoginController::class, 'store'])->name('login.store');
    Route::post('register', [RegistrationController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::view('todos', 'todos')->name('todos');
    Route::view('users', 'users')->name('users');

    Route::delete('logout', [LoginController::class, 'delete'])->name('logout');
});
