@extends('components/layout')

@section('content')

    <div class="flex items-center justify-center bg-white p-6 rounded-md shadow-md grow">

        <div class="w-full max-w-md bg-white p-4 rounded-xl shadow-2xl">

            <h3 class="text-3xl font-semibold text-neutral-800 text-center mb-4">
                Prisijungimas
            </h3>

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-6">
                @csrf

                {{-- === Email Field === --}}
                <div class="my-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Elektroninis paštas</label>
                    <input id="email" name="email" type="email" required autocomplete="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                        placeholder="you@example.com" />
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="my-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Slaptažodis</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                        placeholder="••••••••" />
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-400">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-6">
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-lg font-medium text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        Prisijungti
                    </button>
                </div>

            </form>

        </div>

    </div>

@endsection
