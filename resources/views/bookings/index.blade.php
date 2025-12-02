@extends('components/layout')

@section('content')

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="{
        modalOpen: false,
        roomNumber: '',
        bookingInterval: '',
        cancelUrl: '',
        openCancelModal(room, interval, url) {
            this.roomNumber = room;
            this.bookingInterval = interval;
            this.cancelUrl = url;
            this.modalOpen = true;
        }
    }">

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
                                    @php
                                        $dateString =
                                            \Carbon\Carbon::parse($booking->fromDate)->format('M d, Y') .
                                            ' - ' .
                                            \Carbon\Carbon::parse($booking->toDate)->format('M d, Y');
                                    @endphp

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

                                        <button
                                            @click="openCancelModal('{{ $room->roomNumber }}', '{{ $dateString }}', '{{ route('my_bookings.destroy', $booking) }}')"
                                            class="cursor-pointer flex items-center gap-2 rounded-sm bg-red-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-red-600 focus:shadow-none active:bg-red-700 hover:bg-red-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                            type="button">
                                            <x-lucide-trash class="w-5 h-5" />
                                            Atšaukti
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <el-dialog>
            <dialog :open="modalOpen" id="room-booking-cancel-confirm-modal" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent z-50">

                <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity" x-show="modalOpen"
                    x-transition.opacity></el-dialog-backdrop>

                <div tabindex="0"
                    class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">

                    <el-dialog-panel
                        class="relative transform overflow-hidden rounded-sm bg-neutral-100 shadow-xl outline -outline-offset-1 outline-white/10 transition-all sm:my-8 sm:w-full sm:max-w-lg"
                        x-show="modalOpen" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <div class="mt-6 text-center sm:text-center">

                            <div class="w-full flex justify-center items-center">
                                <div
                                    class="mx-auto w-full flex size-12 shrink-0 items-center justify-center rounded-full bg-red-500 sm:mx-0 sm:size-10">
                                    <x-lucide-circle-question-mark class="w-8 h-8 text-red-200" />
                                </div>
                            </div>

                            {{-- Dynamic Title --}}
                            <h3 id="dialog-title" class="mt-2 text-base font-semibold text-neutral-800">
                                Atšaukti šią rezervacija kambariui <span x-text="roomNumber"></span>?
                            </h3>

                            <div class="mt-2">
                                {{-- Dynamic Time Interval --}}
                                <p class="text-sm font-medium text-neutral-600 mb-2" x-text="bookingInterval"></p>

                                <p class="text-sm text-neutral-800">
                                    Šis veiksmas yra negrįžtamas!
                                </p>
                            </div>

                        </div>

                        <div class="my-3 px-4 py-3 gap-4 flex justify-center sm:px-6">

                            {{-- Close Button --}}
                            <button type="button" @click="modalOpen = false"
                                class="mt-3 inline-flex w-full justify-center rounded-sm bg-neutral-200 px-3 py-2 text-sm font-semibold text-neutral-800 inset-ring inset-ring-white/5 hover:bg-neutral-300 sm:mt-0 sm:w-auto">
                                Atšaukti
                            </button>

                            {{-- Form with Dynamic Action --}}
                            <form method="POST" :action="cancelUrl">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="cursor-pointer mt-3 inline-flex w-full justify-center rounded-sm bg-red-500 px-3 py-2 text-sm font-semibold text-neutral-0 inset-ring inset-ring-white/5 hover:bg-neutral-300 sm:mt-0 sm:w-auto">
                                    Pašalinti
                                </button>
                            </form>


                        </div>

                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>


    </div>

@endsection
