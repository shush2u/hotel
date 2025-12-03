<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\Review;
use App\Enums\RoomType;
use App\Services\RoomService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{

    protected RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $notifications = 0;
        }

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
        $validatedData = $request->validate([
            'roomNumber' => ['required', 'integer', 'unique:rooms,roomNumber', 'min:1'],
            'roomType' => ['required', 'string', 'in:single,double,triple'],
            'costPerNight' => ['required', 'numeric', 'min:0.01'],
            'description' => ['required', 'string', 'max:500'],
            'tv' => ['nullable', 'boolean'],
            'wifi' => ['nullable', 'boolean'],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageFile = $request->file('photo');

        $imageData = $imageFile->getContent();

        $room = Room::create([
            'roomNumber' => $validatedData['roomNumber'],
            'roomType' => RoomType::from($validatedData['roomType']),
            'costPerNight' => $validatedData['costPerNight'],
            'description' => $validatedData['description'],
            'tv' => $request->has('tv'),
            'wifi' => $request->has('wifi'),
            'photo' => $imageData,
        ]);

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
        $validatedData = $request->validate([
            'roomNumber' => ['required', 'integer', Rule::unique('rooms')->ignore($room->id), 'min:1'],
            'roomType' => ['required', 'string', 'in:single,double,triple'],
            'costPerNight' => ['required', 'numeric', 'min:0.01'],
            'description' => ['required', 'string', 'max:500'],
            'tv' => ['nullable', 'boolean'],
            'wifi' => ['nullable', 'boolean'],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageFile = $request->file('photo');

        $imageData = $imageFile->getContent();

        $updateData = [
            'roomNumber' => $validatedData['roomNumber'],
            'roomType' => RoomType::from($validatedData['roomType']),
            'costPerNight' => $validatedData['costPerNight'],
            'description' => $validatedData['description'],
            'tv' => $request->has('tv'),
            'wifi' => $request->has('wifi'),
            'photo' => $imageData,
        ];

        $room->update($updateData);

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

    /**
     * Display the owner's statistics dashboard.
     */
    public function statistics()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // 1. Total Rooms
        $totalRooms = Room::count();

        // // 2. Room Count by Type (e.g., ['single' => 5, 'double' => 3])
        // $roomTypeCounts = Room::select('roomType', DB::raw('count(*) as count'))
        //     ->groupBy('roomType')
        //     ->get()
        //     ->mapWithKeys(function ($row) {
        //         // $row->roomType is the raw DB string like 'single'
        //         $enum = RoomType::from($row->roomType);        // convert to enum
        //         return [ucfirst($enum->value) => (int) $row->count];
        //     });

        // 3. Rooms with RoomBooking Count (For table)
        $roomsWithBookings = Room::withCount('roomBookings')
            ->orderBy('roomNumber', 'asc')
            ->get();
        
        // 4. Average Review Score
        $avgReviewScore = Review::avg('rating');

        // 5. Projected Monthly Revenue (Total value of all bookings made this month)
        // This calculates the total value of reservations added to the system during the current month.
        $bookingsMadeThisMonth = RoomBooking::where(function ($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('fromDate', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('toDate', [$startOfMonth, $endOfMonth])
                ->orWhere(function ($q2) use ($startOfMonth, $endOfMonth) {
                    // Booking fully spans the month
                    $q2->where('fromDate', '<=', $startOfMonth)
                        ->where('toDate', '>=', $endOfMonth);
                });
            })
            ->with('room') // important for costPerNight
            ->get();
        
        $monthlyRevenueValue = 0;
        foreach ($bookingsMadeThisMonth as $RoomBooking) {
            // Calculate nights booked: date difference is inclusive start, exclusive end, so no +1 needed.
            $nights = Carbon::parse($RoomBooking->fromDate)->diffInDays(Carbon::parse($RoomBooking->toDate));
            
            // Check if the related room still exists before calculating value
            if ($RoomBooking->room) {
                $monthlyRevenueValue += $nights * $RoomBooking->room->costPerNight;
            }
        }

        // 6. Total Lifetime Revenue (Total value of all bookings ever made)
        $allBookings = RoomBooking::with('room')->get();

        $currentMonthName = Carbon::now()->format('F');

        return view('statistics.index', compact(
            'totalRooms',
            //'roomTypeCounts',
            'roomsWithBookings',
            'avgReviewScore',
            'monthlyRevenueValue',
            'currentMonthName'
        ));
    }

    public function scheduleMaintenance(Request $request, Room $room)
    {
        $validatedData = $request->validate([
            'fromDate' => ['required', 'date'],
            'toDate' => [
                'required', 
                'date', 
                'after_or_equal:fromDate' 
            ],
        ]);

        $success = $this->roomService->markRoomForMaintenance(
            $room, 
            $validatedData['fromDate'], 
            $validatedData['toDate']
        );

        if ($success) {
            Session::flash('success', "Room {$room->roomNumber} has been successfully scheduled for maintenance from {$validatedData['fromDate']} to {$validatedData['toDate']}.");
        } else {
            Session::flash('error', "Failed to schedule maintenance for Room {$room->roomNumber}.");
        }

        return back();
    }
}
