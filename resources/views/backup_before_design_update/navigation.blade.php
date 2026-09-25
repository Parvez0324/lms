<nav class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 transition-all" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-18 py-3 items-center">
            
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-amber-400 via-rose-400 to-sky-400 flex items-center justify-center shadow-lg shadow-amber-400/25 group-hover:scale-105 transition-transform duration-200">
                        <i data-lucide="sparkles" class="w-5 h-5 text-white"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-black tracking-tight text-slate-900">
                            KAN
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('courses.index') }}" 
                       class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('courses.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <span class="flex items-center space-x-1.5">
                            <i data-lucide="compass" class="w-4 h-4 text-indigo-600"></i>
                            <span>Explore Courses</span>
                        </span>
                    </a>

                    <a href="{{ route('certificate.verify') }}" 
                       class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('certificate.verify') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <span class="flex items-center space-x-1.5">
                            <i data-lucide="award" class="w-4 h-4 text-indigo-600"></i>
                            <span>Verify Certificate</span>
                        </span>
                    </a>
                </div>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="hidden lg:block flex-1 max-w-xs mx-8">
                <form action="{{ route('courses.index') }}" method="GET" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="search" class="h-4 w-4 text-slate-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses, skills, topics..." 
                           class="w-full pl-10 pr-4 py-2 text-sm bg-slate-100/80 border-0 rounded-2xl text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition-all">
                </form>
            </div>

            <!-- Right Actions / User Menu -->
            <div class="flex items-center space-x-3">
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-bold text-slate-700 hover:text-brand-600 rounded-xl hover:bg-slate-100 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 rounded-xl shadow-md shadow-brand-500/20 hover:shadow-lg hover:shadow-brand-500/30 transition-all">
                        Get Started
                    </a>
                @else
                    <!-- My Learning Quick Link -->
                    <a href="{{ route('student.my-courses') }}" 
                       class="hidden sm:inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl text-sm font-bold text-slate-700 hover:text-brand-600 hover:bg-brand-50 transition-colors">
                        <i data-lucide="book-open" class="w-4 h-4 text-brand-600"></i>
                        <span>My Learning</span>
                    </a>

                    <!-- Role Badge / Dashboard Quick Button -->
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold rounded-xl hover:bg-rose-100 transition-colors">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                            <span>Admin Panel</span>
                        </a>
                    @elseif(Auth::user()->isInstructor())
                        <a href="{{ route('instructor.dashboard') }}" class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-bold rounded-xl hover:bg-indigo-100 transition-colors">
                            <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                            <span>Instructor Studio</span>
                        </a>
                    @endif

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" type="button" class="flex items-center space-x-2 p-1.5 rounded-2xl hover:bg-slate-100 transition-colors focus:outline-none">
                            <img class="h-9 w-9 rounded-xl object-cover ring-2 ring-brand-500/30" 
                                 src="{{ Auth::user()->avatar_url }}" 
                                 alt="{{ Auth::user()->name }}">
                            <div class="hidden xl:flex flex-col text-left">
                                <span class="text-xs font-bold text-slate-800 leading-tight">{{ Str::limit(Auth::user()->name, 14) }}</span>
                                <span class="text-[10px] font-semibold text-brand-600 capitalize">{{ Auth::user()->role }}</span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95" 
                             class="absolute right-0 mt-2 w-64 rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 py-2 z-50 divide-y divide-slate-100"
                             style="display: none;">
                            
                            <div class="px-4 py-3">
                                <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs font-medium text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider rounded-md {{ Auth::user()->isAdmin() ? 'bg-rose-100 text-rose-700' : (Auth::user()->isInstructor() ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700') }}">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>

                            <!-- Portal Links -->
                            <div class="py-1.5">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 font-medium">
                                        <i data-lucide="layout-dashboard" class="w-4 h-4 mr-3 text-rose-500"></i>
                                        Admin Dashboard
                                    </a>
                                @endif

                                @if(Auth::user()->isInstructor())
                                    <a href="{{ route('instructor.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 font-medium">
                                        <i data-lucide="video" class="w-4 h-4 mr-3 text-indigo-500"></i>
                                        Instructor Studio
                                    </a>
                                    <a href="{{ route('instructor.courses.create') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 font-medium">
                                        <i data-lucide="plus-circle" class="w-4 h-4 mr-3 text-emerald-500"></i>
                                        Create New Course
                                    </a>
                                @endif

                                <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 font-medium">
                                    <i data-lucide="user-check" class="w-4 h-4 mr-3 text-emerald-500"></i>
                                    Student Dashboard
                                </a>
                                <a href="{{ route('student.my-courses') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 font-medium">
                                    <i data-lucide="book-marked" class="w-4 h-4 mr-3 text-brand-500"></i>
                                    My Enrolled Courses
                                </a>
                                <a href="{{ route('student.payments') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 font-medium">
                                    <i data-lucide="receipt" class="w-4 h-4 mr-3 text-slate-400"></i>
                                    Order History
                                </a>
                            </div>

                            <!-- Account & Logout -->
                            <div class="py-1.5">
                                <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 font-medium">
                                    <i data-lucide="settings" class="w-4 h-4 mr-3 text-slate-400"></i>
                                    Account Settings
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 font-semibold">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-3 text-rose-500"></i>
                                        Sign Out
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endguest

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile menu modal/accordion -->
    <div x-show="mobileMenuOpen" class="md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-3" style="display: none;">
        <form action="{{ route('courses.index') }}" method="GET" class="relative mb-3">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i data-lucide="search" class="h-4 w-4 text-slate-400"></i>
            </div>
            <input type="text" name="search" placeholder="Search courses..." 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-100 border-0 rounded-xl text-slate-900 focus:ring-2 focus:ring-brand-500">
        </form>

        <a href="{{ route('courses.index') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-100">
            Explore Courses
        </a>
        <a href="{{ route('certificate.verify') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-100">
            Verify Certificate
        </a>

        @auth
            <a href="{{ route('student.my-courses') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-brand-600 hover:bg-brand-50">
                My Enrolled Courses
            </a>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-rose-600 hover:bg-rose-50">
                    Admin Dashboard
                </a>
            @endif
            @if(Auth::user()->isInstructor())
                <a href="{{ route('instructor.dashboard') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-indigo-600 hover:bg-indigo-50">
                    Instructor Studio
                </a>
            @endif
            <a href="{{ route('profile') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-100">
                My Profile
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-xl text-base font-semibold text-rose-600 hover:bg-rose-50">
                    Sign Out
                </button>
            </form>
        @else
            <div class="pt-4 flex flex-col space-y-2">
                <a href="{{ route('login') }}" class="w-full py-2.5 text-center font-bold text-slate-700 bg-slate-100 rounded-xl">Sign In</a>
                <a href="{{ route('register') }}" class="w-full py-2.5 text-center font-bold text-white bg-brand-600 rounded-xl">Get Started</a>
            </div>
        @endauth
    </div>
</nav>
