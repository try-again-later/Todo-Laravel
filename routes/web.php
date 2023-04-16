<?php

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

Route::get('/', fn() => view('home'))->name('home');
Route::get('todos', fn() => view('todos'))->name('todos');
Route::get('users', fn() => view('users'))->name('users');
Route::get('login', fn() => view('login'))->name('login');
Route::get('register', fn() => view('register'))->name('register');
Route::post('logout', fn() => redirect()->route('home'))->name('logout');
