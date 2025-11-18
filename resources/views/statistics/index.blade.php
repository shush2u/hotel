@extends('components/layout')

@section('content')

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8 border-b pb-4">
            <h1 class="text-4xl font-extrabold text-neutral-800">Statistika</h1>
            <p class="text-neutral-600 mt-2">Pagrindiniai veiklos rodikliai ir išsamios kambarių metrikos.</p>
        </div>

        <!-- --- HIGH-LEVEL METRICS --- -->
        <h2 class="text-2xl font-semibold text-neutral-700 mb-4">Veiklos rodikliai</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">

            <!-- Total Rooms -->
            <div class="bg-blue-50 p-6 rounded-xl shadow-lg border border-blue-200">
                <p class="text-sm font-medium text-blue-600">Kambarių skaičius</p>
                <p class="text-4xl font-bold text-blue-800 mt-1">{{ $totalRooms }}</p>
            </div>

            <!-- Average Review Score -->
            <div class="bg-yellow-50 p-6 rounded-xl shadow-lg border border-yellow-200">
                <p class="text-sm font-medium text-yellow-600">Vidutinis atsiliepimo įvertis</p>
                <p class="text-4xl font-bold text-yellow-800 mt-1">
                    {{ number_format($avgReviewScore ?? 0, 1) }}
                    <span class="text-xl font-normal text-yellow-700">/ 5.0</span>
                </p>
            </div>

            <!-- Monthly Revenue Value (Proxy) -->
            <div class="bg-green-50 p-6 rounded-xl shadow-lg border border-green-200">
                <p class="text-sm font-medium text-green-600">Numatytos įplaukos ({{ $currentMonthName }})</p>
                <p class="text-4xl font-bold text-green-800 mt-1">
                    ${{ number_format($monthlyRevenueValue, 2) }}
                </p>
                <p class="text-xs text-green-500 mt-2">Bendra šio mėnesio rezervacijų vertė.</p>
            </div>

        </div>

        {{-- <!-- --- ROOM TYPE DISTRIBUTION --- -->
        <h2 class="text-2xl font-semibold text-neutral-700 mb-4">Room Type Distribution</h2>
        <div class="bg-white p-6 rounded-xl shadow-lg border border-neutral-200 mb-10">
            <ul class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @forelse ($roomTypeCounts as $type => $count)
                    <li class="p-3 bg-neutral-100 rounded-lg flex justify-between items-center">
                        <span class="text-neutral-700 font-medium">{{ $type }} Rooms</span>
                        <span class="text-2xl font-bold text-neutral-800">{{ $count }}</span>
                    </li>
                @empty
                    <li class="col-span-full text-center text-neutral-500">No room types defined yet.</li>
                @endforelse
            </ul>
        </div> --}}

        <!-- --- BOOKING DETAILS PER ROOM --- -->
        <h2 class="text-2xl font-semibold text-neutral-700 mb-4">Bendras rezervacijų kiekis per kambarį</h2>
        <div class="bg-white p-6 rounded-xl shadow-lg border border-neutral-200 overflow-x-auto">

            @if ($roomsWithBookings->isEmpty())
                <div class="text-center p-6 text-neutral-500">No rooms have been added to the system.</div>
            @else
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                Kambarys</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                Kambario tipas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                Kaina per parą</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                Bendras rezervacijų skaičius</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        @foreach ($roomsWithBookings as $room)
                            <tr class="hover:bg-neutral-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brand-700">
                                    <a href="{{ route('rooms.show', $room) }}"
                                        class="hover:underline">#{{ $room->roomNumber }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">
                                    {{ ucfirst($room->roomType->value) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-800">
                                    ${{ number_format($room->costPerNight, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-right text-neutral-800">
                                    {{ $room->roomBookings()->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>


    </div>

@endsection
