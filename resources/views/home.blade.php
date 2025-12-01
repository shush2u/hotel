@extends('components/layout')

@section('content')
    <div class="bg-white p-6 rounded-sm shadow-md grow">

        <div class="flex justify-between items-center mb-4">

            <form method="GET" action="{{ route('home') }}" class="space-y-6">
                @csrf

                <div class="flex flex-row items-center justify-center gap-4 ">

                    <div>
                        <label for="fromDate" class="block text-sm font-medium text-neutral-700 mb-1">Nuo</label>
                        <input id="fromDate" name="fromDate" type="date" autocomplete="fromDate"
                            class="w-full px-4 py-2 border border-gray-300 rounded-sm focus:ring-blue-500 focus:border-blue-500 @error('fromDate') border-red-500 @enderror"
                            placeholder="you@example.com" />
                        @error('fromDate')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="toDate" class="block text-sm font-medium text-neutral-700 mb-1">Iki</label>
                        <input id="toDate" name="toDate" type="date" autocomplete="toDate"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-sm
                        placeholder="you@example.com" />
                        @error('toDate')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="roomType" class="block text-sm font-medium text-neutral-700 mb-1">Kambario tipas</label>
                        <select name="roomType" id="roomType"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-sm">
                            <option value="">Visi</option>
                            <option value="single">Vienvietis</option>
                            <option value="double">Dvivietis</option>
                            <option value="triple">Trivietis</option>
                        </select>
                        @error('roomType')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="h-lh"></div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-sm shadow-sm text-lg font-medium text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <x-lucide-search class="w-5 h-5" />
                        </button>
                    </div>

                </div>

            </form>

            @if (Auth::check() && Auth::user()->role->value === 'administrator')
                <div class="flex-col">
                    <div class="h-lh"> </div>
                    <a href="{{ route('rooms.create') }}">
                        <button
                            class="cursor-pointer flex items-center gap-2 rounded-sm bg-brand-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-brand-600 focus:shadow-none active:bg-brand-700 hover:bg-brand-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2"
                            type="submit">
                            <x-lucide-plus class="w-5 h-5" />
                            Įtraukti naują kambarį
                        </button>
                    </a>

                </div>
            @endif

        </div>


        @if ($rooms->isEmpty())
            <div class="text-center py-12 bg-white rounded-lg shadow-md">
                <p class="text-xl text-gray-500">
                    Kambarių nerasta.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($rooms as $room)
                    @php
                        $primaryPhoto = $room->photo;
                        $photoUrl = $primaryPhoto
                            ? $primaryPhoto
                            : 'https://placehold.co/600x400/312e81/ffffff?text=No+Photo';
                    @endphp

                    <div
                        class="bg-white rounded-sm overflow-hidden card-shadow hover:shadow-2xl transition duration-100 border border-gray-200">

                        <div class="h-48 bg-indigo-100">
                            <img src="{{ $photoUrl }}" alt="Photo of Room {{ $room->roomNumber }}"
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/orange/white?text=placeholder'">
                            
                        </div>

                        <div class="p-4 pb-2">
                            <div class="flex justify-between items-start mb-3">
                                <h2 class="text-2xl font-bold text-brand-600">
                                    Kambarys {{ $room->roomNumber }}
                                </h2>
                                <span class="text-sm font-semibold text-brand-600 bg-brand-100 px-3 py-1 rounded-sm">
                                    {{ ucwords($room->roomType->value) }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between space-x-2 mb-2 text-gray-700">

                                <div class="flex items-center space-x-2 text-gray-700">
                                    <span
                                        class="flex items-center gap-1 text-sm font-medium @if ($room->tv) text-green-600 @else text-red-500 @endif">
                                        @if ($room->tv)
                                            <x-lucide-monitor-check class="w-4 h-4" />
                                        @else
                                            <x-lucide-monitor-x class="w-4 h-4" />
                                        @endif
                                        TV
                                    </span>
                                    <span
                                        class="flex items-center gap-1 text-sm font-medium @if ($room->wifi) text-green-600 @else text-red-500 @endif">
                                        @if ($room->wifi)
                                            <x-lucide-wifi class="w-4 h-4" />
                                        @else
                                            <x-lucide-wifi-off class="w-4 h-4" />
                                        @endif
                                        WiFi
                                    </span>
                                </div>

                                <span
                                    class="bg-white text-brand-600 text-sm font-extrabold px-3 py-1 rounded-sm">
                                    ${{ number_format($room->costPerNight, 2) }}
                                </span>
                            </div>
                            

                        </div>

                        <div class="p-6 pt-0">
                            <a href="{{ route('rooms.show', ['room' => $room->id]) }}">
                                <button
                                    class="cursor-pointer w-full bg-brand-500 text-white font-semibold py-2 rounded-sm hover:bg-brand-600 transition duration-150">
                                    Peržiūrėti
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
