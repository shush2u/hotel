<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Enums\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $roomTypes = RoomType::cases();
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            // 'unique:rooms,roomNumber,' . $room->id ensures the number is unique
            // BUT ignores the current room's ID, allowing the number to remain the same.
            'roomNumber' => ['required', 'integer', Rule::unique('rooms')->ignore($room->id), 'min:1'],
            'roomType' => ['required', 'string', 'in:single,double,triple'],
            'costPerNight' => ['required', 'numeric', 'min:0.01'],
            'description' => ['required', 'string', 'max:500'],
            'tv' => ['nullable', 'boolean'],
            'wifi' => ['nullable', 'boolean'],
            // Photo is nullable on update (user doesn't have to re-upload)
            //'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg'], 
            'photo' => ['nullable', 'string'],
        ]);

        // // 2. Handle Photo Upload / Deletion
        // $photoPath = $room->photo; // Default to existing photo path
        // if ($request->hasFile('photo')) {
        //     // Delete old photo if it exists
        //     if ($room->photo) {
        //         Storage::disk('public')->delete($room->photo);
        //     }
        //     // Store the new photo
        //     $photoPath = $request->file('photo')->store('room_photos', 'public');
        // }

        // 3. Prepare data for update
        $updateData = [
            'roomNumber' => $validatedData['roomNumber'],
            'roomType' => RoomType::from($validatedData['roomType']),
            'costPerNight' => $validatedData['costPerNight'],
            'description' => $validatedData['description'],
            'tv' => $request->has('tv'),
            'wifi' => $request->has('wifi'),
            //'photo' => $photoPath,
            'photo' => $request->has('photo'),
        ];

        // 4. Update the room
        $room->update($updateData);

        // 5. Redirect to the room's detail page with a success message
        return redirect()->route('rooms.show', $room)
            ->with('success_header', 'Kambarys sėkmingai atnaujintas!')
            ->with('success', 'Kambarys ' . $room->roomNumber . ' sėkmingai atnaujintas!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        // 1. Manually delete all associated bookings first
        $room->roomBookings()->delete();

        // // 2. Delete associated photo file from storage
        // if ($room->photo) {
        //     Storage::disk('public')->delete($room->photo);
        // }

        // 3. Delete the room record
        $roomNumber = $room->roomNumber;
        $room->delete();

        // 4. Redirect
        return redirect()->route('home')
            ->with('success', 'Kambarys ' . $roomNumber . ' sėkmingai ištrintas iš sistemos (įskaitant visas rezervacijas).');
    }
}
