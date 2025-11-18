<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
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

Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');

Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');

Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');

Route::delete('/rooms/{room}/destroy', [RoomController::class, 'destroy'])->name('rooms.destroy');

// Room Bookings

Route::get('/bookings', [RoomBookingController::class, 'index'])->name('bookings.index');

Route::view('myBookings', 'myBookings')->name('myBookings');

Route::post('/rooms/{room}/book', [RoomBookingController::class, 'store'])->name('bookings.store');

// Reviews

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Statistics

Route::get('/statistics', [RoomController::class, 'statistics'])->name('statistics.index');