<header class="bg-neutral-0 p-4 rounded-md shadow-md flex items-center justify-between">
    
    <a href="/" class="flex items-center gap-2 text-4xl text-brand-500 cursor-pointer" type="button"> 

        <x-lucide-star class="w-12 h-12"/>

        <h1 class="font-medium tracking-tight">Five Star</h1>

    </a>
    
    <div class="flex items-center gap-4"> 

        @auth
        
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                
                <button class="flex items-center gap-2 rounded-md bg-brand-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-brand-600 focus:shadow-none active:bg-brand-700 hover:bg-brand-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="submit">
                    <x-lucide-log-out class="w-5 h-5"/>
                    Logout
                </button>
            </form>
            
            <button class="text-neutral-700 flex items-center gap-2 cursor-pointer" type="submit">
                
                <x-lucide-circle-user class="w-6 h-6"/>
    
                <span class="text-lg font-semibold ">
                    {{ Auth::user()->fullName }}
                </span>

            </button>

        @endauth

        @guest

            <form method="GET" action="{{ route('login') }}">
            
                <button class="flex items-center gap-2 rounded-md bg-brand-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-brand-600 focus:shadow-none active:bg-brand-700 hover:bg-brand-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="submit">
                    <x-lucide-log-in class="w-5 h-5"/>
                    Login
                </button>

            </form>
        
            <form method="GET" action="{{ route('register') }}">
                
                <button class="flex items-center gap-2 rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="submit">
                    <x-lucide-user-plus class="w-5 h-5"/>
                    Register
                </button>

            </form>

        @endguest

    </div>

</header>