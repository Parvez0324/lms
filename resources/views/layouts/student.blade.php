@extends('layouts.base')

@section('body')
<div class="h-screen flex overflow-hidden bg-slate-50" 
     x-data="{ 
        sidebarOpen: false, 
        sidebarCollapsed: localStorage.getItem('student_sidebar_collapsed') === 'true',
        toggleSidebarCollapse() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('student_sidebar_collapsed', this.sidebarCollapsed);
            $nextTick(() => { if (window.lucide) lucide.createIcons(); });
        }
     }">
    
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden"
         style="display: none;"></div>

    <!-- Sticky Student Sidebar -->
    <aside :class="{ 
                'translate-x-0': sidebarOpen, 
                '-translate-x-full': !sidebarOpen,
                'w-56': !sidebarCollapsed, 
                'w-16': sidebarCollapsed 
           }" 
           class="fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-200/90 h-screen flex flex-col flex-shrink-0 transition-all duration-300 ease-in-out md:static md:translate-x-0">
        
        <!-- Brand & Badge -->
        <div class="h-14 flex items-center border-b border-slate-100 flex-shrink-0 transition-all"
             :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-between px-3.5'">
            <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-2.5 group min-w-0">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-amber-400 via-rose-400 to-sky-400 flex items-center justify-center shadow-md shadow-amber-400/20 group-hover:scale-105 transition-transform flex-shrink-0">
                    <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
                </div>
                <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">
                    <span class="text-sm font-bold tracking-tight text-slate-900 block leading-tight">KAN <span class="text-emerald-600 font-semibold">Student</span></span>
                    <span class="block text-[9px] uppercase font-normal text-slate-400 tracking-wider -mt-0.5">Student Portal</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="md:hidden p-1 text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 px-2 py-2 overflow-y-auto space-y-0.5">
            <div x-show="!sidebarCollapsed" class="px-2.5 pt-1.5 pb-0.5 text-[9px] font-bold uppercase tracking-wider text-slate-400">Learning</div>
            <div x-show="sidebarCollapsed" class="my-1 border-t border-slate-100"></div>

            <a href="{{ route('student.dashboard') }}" 
               :title="sidebarCollapsed ? 'Dashboard' : ''"
               class="flex items-center rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('student.dashboard') ? 'bg-amber-50 text-amber-800 shadow-2xs shadow-amber-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-amber-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="truncate">Dashboard</span>
            </a>

            <a href="{{ route('student.my-courses') }}" 
               :title="sidebarCollapsed ? 'My Courses' : ''"
               class="flex items-center rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('student.my-courses') ? 'bg-amber-50 text-amber-800 shadow-2xs shadow-amber-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="play-circle" class="w-4 h-4 text-rose-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="truncate">My Courses</span>
            </a>

            <a href="{{ route('student.assignments.index') }}" 
               :title="sidebarCollapsed ? 'My Assignments' : ''"
               class="flex items-center rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('student.assignments.*') ? 'bg-amber-50 text-amber-800 shadow-2xs shadow-amber-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="palette" class="w-4 h-4 text-purple-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="truncate">Assignments</span>
            </a>

            <a href="{{ route('student.payments') }}" 
               :title="sidebarCollapsed ? 'Order History' : ''"
               class="flex items-center rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('student.payments') ? 'bg-amber-50 text-amber-800 shadow-2xs shadow-amber-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="receipt" class="w-4 h-4 text-sky-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="truncate">Order History</span>
            </a>

            <div x-show="!sidebarCollapsed" class="pt-2.5 px-2.5 pb-0.5 text-[9px] font-bold uppercase tracking-wider text-slate-400">Explore</div>
            <div x-show="sidebarCollapsed" class="my-1 border-t border-slate-100"></div>

            <a href="{{ route('courses.index') }}" 
               :title="sidebarCollapsed ? 'Explore Courses' : ''"
               class="flex items-center rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="compass" class="w-4 h-4 text-amber-400 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="truncate">Browse Catalog</span>
            </a>

            <a href="{{ route('certificate.verify') }}" 
               :title="sidebarCollapsed ? 'Verify Certificate' : ''"
               class="flex items-center rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="award" class="w-4 h-4 text-yellow-400 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="truncate">Verify Certificate</span>
            </a>
        </div>

        <!-- Sticky Sidebar Bottom User -->
        <div class="p-2.5 border-t border-slate-100 flex items-center justify-between flex-shrink-0 bg-slate-50/50"
             :class="sidebarCollapsed ? 'flex-col space-y-2' : ''">
            <div class="flex items-center space-x-2 truncate" :title="sidebarCollapsed ? '{{ Auth::user()->name }} (Active Learner)' : ''">
                <img class="w-7 h-7 rounded-lg object-cover ring-2 ring-emerald-500/20 flex-shrink-0" src="{{ Auth::user()->avatar_url }}" alt="Student">
                <div x-show="!sidebarCollapsed" class="flex flex-col truncate">
                    <span class="text-xs font-semibold text-slate-900 truncate leading-tight">{{ Auth::user()->name }}</span>
                    <span class="text-[9px] text-emerald-600 font-medium uppercase leading-none">Active Learner</span>
                </div>
            </div>
            <button @click="toggleSidebarCollapse()" 
                    class="hidden md:flex p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-200 transition-colors"
                    :title="sidebarCollapsed ? 'Expand Sidebar' : 'Collapse Sidebar'">
                <i :data-lucide="sidebarCollapsed ? 'chevrons-right' : 'chevrons-left'" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Header Bar -->
        <header class="h-14 bg-white border-b border-slate-200/90 px-4 sm:px-6 flex items-center justify-between flex-shrink-0 z-10">
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="hidden sm:flex items-center space-x-2 text-xs font-semibold text-slate-500">
                    <span class="text-slate-400">Student Portal</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
                    <span class="text-slate-800 font-bold capitalize">{{ str_replace(['student.', '.'], ['', ' > '], request()->route()->getName() ?: 'Dashboard') }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('courses.index') }}" class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                    <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                    <span>Find Courses</span>
                </a>

                <!-- Dynamic Notifications Dropdown -->
                @include('components.notifications-dropdown')

                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-2 p-1.5 rounded-xl hover:bg-slate-100 focus:outline-none">
                        <img class="w-8 h-8 rounded-xl object-cover ring-2 ring-emerald-500/20" src="{{ Auth::user()->avatar_url }}" alt="">
                        <span class="hidden md:inline-block text-xs font-bold text-slate-800">{{ Auth::user()->name }}</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                    </button>

                    <div x-show="open" class="absolute right-0 mt-2 w-56 rounded-2xl bg-white shadow-xl ring-1 ring-black/5 py-1.5 z-50 divide-y divide-slate-100 text-xs" style="display: none;">
                        <div class="px-4 py-2">
                            <span class="font-bold text-slate-900 block">{{ Auth::user()->name }}</span>
                            <span class="text-slate-400 text-[10px] block truncate">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-slate-50 font-medium">
                                <i data-lucide="settings" class="w-4 h-4 mr-2 text-slate-400"></i> Account Settings
                            </a>
                            <a href="{{ route('student.my-courses') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-slate-50 font-medium">
                                <i data-lucide="book-marked" class="w-4 h-4 mr-2 text-emerald-500"></i> My Enrolled Courses
                            </a>
                        </div>
                        <div class="py-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-rose-600 hover:bg-rose-50 font-bold">
                                    <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Student Content -->
        <main class="flex-1 overflow-y-auto px-3.5 py-2.5 sm:px-5 sm:py-3 bg-slate-50">
            @yield('student_content')
        </main>

    </div>
</div>
@endsection
