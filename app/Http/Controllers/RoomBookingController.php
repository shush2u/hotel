<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class RoomBookingController extends Controller
{
    /**
     * Display a listing of all rooms with their upcoming and ongoing bookings.
     */
    public function index()
    {
        $rooms = Room::with(['roomBookings' => function ($query) {
            $query->where('toDate', '>', Carbon::today())
                ->orderBy('fromDate', 'asc') // Order bookings within each room by start date
                ->with('user'); // Eager load the user who made the booking
        }])
        ->orderBy('roomNumber', 'asc')
        ->get();

        return view('bookings.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a new room booking.
     */
    public function store(Request $request, Room $room)
    {
        // 1. Validation
        $validated = $request->validate([
            'fromDate' => ['required', 'date', 'after_or_equal:today'],
            'toDate' => ['required', 'date', 'after:fromDate'],
        ]);

        $fromDate = $validated['fromDate'];
        $toDate = $validated['toDate'];
        
        // 2. Availability Check using the Room Model's scope
        // We query the Room model again, applying the availability scope, but only for the current room ID.
        $availableRoom = Room::availableInDateRange($fromDate, $toDate)
                            ->where('id', $room->id)
                            ->first();

        if (!$availableRoom) {
            // If the room is not available, throw a custom validation exception
            throw ValidationException::withMessages([
                'fromDate' => 'This room is not available for the selected dates.',
                'toDate' => 'This room is not available for the selected dates.',
            ]);
        }

        // 3. Create Booking
        // This assumes you have an authenticated user (Auth::id()).
        // In a real application, you'd ensure authentication middleware is in place.
        RoomBooking::create([
            'user_id' => Auth::id() ?? 1, // Fallback to user_id 1 if not authenticated (for testing/demo)
            'room_id' => $room->id,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ]);

        // 4. Redirect with success message
        return redirect()->route('rooms.show', $room)
            ->with('success_header', 'Kambarys sėkmingai rezervuotas!')
            ->with('success', 'Kambarys nr' . $room->roomNumber . ' sėkmingai rezervuotas nuo ' . $fromDate . ' iki ' . $toDate . '!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomBooking $roomBooking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomBooking $roomBooking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomBooking $roomBooking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomBooking $roomBooking)
    {
        //
    }
}
