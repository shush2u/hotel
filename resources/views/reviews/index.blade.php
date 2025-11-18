@extends('components/layout')

@section('content')
    <div class="bg-white p-6 rounded-sm shadow-md grow">

        <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

            <div class="flex justify-between border-b pb-4 mb-4">

                <h1 class="text-4xl font-extrabold text-neutral-800">
                    Atsiliepimai
                </h1>

                @if (Auth::check() && Auth::user()->role->value === 'registeredUser')
                    <a href="{{ route('reviews.create') }}"
                        class="h-10 cursor-pointer flex items-center gap-2 rounded-sm bg-brand-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-brand-600 focus:shadow-none active:bg-brand-700 hover:bg-brand-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2"
                        type="submit">
                        <x-lucide-log-in class="w-5 h-5" />
                        Palikti atsiliepimą
                    </a>
                @endif

            </div>


            @if ($reviews->isEmpty())
                <div class="text-center p-12 bg-neutral-100 rounded-lg border border-neutral-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-neutral-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5" />
                    </svg>
                    <h3 class="mt-2 text-xl font-medium text-neutral-900">No Reviews Yet</h3>
                    <p class="mt-1 text-sm text-neutral-600">
                        Be the first to leave a review!
                    </p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($reviews as $review)
                        <div
                            class="bg-white p-6 rounded-xl shadow-lg border border-neutral-100 transition duration-300 hover:shadow-xl">

                            <!-- Rating Stars -->
                            <div class="flex items-center mb-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 mr-0.5 
                            @if ($i <= $review->rating) text-yellow-500 fill-current 
                            @else 
                                text-neutral-300 fill-current @endif"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path
                                            d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.92-7.416 3.92 1.48-8.279-6.064-5.828 8.332-1.151z" />
                                    </svg>
                                @endfor
                                <span class="ml-3 text-lg font-semibold text-neutral-700">({{ $review->rating }}/5)</span>
                            </div>

                            <!-- Review Description -->
                            <p class="text-neutral-700 leading-relaxed italic mb-4">
                                "{{ $review->description }}"
                            </p>

                            <!-- User and Date Info -->
                            <div class="pt-3 border-t border-neutral-100">
                                <p class="text-sm font-medium text-blue-600">
                                    — {{ $review->user->fullName ?? 'Anonymous User' }}
                                </p>
                                <p class="text-xs text-neutral-500 mt-1">
                                    {{ $review->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif


        </div>

    </div>
@endsection
