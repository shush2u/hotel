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
                <form method="GET" action="{{ route('myBookings') }}">

                    <button
                        class="cursor-pointer flex items-center gap-2 rounded-sm border border-transparent py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="submit">
                        <x-lucide-calendar-days class="w-5 h-5" />
                        Mano rezervacijos
                    </button>

                </form>
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

            <button class="text-neutral-700 flex items-center gap-2 cursor-pointer" type="submit">

                <x-lucide-circle-user class="w-6 h-6" />

                <span class="text-md">
                    {{ Auth::user()->fullName }}
                </span>

            </button>

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
