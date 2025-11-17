<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Enums\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();

        return view('rooms.index', [
            'rooms' => $rooms
        ]);
    }

    /**
     * Display the form to create a new room.
     */
    public function create()
    {
        $roomTypes = RoomType::cases(); 
        return view('rooms.create', compact('roomTypes'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            'roomNumber' => ['required', 'integer', 'unique:rooms,roomNumber', 'min:1'],
            'roomType' => ['required', 'string', 'in:single,double,triple'],
            'costPerNight' => ['required', 'numeric', 'min:0.01'],
            'description' => ['required', 'string', 'max:500'],
            'tv' => ['nullable', 'boolean'],
            'wifi' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'string'],
        ]);

        // 2. Create the room
        $room = Room::create([
            'roomNumber' => $validatedData['roomNumber'],
            'roomType' => RoomType::from($validatedData['roomType']),
            'costPerNight' => $validatedData['costPerNight'],
            'description' => $validatedData['description'],
            // Checkboxes are only present in request if checked. Set default to false if not present.
            'tv' => $request->has('tv'),
            'wifi' => $request->has('wifi'),
            'photo' => $validatedData['photo'],
        ]);

        // 3. Redirect to the newly created room's detail page with a success message
        return redirect()->route('rooms.show', $room)
            ->with('success_header', 'Kambarys sėkmingai įtrauktas!')    
            ->with('success', 'Naujas kambarys ' . $room->roomNumber . ' sėkmingai įtrauktas!');
    }

    /**
     * Display the specified room.
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
