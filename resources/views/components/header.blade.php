<header class="bg-neutral-0 py-2 px-4 rounded-sm shadow-md flex items-center justify-between">

    <div class="flex items-center justify-between gap-4">

        <a href="/" class="flex items-center gap-2 text-4xl text-brand-500 cursor-pointer" type="button">

            <x-lucide-star class="w-12 h-12" />

            <h1 class="font-medium tracking-tight">Five Star</h1>

        </a>

        <hr class="h-10 my-4 bg-neutral-800 border-0">

        <div class="flex items-center justify-between gap-2">

            <form method="GET" action="{{ route('home') }}">

                <button
                    class="cursor-pointer flex items-center gap-2 rounded-sm border border-transparent py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="submit">
                    <x-lucide-house class="w-5 h-5" />
                    Kambariai
                </button>

            </form>

            <a href="{{ route('reviews.index') }}"
                class="cursor-pointer flex items-center gap-2 rounded-sm border border-transparent py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                type="submit">
                <x-lucide-user-star class="w-5 h-5" />
                Atsiliepimai
            </a>

        </div>

    </div>

    <div class="flex items-center gap-4">

        @auth

            @if (Auth::check() && Auth::user()->role->value === 'registeredUser')
                <a href="{{ route('my_bookings.index') }}"
                    class="cursor-pointer flex items-center gap-2 rounded-sm border border-transparent py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="submit">
                    <x-lucide-calendar-days class="w-5 h-5" />
                    Mano rezervacijos
                </a>
            @endif

            @if (Auth::check() && Auth::user()->role->value === 'administrator')
                <a href="{{ route('bookings.index') }}"
                    class="cursor-pointer flex items-center rounded-sm gap-2 border border-transparent py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="submit">
                    <x-lucide-chart-no-axes-combined class="w-5 h-5" />
                    Rezervacijos
                </a>
            @endif

            @if (Auth::check() && Auth::user()->role->value === 'director')
                <a href="{{ route('statistics.index') }}"
                    class="cursor-pointer flex items-center rounded-sm gap-2 border border-transparent py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="submit">
                    <x-lucide-chart-no-axes-combined class="w-5 h-5" />
                    Statistika
                </a>
            @endif


            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    class="cursor-pointer flex items-center gap-2 rounded-sm bg-brand-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-brand-600 focus:shadow-none active:bg-brand-700 hover:bg-brand-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="submit">
                    <x-lucide-log-out class="w-5 h-5" />
                    Atsijungti
                </button>
            </form>

            <button class="text-neutral-700 flex items-center gap-2" type="submit">

                <x-lucide-circle-user class="w-6 h-6" />

                <span class="text-md">
                    {{ Auth::user()->fullName }}
                </span>

            </button>

            <div x-data="{ open: false }" class="relative">

                <button @click="open = !open"
                    class="cursor-pointer flex items-center gap-2 rounded-sm border border-transparent p-2 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">

                    <x-lucide-mail class="w-5 h-5" />

                    @php
                        $unreadNotifications = Auth::user()->notifications->where('acknowledged', false);
                    @endphp

                    @if ($unreadNotifications->count() > 0)
                        <span>
                            {{ $unreadNotifications->count() }}
                        </span>
                    @else
                        <span class="text-xs">0</span>
                    @endif
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95" @click.outside="open = false" style="display: none;"
                    class="absolute right-0 z-50 mt-2 w-80 origin-top-right rounded-sm bg-white py-1 shadow-md focus:outline-none">
                    <div class="px-4 py-2 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700">Pranešimai</h3>
                    </div>

                    <div class="max-h-64 overflow-y-auto">
                        @forelse($unreadNotifications as $notification)
                            <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div @class([
                                        'mt-1 w-2 h-2 rounded-full shrink-0',
                                        'bg-blue-500' =>
                                            $notification->notification_type === \App\Enums\NotificationType::INFO,
                                        'bg-red-500' =>
                                            $notification->notification_type ===
                                            \App\Enums\NotificationType::IMPORTANT,
                                    ])></div>

                                    <div>
                                        <p class="text-sm text-gray-600">
                                            {{ $notification->message }}
                                        </p>
                                        <span class="text-xs text-gray-400">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-6 text-center text-sm text-gray-500">
                                Nėra naujų pranešimų.
                            </div>
                        @endforelse
                    </div>

                    @if ($unreadNotifications->count() > 0)
                        <div class="p-2 border-t border-gray-100 bg-gray-50 text-center">
                            <form method="POST" action="{{ route('notification.markAll') }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-medium text-brand-600 hover:text-brand-800">
                                    Pažymėti visus kaip perskaitytus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

        @endauth

        @guest

            <form method="GET" action="{{ route('login') }}">

                <button
                    class="cursor-pointer flex items-center gap-2 rounded-sm bg-brand-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-brand-600 focus:shadow-none active:bg-brand-700 hover:bg-brand-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2"
                    type="submit">
                    <x-lucide-log-in class="w-5 h-5" />
                    Prisijungti
                </button>

            </form>

            <form method="GET" action="{{ route('register') }}">

                <button
                    class="cursor-pointer flex items-center gap-2 rounded-sm border border-transparent py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="submit">
                    <x-lucide-user-plus class="w-5 h-5" />
                    Registruotis
                </button>

            </form>

        @endguest

    </div>

</header>
