<header class="bg-neutral-0 p-4 rounded-md shadow-md flex items-center justify-between">
    
    <div class="flex items-center gap-2 text-4xl text-brand-500"> 

        <x-lucide-star class="w-12 h-12"/>

        <h1 class="font-medium tracking-tight">Five Star</h1>

    </div>
    
    <div class="flex items-center gap-2"> 

        <button class="flex items-center gap-2 rounded-md bg-brand-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-brand-600 focus:shadow-none active:bg-brand-700 hover:bg-brand-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="button">
            <x-lucide-log-in class="w-5 h-5"/>
            Login
        </button>
    
        <button class="flex items-center gap-2 rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all shadow-sm hover:shadow-lg text-neutral-600 hover:text-white hover:bg-brand-600 focus:text-white focus:bg-brand-600 active:border-brand-500 active:text-white active:bg-brand-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
            <x-lucide-user-plus class="w-5 h-5"/>
            Register
        </button>

    </div>

</header>