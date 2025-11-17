@extends('components/layout')

@section('content')
    <div class="bg-white p-6 rounded-sm shadow-md grow">

        <div class="max-w-4xl mx-auto py-4 sm:px-6 lg:px-8">

            <div class="flex justify-between">

                <div class="mb-6 border-b pb-4">
                    <a href="{{ route('rooms.show', $room) }}"
                        class="inline-flex items-center text-brand-600 hover:text-brand-800 transition mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Atgal į kambarį #{{ $room->roomNumber }}
                    </a>
                    <h1 class="text-3xl font-extrabold text-neutral-800">Redaguoti kambarį #{{ $room->roomNumber }}</h1>
                    <p class="text-neutral-600 mt-1">Atnaujinkite pasirinkto kambario duomenis.</p>
                </div>

                <button command="show-modal" commandfor="room-remove-confirm-modal"
                    class="cursor-pointer flex items-center gap-2 h-10 rounded-sm bg-red-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-red-600 focus:shadow-none active:bg-red-700 hover:bg-red-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="submit">
                    <x-lucide-trash class="w-5 h-5" />
                    Pašalinti
                </button>

            </div>

            <!-- Form for Room Editing -->
            {{-- Action points to the update route, passing the Room model --}}
            <form method="POST" action="{{ route('rooms.update', $room) }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT') {{-- Spoofs the PUT method for updates --}}

                <!-- Grid for primary details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Room Number -->
                    <div>
                        <label for="roomNumber" class="block text-sm font-medium text-neutral-700 mb-1">Kambario
                            numeris</label>
                        <input id="roomNumber" name="roomNumber" type="text" min="1" required
                            {{-- Populate with existing data or old input --}} value="{{ old('roomNumber', $room->roomNumber) }}"
                            class="w-full px-3 py-2 border rounded-sm @error('roomNumber') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500" />
                        @error('roomNumber')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Room Type -->
                    <div>
                        <label for="roomType" class="block text-sm font-medium text-neutral-700 mb-1">Kambario tipas</label>
                        <select id="roomType" name="roomType" required
                            class="w-full px-3 py-2 border rounded-sm @error('roomType') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500">
                            <option value="" disabled>Tipas</option>
                            @foreach ($roomTypes as $type)
                                @php
                                    // Use old data if validation failed, otherwise use the existing room's type value
$currentType = old('roomType', $room->roomType->value);
                                @endphp
                                <option value="{{ $type->value }}" {{ $currentType == $type->value ? 'selected' : '' }}>
                                    {{ ucfirst($type->value) }}
                                </option>
                            @endforeach
                        </select>
                        @error('roomType')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cost Per Night -->
                    <div>
                        <label for="costPerNight" class="block text-sm font-medium text-neutral-700 mb-1">Kaina parai
                            ($)</label>
                        <input id="costPerNight" name="costPerNight" type="number" step="0.01" min="0.01" required
                            value="{{ old('costPerNight', $room->costPerNight) }}"
                            class="w-full px-3 py-2 border rounded-sm @error('costPerNight') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500" />
                        @error('costPerNight')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-neutral-700 mb-1">Aprašymas</label>
                    <textarea id="description" name="description" rows="4" required
                        class="w-full px-3 py-2 border rounded-sm @error('description') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500">{{ old('description', $room->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo Upload -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-neutral-700 mb-1">Kambario nuotrauka (Max
                        2MB, JPEG/PNG)
                        <span class="font-normal text-neutral-500">(Palikite tuščią, jei nenorite keisti)</span>
                    </label>
                    <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/jpg"
                        class="w-full px-3 py-2 border rounded-sm @error('photo') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500" />
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    @if ($room->photo)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-neutral-700 mb-2">Dabartinė nuotrauka:</p>
                            <img src="{{ Storage::url($room->photo) }}" alt="Current Room Photo"
                                class="h-32 w-32 object-cover rounded-md shadow-md">
                        </div>
                    @endif
                </div>

                <!-- Amenities (Checkboxes) -->
                <fieldset class="border p-4 rounded-sm">
                    <legend class="text-lg font-semibold text-neutral-800 px-2">Kita</legend>

                    <div class="flex items-center mb-4">
                        <input id="tv" name="tv" type="checkbox" value="1" {{-- Check if old data is '1' OR if existing room data is true --}}
                            {{ old('tv') == '1' || ($room->tv && old('tv') !== '0') ? 'checked' : '' }}
                            class="h-4 w-4 text-brand-600 border-gray-300 rounded focus:ring-blue-500" />
                        <label for="tv" class="ml-3 text-sm font-medium text-neutral-700">Televizorius</label>
                    </div>

                    <div class="flex items-center mb-3">
                        <input id="wifi" name="wifi" type="checkbox" value="1" {{-- Check if old data is '1' OR if existing room data is true --}}
                            {{ old('wifi') == '1' || ($room->wifi && old('wifi') !== '0') ? 'checked' : '' }}
                            class="h-4 w-4 text-brand-600 border-gray-300 rounded focus:ring-blue-500" />
                        <label for="wifi" class="ml-3 text-sm font-medium text-neutral-700">Wi-Fi</label>
                    </div>
                </fieldset>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-sm shadow-md text-lg font-bold text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition duration-150 ease-in-out">
                        Išsaugoti pakeitimus
                    </button>
                </div>
            </form>
        </div>

    </div>

    <el-dialog>
        <dialog id="room-remove-confirm-modal" aria-labelledby="dialog-title"
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
                                class="mx-auto w-full flex size-12 shrink-0 items-center justify-center rounded-full bg-red-500 sm:mx-0 sm:size-10">
                                <x-lucide-circle-question-mark class="w-8 h-8 text-red-200" />
                            </div>

                        </div>

                        <h3 id="dialog-title" class="mt-2 text-base font-semibold text-neutral-800">
                            Pašalinti kambarį {{ $room->roomNumber }}?
                        </h3>

                        <div class="mt-2">
                            <p class="text-sm text-neutral-800">
                                Šis veiksmas yra negrįžtamas!
                            </p>
                        </div>

                    </div>

                    <div class="my-3 px-4 py-3 gap-4 flex justify-center sm:px-6">

                        <button type="button" command="close" commandfor="room-remove-confirm-modal"
                            class="mt-3 inline-flex w-full justify-center rounded-sm bg-neutral-200 px-3 py-2 text-sm font-semibold text-neutral-800 inset-ring inset-ring-white/5 hover:bg-neutral-300 sm:mt-0 sm:w-auto">
                            Atšaukti
                        </button>

                        <form method="POST" action="{{ route('rooms.destroy', $room) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" command="close" commandfor="room-remove-confirm-modal"
                                class="cursor-pointer mt-3 inline-flex w-full justify-center rounded-sm bg-red-500 px-3 py-2 text-sm font-semibold text-neutral-0 inset-ring inset-ring-white/5 hover:bg-neutral-300 sm:mt-0 sm:w-auto">
                                Pašalinti
                            </button>

                        </form>


                    </div>

                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>
@endsection
