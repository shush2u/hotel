@extends('components/layout')

@section('content')
    <div class="bg-white p-6 rounded-sm shadow-md grow">

        <div class="">
            <a href="{{ route('home') }}" class="inline-flex items-center text-brand-600 hover:text-brand-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Back to Room List
            </a>
        </div>

        <h1 class="text-3xl font-extrabold text-brand-600 mb-4">Room #{{ $room->roomNumber }}</h1>
        <span class="text-sm font-semibold text-brand-600 bg-brand-100 px-3 py-1 rounded-sm">
            {{ ucwords($room->roomType->value) }}
        </span>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">

            <!-- COLUMN 1: Room Photo -->
            <div class="md:order-1 order-1">
                @if ($room->photo)
                    <div class="w-full h-80 md:h-full rounded-sm overflow-hidden shadow-xl border border-neutral-100">
                        <img src="{{ $room->photo }}" alt="Photo of Room #{{ $room->roomNumber }}"
                            class="w-full h-full object-cover"
                            onerror="this.onerror=null;this.src='https://placehold.co/800x600/38bdf8/ffffff?text=Image+Missing'">
                    </div>
                @else
                    <!-- Fallback if no photo is available -->
                    <div class="w-full h-80 md:h-full rounded-sm overflow-hidden shadow-xl border border-neutral-100">
                        <div class="w-full h-full bg-neutral-200 flex items-center justify-center">
                            <span class="text-neutral-500 text-lg">No Photo Available</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- COLUMN 2: Details, Cost, Description, and Amenities -->
            <div class="space-y-6 md:order-2 order-1">

                <!-- Cost -->
                <div class="p-4 bg-brand-100 rounded-sm border border-brand-200 shadow-sm">
                    <p class="text-sm font-medium text-brand-600">Nightly Cost</p>
                    <p class="text-3xl font-bold text-brand-700">${{ number_format($room->costPerNight, 2) }}</p>
                </div>

                <!-- Description -->
                <div class="p-4 bg-neutral-50 rounded-sm border border-neutral-200 shadow-sm">
                    <h3 class="text-xl font-semibold text-neutral-700 mb-2">Description</h3>
                    <p class="text-neutral-700">{{ $room->description }}</p>
                </div>

                <!-- Amenities -->
                <div class="p-4 bg-neutral-50 rounded-sm border border-neutral-200 shadow-sm">
                    <h3 class="text-xl font-semibold text-neutral-700 border-b pb-2 mb-3">Amenities</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center text-neutral-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mr-3 {{ $room->tv ? 'text-green-500' : 'text-red-500' }}" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="20" height="15" x="2" y="7" rx="2" ry="2" />
                                <path d="M17 2l-2 5" />
                            </svg>
                            TV: <span class="ml-2 font-semibold">{{ $room->tv ? 'Included' : 'Not Available' }}</span>
                        </li>
                        <li class="flex items-center text-neutral-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mr-3 {{ $room->wifi ? 'text-green-500' : 'text-red-500' }}"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20.94c.54 0 1.09-.08 1.63-.23a10 10 0 0 0 5.16-5.16c.15-.54.23-1.09.23-1.63" />
                                <path
                                    d="M12 20.94c-.54 0-1.09-.08-1.63-.23a10 10 0 0 1-5.16-5.16c-.15-.54-.23-1.09-.23-1.63" />
                                <line x1="12" x2="12.01" y1="17" y2="17" />
                                <path d="M5 8c4-1.5 8-1.5 12 0" />
                            </svg>
                            Wi-Fi: <span class="ml-2 font-semibold">{{ $room->wifi ? 'Free' : 'Not Available' }}</span>
                        </li>
                    </ul>
                </div>

                <form method="GET" action="{{ route('home') }}" class="space-y-6">
                    @csrf

                    <div class="flex flex-row items-center justify-between gap-4">

                        <div>
                            <label for="fromDate" class="block text-sm font-medium text-neutral-700 mb-1">From Date</label>
                            <input id="fromDate" name="fromDate" type="date" autocomplete="fromDate"
                                class="w-full px-4 py-2 border border-gray-300 rounded-sm focus:ring-blue-500 focus:border-blue-500 @error('fromDate') border-red-500 @enderror"
                                placeholder="you@example.com" />
                            @error('fromDate')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="toDate" class="block text-sm font-medium text-neutral-700 mb-1">To Date</label>
                            <input id="toDate" name="toDate" type="date" autocomplete="toDate"
                                class="w-full px-4 py-2 border border-neutral-300 rounded-sm
                        placeholder="you@example.com" />
                            @error('toDate')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="h-lh"></div>
                            <button type="submit"
                                class="cursor-pointer w-full flex items-center gap-2 py-2 px-4 border border-transparent rounded-sm shadow-sm text-lg font-medium text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                <x-lucide-notebook-pen class="w-5 h-5" />
                                Book this room
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
