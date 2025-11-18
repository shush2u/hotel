@extends('components/layout')

@section('content')
    <div class="bg-white p-6 rounded-sm shadow-md grow">

        <div class="max-w-xl mx-auto py-4 sm:px-6 lg:px-8">

            <!-- Header & Back Button -->
            <div class="mb-6 border-b pb-4">
                <a href="{{ route('reviews.index') }}"
                    class="inline-flex items-center text-brand-600 hover:text-brand-600 transition mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    Atgal į atsiliepimus
                </a>
                <h1 class="text-3xl font-extrabold text-neutral-800">Palikite atsiliepimą</h1>
                <p class="text-neutral-600 mt-1">Pasidalinkite savo patirtimi.</p>
            </div>

            <!-- Form for Review Submission -->
            <form method="POST" action="{{ route('reviews.store') }}" class="space-y-6">
                @csrf

                <!-- RATING INPUT (Dropdown Select) -->
                <div>
                    <label for="rating" class="block text-lg font-medium text-neutral-700 mb-2">Įvertinimas</label>

                    <select id="rating" name="rating" required
                        class="w-full px-4 py-3 border rounded-lg @error('rating') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500">
                        <option value="" disabled selected>Pasirinkite įvertinimą</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} Žvaigždutė{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>

                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <label for="description" class="block text-lg font-medium text-neutral-700 mb-2">Jūsų
                        atsiliepimas</label>
                    <textarea id="description" name="description" rows="5" required maxlength="500" placeholder="Atsiliepimas čia..."
                        class="w-full px-4 py-3 border rounded-sm @error('description') border-red-500 @else border-neutral-300 @enderror focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="cursor-pointer w-full flex justify-center py-3 px-4 border border-transparent rounded-sm shadow-md text-lg font-bold text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition duration-150 ease-in-out">
                        Palikti atsiliepimą
                    </button>
                </div>
            </form>
        </div>


    </div>
@endsection
