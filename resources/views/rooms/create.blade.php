@extends('components/layout')

@section('content')
    <div class="bg-white p-6 rounded-sm shadow-md grow">

        <div class="max-w-4xl mx-auto py-4 sm:px-6 lg:px-8">

            <!-- Header & Back Button -->
            <div class="mb-6 border-b pb-4">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center text-brand-600 hover:text-brand-800 transition mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    Atgal į pagrindinį
                </a>
                <h1 class="text-3xl font-extrabold text-neutral-800">Įtraukti naują kambarį</h1>
                <p class="text-neutral-600 mt-1">Užpildykite duomenis kad įtraukti naują kambarį į sistemą.</p>
            </div>

            <!-- Form for Room Creation -->
            <form method="POST" action="{{ route('rooms.store') }}" class="space-y-6">
                @csrf

                <!-- Grid for primary details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Room Number -->
                    <div>
                        <label for="roomNumber" class="block text-sm font-medium text-neutral-700 mb-1">Kambario
                            numeris</label>
                        <input id="roomNumber" name="roomNumber" type="text" min="1" required
                            value="{{ old('roomNumber') }}"
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
                            <option value="" disabled selected>Tipas</option>
                            @foreach ($roomTypes as $type)
                                <option value="{{ $type->value }}" {{ old('roomType') == $type->value ? 'selected' : '' }}>
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
                            value="{{ old('costPerNight') }}"
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
                        class="w-full px-3 py-2 border rounded-sm @error('description') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo URL -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-neutral-700 mb-1">Kambario nuotrauka (Max
                        2MB,
                        JPEG/PNG)</label>
                    <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/jpg"
                        class="w-full px-3 py-2 border rounded-sm @error('photo') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500" />
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amenities (Checkboxes) -->
                <fieldset class="border p-4 rounded-sm">
                    <legend class="text-lg font-semibold text-neutral-800 px-2">Kita</legend>

                    <div class="flex items-center mb-4">
                        <input id="tv" name="tv" type="checkbox" value="1"
                            {{ old('tv') ? 'checked' : '' }}
                            class="h-4 w-4 text-brand-600 border-gray-300 rounded focus:ring-blue-500" />
                        <label for="tv" class="ml-3 text-sm font-medium text-neutral-700">Televizorius</label>
                    </div>

                    <div class="flex items-center mb-3">
                        <input id="wifi" name="wifi" type="checkbox" value="1"
                            {{ old('wifi') ? 'checked' : '' }}
                            class="h-4 w-4 text-brand-600 border-gray-300 rounded focus:ring-blue-500" />
                        <label for="wifi" class="ml-3 text-sm font-medium text-neutral-700">Wi-Fi</label>
                    </div>
                </fieldset>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-sm shadow-md text-lg font-bold text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition duration-150 ease-in-out">
                        Save New Room
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
