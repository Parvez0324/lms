<nav class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 transition-all font-sans" 
     x-data="{ 
        mobileMenuOpen: false,
        userMenuOpen: false
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-15 py-2 items-center">
            
            <!-- Left: Logo & Core Navigation Links -->
            <div class="flex items-center space-x-6 sm:space-x-8 rtl:space-x-reverse">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 rtl:space-x-reverse group flex-shrink-0">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-sky-500 to-blue-600 flex items-center justify-center shadow-md shadow-sky-500/25 group-hover:scale-105 transition-transform">
                        <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-lg font-black tracking-tight text-slate-900">KAN</span>
                        <span class="text-[10px] font-black px-1.5 py-0.5 rounded bg-blue-50 text-blue-700 border border-blue-200">LMS</span>
                    </div>
                </a>

                <!-- Desktop Primary Links -->
                <div class="hidden md:flex items-center space-x-1 rtl:space-x-reverse">
                    <a href="{{ route('courses.index') }}" 
                       class="px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors {{ request()->routeIs('courses.*') ? 'text-blue-700 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <span>{{ __('messages.explore_courses') }}</span>
                    </a>

                    <a href="{{ route('certificate.verify') }}" 
                       class="px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors {{ request()->routeIs('certificate.verify') ? 'text-blue-700 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <span>{{ __('messages.verify_certificate') }}</span>
                    </a>
                </div>
            </div>

            <!-- Right: Search, Language, and Profile -->
            <div class="flex items-center space-x-2 sm:space-x-3 rtl:space-x-reverse">
                
                <!-- Sleek Expandable Search Bar -->
                <div class="hidden lg:block relative">
                    <form action="{{ route('courses.index') }}" method="GET" class="relative group">
                        <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600">
                            <i data-lucide="search" class="w-3.5 h-3.5"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="{{ __('messages.search_placeholder') }}" 
                                class="w-40 xl:w-52 focus:w-64 ps-8 pe-3 py-1.5 text-xs bg-slate-100/90 border border-transparent rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-300 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300">
                    </form>
                </div>

                <!-- Language Switcher Pill -->
                <div class="flex items-center bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-[11px] font-bold">
                    <a href="{{ route('locale.switch', 'en') }}" 
                       class="px-2 py-0.5 rounded-md transition-all {{ app()->getLocale() === 'en' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        EN
                    </a>
                    <a href="{{ route('locale.switch', 'ar') }}" 
                       class="px-2 py-0.5 rounded-md transition-all {{ app()->getLocale() === 'ar' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        عربي
                    </a>
                </div>

                @guest
                    <a href="{{ route('login') }}" class="px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-blue-600 rounded-xl hover:bg-slate-100 transition-colors">
                        {{ __('messages.sign_in') }}
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-3.5 py-1.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm shadow-blue-500/20 transition-all">
                        {{ __('messages.get_started') }}
                    </a>
                @else

                    <!-- User Profile Dropdown (Consolidated clean avatar) -->
                    <div class="relative" @click.away="userMenuOpen = false">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                type="button" 
                                class="flex items-center space-x-1.5 rtl:space-x-reverse p-1 rounded-xl hover:bg-slate-100 transition-colors focus:outline-none">
                            <img class="h-7 w-7 rounded-lg object-cover ring-1 ring-blue-500/30" 
                                 src="{{ Auth::user()->avatar_url }}" 
                                 alt="{{ Auth::user()->name }}">
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="userMenuOpen" 
                             x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95" 
                             class="absolute end-0 mt-2 w-60 rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 py-1.5 z-50 divide-y divide-slate-100 text-start"
                             style="display: none;">
                            
                            <!-- User Header -->
                            <div class="px-3.5 py-2.5">
                                <p class="text-xs font-black text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                                <div class="mt-1.5">
                                    <span class="inline-block px-2 py-0.5 text-[9px] font-black uppercase tracking-wider rounded-md {{ Auth::user()->isAdmin() ? 'bg-rose-100 text-rose-700' : (Auth::user()->isInstructor() ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700') }}">
                                        {{ Auth::user()->role }}
                                    </span>
                                </div>
                            </div>

                            <!-- Primary Workspace Shortcuts -->
                            <div class="py-1">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3.5 py-1.5 text-xs text-slate-700 hover:bg-slate-50 hover:text-blue-600 font-bold">
                                        <i data-lucide="shield-check" class="w-3.5 h-3.5 me-2.5 text-rose-500"></i>
                                        {{ __('messages.admin_panel') }}
                                    </a>
                                @endif

                                @if(Auth::user()->isInstructor())
                                    <a href="{{ route('instructor.dashboard') }}" class="flex items-center px-3.5 py-1.5 text-xs text-slate-700 hover:bg-slate-50 hover:text-blue-600 font-bold">
                                        <i data-lucide="presentation" class="w-3.5 h-3.5 me-2.5 text-indigo-500"></i>
                                        {{ __('messages.instructor_studio') }}
                                    </a>
                                @endif

                                <a href="{{ route('student.my-courses') }}" class="flex items-center px-3.5 py-1.5 text-xs text-slate-700 hover:bg-slate-50 hover:text-blue-600 font-medium">
                                    <i data-lucide="book-marked" class="w-3.5 h-3.5 me-2.5 text-blue-500"></i>
                                    {{ __('messages.my_learning') }}
                                </a>

                                <a href="{{ route('student.dashboard') }}" class="flex items-center px-3.5 py-1.5 text-xs text-slate-700 hover:bg-slate-50 hover:text-blue-600 font-medium">
                                    <i data-lucide="user-check" class="w-3.5 h-3.5 me-2.5 text-emerald-500"></i>
                                    {{ __('messages.student_dashboard') }}
                                </a>
                            </div>

                            <!-- Account & Signout -->
                            <div class="py-1">
                                <a href="{{ route('profile') }}" class="flex items-center px-3.5 py-1.5 text-xs text-slate-700 hover:bg-slate-50 font-medium">
                                    <i data-lucide="settings" class="w-3.5 h-3.5 me-2.5 text-slate-400"></i>
                                    {{ __('messages.account_settings') }}
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-3.5 py-1.5 text-xs text-rose-600 hover:bg-rose-50 font-bold text-start">
                                        <i data-lucide="log-out" class="w-3.5 h-3.5 me-2.5 text-rose-500"></i>
                                        {{ __('messages.sign_out') }}
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endguest

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden p-1.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu Accordion -->
    <div x-show="mobileMenuOpen" class="md:hidden border-t border-slate-200 bg-white px-4 pt-2.5 pb-5 space-y-2 text-start" style="display: none;">
        <form action="{{ route('courses.index') }}" method="GET" class="relative mb-2">
            <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="h-3.5 w-3.5 text-slate-400"></i>
            </div>
            <input type="text" name="search" placeholder="{{ __('messages.search_placeholder') }}" 
                   class="w-full ps-9 pe-3 py-1.5 text-xs bg-slate-100 border-0 rounded-xl text-slate-900 focus:ring-2 focus:ring-blue-600">
        </form>

        <a href="{{ route('courses.index') }}" class="block px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-100">
            {{ __('messages.explore_courses') }}
        </a>
        <a href="{{ route('certificate.verify') }}" class="block px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-100">
            {{ __('messages.verify_certificate') }}
        </a>

        @auth
            <a href="{{ route('student.my-courses') }}" class="block px-3 py-1.5 rounded-xl text-xs font-semibold text-blue-600 hover:bg-blue-50">
                {{ __('messages.my_learning') }}
            </a>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-1.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50">
                    {{ __('messages.admin_panel') }}
                </a>
            @endif
            @if(Auth::user()->isInstructor())
                <a href="{{ route('instructor.dashboard') }}" class="block px-3 py-1.5 rounded-xl text-xs font-semibold text-indigo-600 hover:bg-indigo-50">
                    {{ __('messages.instructor_studio') }}
                </a>
            @endif
            <a href="{{ route('profile') }}" class="block px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-100">
                {{ __('messages.account_settings') }}
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-start px-3 py-1.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50">
                    {{ __('messages.sign_out') }}
                </button>
            </form>
        @else
            <div class="pt-2 flex flex-col space-y-1.5">
                <a href="{{ route('login') }}" class="w-full py-2 text-center text-xs font-bold text-slate-700 bg-slate-100 rounded-xl">{{ __('messages.sign_in') }}</a>
                <a href="{{ route('register') }}" class="w-full py-2 text-center text-xs font-bold text-white bg-blue-600 rounded-xl">{{ __('messages.get_started') }}</a>
            </div>
        @endauth
    </div>
</nav>
