<header id="main-navbar" class="py-3 px-6 lg:px-10 bg-gradient-to-r from-red-900 via-red-800 to-red-950 shadow-2xl sticky top-0 z-50 rounded-b-[2rem]">
    <div class="flex justify-between items-center w-full max-w-7xl mx-auto">

        {{-- Page Title --}}
        <div class="flex items-center space-x-3">
            <div class="h-8 w-1 bg-red-400 rounded-full hidden md:block"></div>
            <h1 class="text-xl md:text-2xl font-extrabold text-white tracking-tight uppercase">
                @yield('page-title', 'Dashboard')
            </h1>
        </div>

        <div class="flex items-center space-x-3 md:space-x-6">
            {{-- User Profile Card --}}
            <div class="hidden sm:flex items-center p-1.5 pr-5 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-lg transition-all hover:bg-white/15">
                <div class="w-9 h-9 bg-gradient-to-tr from-white to-red-100 text-red-800 flex items-center justify-center rounded-xl text-lg font-bold shadow-md mr-3">
                    <i class="fa-solid fa-user-shield"></i>
                </div>

                <div class="flex flex-col">
                    <span class="font-bold text-white text-xs leading-none uppercase tracking-wide">E-Commerce BJL</span>
                    <span class="text-red-300 text-[10px] font-medium mt-1 flex items-center">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse mr-1.5"></span>
                        Administrator
                    </span>
                </div>
            </div>

            {{-- Logout Button --}}
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf 
                <button type="submit" 
                    class="group flex items-center justify-center w-10 h-10 md:w-auto md:px-5 md:py-2.5 bg-white text-red-900 rounded-xl text-sm font-bold shadow-lg hover:bg-red-50 hover:scale-105 active:scale-95 transition-all duration-200 border border-transparent hover:border-red-200">
                    <i class="fa-solid fa-right-from-bracket md:mr-2 group-hover:translate-x-1 transition-transform"></i>
                    <span class="hidden md:inline">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>