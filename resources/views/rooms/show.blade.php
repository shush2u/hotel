@extends('components/layout')

@section('content')
    <div class="bg-white p-6 rounded-sm shadow-md grow">

        <div class="">
            <a href="{{ route('home') }}" class="inline-flex items-center text-brand-600 hover:text-brand-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Atgal į pagrindinį
            </a>
        </div>

        <div class="flex gap-4 items-center">

            <h1 class="text-3xl font-extrabold text-brand-600">Kambarys nr. {{ $room->roomNumber }}</h1>
            <span class="text-sm font-semibold text-brand-600 bg-brand-100 px-3 py-1 rounded-sm">
                {{ ucwords($room->roomType->value) }}
            </span>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">

            <!-- COLUMN 1: Room Photo -->
            <div class="md:order-1 order-1">
                @if ($room->photo)
                    <div class="w-full h-80 md:h-full rounded-sm overflow-hidden shadow-xl border border-neutral-100">
                        <img src="{{ $room->photo }}" alt="Photo of Room #{{ $room->roomNumber }}"
                            class="w-full h-full object-cover"
                            onerror="this.onerror=null;this.src='https://placehold.co/800x600/38bdf8/ffffff?text=Nuotrauka+nerasta'">
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
                    <p class="text-sm font-medium text-brand-600">Kaina parai</p>
                    <p class="text-3xl font-bold text-brand-700">${{ number_format($room->costPerNight, 2) }}</p>
                </div>

                <!-- Description -->
                <div class="p-4 bg-neutral-50 rounded-sm border border-neutral-200 shadow-sm">
                    <h3 class="text-xl font-semibold text-neutral-700 mb-2">Aprašymas</h3>
                    <p class="text-neutral-700">{{ $room->description }}</p>
                </div>

                <!-- Amenities -->
                <div class="p-4 bg-neutral-50 rounded-sm border border-neutral-200 shadow-sm">
                    <h3 class="text-xl font-semibold text-neutral-700 border-b pb-2 mb-3">Kita</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center text-neutral-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mr-3 {{ $room->tv ? 'text-green-500' : 'text-red-500' }}" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="20" height="15" x="2" y="7" rx="2" ry="2" />
                                <path d="M17 2l-2 5" />
                            </svg>
                            TV: <span class="ml-2 font-semibold">{{ $room->tv ? 'Yra' : 'Nėra' }}</span>
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
                            Wi-Fi: <span class="ml-2 font-semibold">{{ $room->wifi ? 'Yra' : 'Nėra' }}</span>
                        </li>
                    </ul>
                </div>

                @auth

                    <form method="POST" action="{{ route('bookings.store', $room) }}" class="space-y-6">
                        @csrf

                        <div class="flex flex-row items-center justify-between gap-4">

                            <div>
                                <label for="fromDate" class="block text-sm font-medium text-neutral-700 mb-1">Nuo</label>
                                <input id="fromDate" name="fromDate" type="date" required
                                    value="{{ old('fromDate', request('fromDate')) }}"
                                    class="w-full px-3 py-2 border rounded-sm @error('fromDate') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500" />
                                @error('fromDate')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="toDate" class="block text-sm font-medium text-neutral-700 mb-1">Iki</label>
                                <input id="toDate" name="toDate" type="date" required
                                    value="{{ old('toDate', request('toDate')) }}"
                                    class="w-full px-3 py-2 border rounded-sm @error('toDate') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500" />
                                @error('toDate')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <div class="h-lh"></div>
                                <button type="submit"
                                    class="cursor-pointer w-full h-10 flex items-center gap-2 py-2 px-4 border border-transparent rounded-sm shadow-sm text-lg font-medium text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <x-lucide-notebook-pen class="w-5 h-5" />
                                    Rezervuoti
                                </button>
                                @if ($errors->any())
                                    <div class="h-[2lh]"></div>
                                @enderror
                        </div>

                    </div>

                </form>

            @endauth

            @guest

                <button disabled
                    class="w-full flex items-center justify-center gap-2 py-2 px-4 border rounded-sm shadow-sm text-lg font-medium text-brand-800 border-brand-300 bg-brand-100">
                    <x-lucide-notebook-pen class="w-5 h-5" />
                    Prisijungkite kad rezervuoti šį kambarį
                </button>

            @endguest

        </div>

    </div>

    @if (session()->has('success'))
        <el-dialog>
            <dialog id="booking-success-modal" aria-labelledby="dialog-title" open
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

                <div tabindex="0"
                    class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">

                    <el-dialog-panel
                        class="relative transform overflow-hidden rounded-sm bg-neutral-100 shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">

                        <div class="mt-6 text-center sm:text-center">

                            <div class="w-full flex justify-center items-center">

                                <div
                                    class="mx-auto w-full flex size-12 shrink-0 items-center justify-center rounded-full bg-green-500 sm:mx-0 sm:size-10">
                                    <x-lucide-check class="w-5 h-5 text-green-200" />
                                </div>

                            </div>

                            <h3 id="dialog-title" class="mt-2 text-base font-semibold text-neutral-800">
                                {{ session('success_header') }}
                            </h3>

                            <div class="mt-2">
                                <p class="text-sm text-neutral-800">
                                    {{ session('success') }}
                                </p>
                            </div>

                        </div>

                        <div class="my-3 px-4 py-3 gap-4 flex justify-center sm:px-6">

                            <button type="button" command="close" commandfor="booking-success-modal"
                                class="mt-3 inline-flex w-full justify-center rounded-sm bg-neutral-200 px-3 py-2 text-sm font-semibold text-neutral-800 inset-ring inset-ring-white/5 hover:bg-neutral-300 sm:mt-0 sm:w-auto">
                                Uždaryti
                            </button>

                        </div>

                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>
    @endif

</div>
@endsection
