@extends('components/layout')

@section('content')

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="mb-8 border-b pb-4">
            <h1 class="text-4xl font-extrabold text-neutral-800">Kambarių rezervacijos</h1>
            <p class="text-neutral-600 mt-2">Rezervacijų sąrašas su visomis esamomis ir ateities rezervacijomis.</p>
        </div>

        @if ($rooms->isEmpty())
            <div class="text-center p-12 bg-neutral-100 rounded-lg border border-neutral-200">
                <h3 class="mt-2 text-xl font-medium text-neutral-900">No Rooms Defined</h3>
                <p class="mt-1 text-sm text-neutral-600">
                    Please add rooms to the system first.
                </p>
            </div>
        @else
            <div class="space-y-10">
                @foreach ($rooms as $room)
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-neutral-200">

                        <!-- Room Header -->
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-neutral-200">
                            <h2 class="text-2xl font-bold text-brand-600">
                                Kambarys {{ $room->roomNumber }}
                                <span
                                    class="text-xl font-medium text-neutral-500">({{ ucfirst($room->roomType->value) }})</span>
                            </h2>
                            <a href="{{ route('rooms.show', $room) }}"
                                class="text-sm font-medium text-brand-600 hover:text-brand-700 transition">Kambario
                                informacija
                                &rarr;</a>
                        </div>

                        <!-- Bookings List -->
                        @if ($room->roomBookings->isEmpty())
                            <div class="p-4 bg-yellow-50 rounded-lg text-yellow-800 border border-yellow-300">
                                <p class="font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline mr-2 align-text-bottom"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M12 8v4" />
                                        <path d="M12 16h.01" />
                                    </svg>
                                    Rezervacijų nėra.
                                </p>
                            </div>
                        @else
                            <ul class="divide-y divide-neutral-100">
                                @foreach ($room->roomBookings as $booking)
                                    <li
                                        class="py-4 flex gap-8 justify-between items-center transition duration-200 hover:bg-neutral-50 px-2 -mx-2 rounded-md">

                                        <!-- Date and Timeframe -->
                                        <div>
                                            <p class="text-lg font-semibold text-neutral-800">
                                                {{ \Carbon\Carbon::parse($booking->fromDate)->format('M d, Y') }}
                                                <span class="text-neutral-500 mx-1">&rarr;</span>
                                                {{ \Carbon\Carbon::parse($booking->toDate)->format('M d, Y') }}
                                            </p>
                                            <p class="text-sm text-neutral-600 mt-0.5">
                                                Paros:
                                                <span
                                                    class="font-mono">{{ \Carbon\Carbon::parse($booking->fromDate)->diffInDays($booking->toDate) }}</span>
                                            </p>
                                        </div>

                                        <!-- User Info -->
                                        <div class="text-right">
                                            <p class="text-base font-medium text-green-700">
                                                Rezervavo:
                                                <span class="font-bold">
                                                    {{ $booking->user->fullName ?? 'User ID ' . $booking->user_id }}
                                                </span>
                                            </p>
                                            <p class="text-xs text-neutral-500 mt-1">
                                                Rezervavo prieš: {{ $booking->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif


    </div>

@endsection
