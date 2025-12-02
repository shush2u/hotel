<?php

namespace App\Services;

use App\Models\Room;
use App\Models\RoomBooking;
use App\Enums\BookingType;
use App\Enums\NotificationType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RoomService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Marks a room for maintenance by deleting overlapping bookings,
     * notifying affected users, and creating a maintenance booking.
     *
     * @param Room $room The room model instance to mark for maintenance.
     * @param string $fromDate The start date of the maintenance (YYYY-MM-DD).
     * @param string $toDate The end date of the maintenance (YYYY-MM-DD).
     * @return bool True on success, false otherwise.
     */
    public function markRoomForMaintenance(Room $room, string $fromDate, string $toDate): bool
    {
        $start = Carbon::parse($fromDate)->format('Y-m-d');
        $end = Carbon::parse($toDate)->format('Y-m-d');

        return DB::transaction(function () use ($room, $start, $end) {
            
            $overlappingBookings = $room->roomBookings()
                ->where('booking_type', '!=', BookingType::MAINTENANCE)
                ->where(function ($query) use ($start, $end) {
                    $query->where('fromDate', '<', $end) 
                          ->where('toDate', '>', $start);
                })
                ->with('user')
                ->get();

            $notificationMessage = "Your booking for room **{$room->roomNumber}** between **{$start}** and **{$end}** has been **cancelled** due to scheduled maintenance.";
            
            foreach ($overlappingBookings as $booking) {
                if ($booking->user) {
                    $this->notificationService->createNotification(
                        $booking->user->id,
                        $notificationMessage,
                        NotificationType::IMPORTANT
                    );
                }
            }

            $deletedCount = $room->roomBookings()
                ->where('booking_type', '!=', BookingType::MAINTENANCE)
                ->where(function ($query) use ($start, $end) {
                    $query->where('fromDate', '<', $end) 
                          ->where('toDate', '>', $start);
                })
                ->delete();
            
            $maintenanceBooking = RoomBooking::create([
                'user_id' => Auth::user()->id,
                'room_id' => $room->id,
                'fromDate' => $start,
                'toDate' => $end,
                'booking_type' => BookingType::MAINTENANCE,
            ]);

            return $maintenanceBooking->exists;
        });
    }
}