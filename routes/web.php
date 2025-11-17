<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomBookingController;
use App\Models\Room;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

// Home

Route::get('/', function (Request $request) {
    $query = Room::query();

    if ($request->filled('roomType')) {
        $query->where('roomType', $request->roomType);
    }

    if ($request->filled(['fromDate', 'toDate'])) {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        $query->availableInDateRange($fromDate, $toDate);
    }

    $rooms = $query->get();

    return view('home', compact('rooms'));
})->name('home');

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

// Statistics

Route::view('statistics', 'statistics')->name('statistics');

// Room

Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');

Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');

Route::post('/rooms/{room}/book', [RoomBookingController::class, 'store'])->name('bookings.store');

// Room Bookings

Route::view('myBookings', 'myBookings')->name('myBookings');

// Reviews

Route::view('reviews', 'reviews')->name('reviews');