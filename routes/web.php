<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// Home

Route::get('/', function () {
    return view('home');
})->name('home');

// User Login

Route::get('login', function () {
    return view('login');
})->name('login');

Route::post('login', [UserController::class, 'authenticate'])->name('login.attempt');

Route::post('logout', function () {
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();

    return redirect('/');
})->name('logout');

// User Registration

Route::view('register', 'register')->name('register');

Route::post('register', [UserController::class, 'register'])->name('register.attempt');