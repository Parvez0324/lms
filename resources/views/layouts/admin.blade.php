@extends('layouts.base')

@section('body')
<div class="h-screen flex overflow-hidden bg-slate-50" 
     x-data="{ 
        sidebarOpen: false, 
        sidebarCollapsed: localStorage.getItem('admin_sidebar_collapsed') === 'true',
        isMounted: false,
        toggleSidebarCollapse() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('admin_sidebar_collapsed', this.sidebarCollapsed);
            $nextTick(() => { if (window.lucide) lucide.createIcons(); });
        }
     }"
     x-init="setTimeout(() => isMounted = true, 50)">
    
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-cloak
         class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden"
         style="display: none;"></div>

    <!-- Sticky Admin Sidebar with Collapsible Width -->
    <aside :class="{ 
                'translate-x-0': sidebarOpen, 
                '-translate-x-full': !sidebarOpen,
                'w-56': !sidebarCollapsed, 
                'w-16': sidebarCollapsed,
                'transition-all duration-300 ease-in-out': isMounted
           }" 
           class="fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-200/90 h-screen flex flex-col flex-shrink-0 w-56 md:static md:translate-x-0">
        
        <!-- Brand & Badge -->
        <div class="h-14 flex items-center border-b border-slate-100 flex-shrink-0 justify-between px-3.5"
             :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-between px-3.5'">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2.5 group min-w-0">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-amber-400 via-rose-400 to-sky-400 flex items-center justify-center shadow-md shadow-amber-400/20 group-hover:scale-105 transition-transform flex-shrink-0">
                    <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
                </div>
                <div x-show="!sidebarCollapsed" x-cloak class="truncate">
                    <span class="text-sm font-bold tracking-tight text-slate-900 block leading-tight">KAN <span class="text-rose-600 font-semibold">Admin</span></span>
                    <span class="block text-[9px] uppercase font-normal text-slate-400 tracking-wider -mt-0.5">Control Panel</span>
                </div>
            </a>
            
            <button @click="sidebarOpen = false" class="md:hidden p-1 text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 px-2.5 py-2.5 overflow-y-auto space-y-0.5">
            
            <div x-show="!sidebarCollapsed" x-cloak class="px-2.5 pt-1.5 pb-0.5 text-[9px] font-bold uppercase tracking-wider text-slate-400">Overview</div>
            <div x-show="sidebarCollapsed" x-cloak class="my-1 border-t border-slate-100"></div>
            
            <a href="{{ route('admin.dashboard') }}" 
               :title="sidebarCollapsed ? 'Dashboard' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-rose-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Dashboard</span>
            </a>

            <a href="{{ route('admin.reports.index') }}" 
               :title="sidebarCollapsed ? 'Analytics & Reports' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="bar-chart-3" class="w-4 h-4 text-rose-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Reports & Analytics</span>
            </a>

            <div x-show="!sidebarCollapsed" x-cloak class="pt-2.5 px-2.5 pb-0.5 text-[9px] font-bold uppercase tracking-wider text-slate-400">Curriculum</div>
            <div x-show="sidebarCollapsed" x-cloak class="my-1 border-t border-slate-100"></div>

            <a href="{{ route('admin.categories.index') }}" 
               :title="sidebarCollapsed ? 'Categories' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="folder-tree" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Categories</span>
            </a>

            <a href="{{ route('admin.courses.index') }}" 
               :title="sidebarCollapsed ? 'All Courses' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.courses.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="book-open-check" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">All Courses</span>
            </a>

            <a href="{{ route('admin.lessons.index') }}" 
               :title="sidebarCollapsed ? 'Lessons & Media' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.lessons.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="video" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Lessons & Media</span>
            </a>

            <a href="{{ route('admin.quizzes.index') }}" 
               :title="sidebarCollapsed ? 'Quizzes & Bank' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.quizzes.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="help-circle" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Quizzes & Bank</span>
            </a>

            <a href="{{ route('admin.assignments.index') }}" 
               :title="sidebarCollapsed ? 'Assignments' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.assignments.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="palette" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Assignments</span>
            </a>

            <div x-show="!sidebarCollapsed" x-cloak class="pt-2.5 px-2.5 pb-0.5 text-[9px] font-bold uppercase tracking-wider text-slate-400">People & Sales</div>
            <div x-show="sidebarCollapsed" x-cloak class="my-1 border-t border-slate-100"></div>

            <a href="{{ route('admin.students.index') }}" 
               :title="sidebarCollapsed ? 'Students' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.students.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="users" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Students</span>
            </a>

            <a href="{{ route('admin.instructors.index') }}" 
               :title="sidebarCollapsed ? 'Instructors' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.instructors.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="sparkles" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Instructors</span>
            </a>

            <a href="{{ route('admin.enrollments.index') }}" 
               :title="sidebarCollapsed ? 'Enrollments' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.enrollments.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="user-check" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Enrollments</span>
            </a>

            <a href="{{ route('admin.payments.index') }}" 
               :title="sidebarCollapsed ? 'Payments & Sales' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.payments.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Payments</span>
            </a>

            <a href="{{ route('admin.certificates.index') }}" 
               :title="sidebarCollapsed ? 'Certificates' : ''"
               class="flex items-center rounded-lg text-xs font-semibold space-x-2.5 px-2.5 py-1.5 transition-all {{ request()->routeIs('admin.certificates.*') ? 'bg-rose-50 text-rose-700 shadow-2xs shadow-rose-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-1.5' : 'space-x-2.5 px-2.5 py-1.5'">
                <i data-lucide="award" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Certificates</span>
            </a>
        </div>

        <!-- Sticky Sidebar Bottom User -->
        <div class="p-2.5 border-t border-slate-100 flex items-center justify-between flex-shrink-0 bg-slate-50/50"
             :class="sidebarCollapsed ? 'flex-col space-y-2' : 'flex-row justify-between'">
            <div class="flex items-center space-x-2 truncate" :title="sidebarCollapsed ? '{{ Auth::user()->name }} (Super Admin)' : ''">
                <img class="w-7 h-7 rounded-lg object-cover ring-1 ring-rose-500/20 flex-shrink-0" src="{{ Auth::user()->avatar_url }}" alt="Admin">
                <div x-show="!sidebarCollapsed" x-cloak class="flex flex-col truncate">
                    <span class="text-xs font-semibold text-slate-900 truncate leading-tight">{{ Auth::user()->name }}</span>
                    <span class="text-[9px] text-rose-600 font-medium uppercase leading-none">Super Admin</span>
                </div>
            </div>
            <button @click="toggleSidebarCollapse()" 
                    class="hidden md:flex p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-200 transition-colors"
                    :title="sidebarCollapsed ? 'Expand Sidebar' : 'Collapse Sidebar'">
                <i :data-lucide="sidebarCollapsed ? 'chevrons-right' : 'chevrons-left'" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    </aside>

    <!-- Main Content Right Area -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Panel Top Header Bar -->
        <header class="h-14 bg-white border-b border-slate-200/90 px-4 sm:px-6 flex items-center justify-between flex-shrink-0 z-10">
            
            <!-- Left: Mobile menu toggle & Breadcrumbs -->
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 focus:outline-none">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="hidden sm:flex items-center space-x-2 text-xs font-semibold text-slate-500">
                    <span class="text-slate-400">Admin</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
                    <span class="text-slate-800 font-bold capitalize">{{ str_replace(['admin.', '.'], ['', ' > '], request()->route()->getName() ?: 'Dashboard') }}</span>
                </div>
            </div>

            <!-- Right: Quick actions & User menu -->
            <div class="flex items-center space-x-3">
                
                <!-- Quick Visit Website Link -->
                <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-600 hover:text-brand-600 hover:bg-slate-100 transition-colors">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    <span>View Site</span>
                </a>

                <!-- Switch to Student View -->
                <a href="{{ route('student.dashboard') }}" class="hidden sm:inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                    <span>Student View</span>
                </a>

                <!-- Dynamic Notifications Dropdown -->
                @include('components.notifications-dropdown')

                <!-- User Dropdown Menu -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-2 p-1.5 rounded-xl hover:bg-slate-100 transition-colors focus:outline-none">
                        <img class="w-8 h-8 rounded-xl object-cover ring-2 ring-rose-500/20" src="{{ Auth::user()->avatar_url }}" alt="">
                        <span class="hidden md:inline-block text-xs font-bold text-slate-800">{{ Auth::user()->name }}</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="transform opacity-0 scale-95" 
                         x-transition:enter-end="transform opacity-100 scale-100" 
                         class="absolute right-0 mt-2 w-56 rounded-2xl bg-white shadow-xl ring-1 ring-black/5 py-1.5 z-50 divide-y divide-slate-100 text-xs"
                         style="display: none;">
                        <div class="px-4 py-2.5">
                            <span class="font-bold text-slate-900 block">{{ Auth::user()->name }}</span>
                            <span class="text-slate-400 text-[10px] block truncate">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-slate-50 font-medium">
                                <i data-lucide="settings" class="w-4 h-4 mr-2.5 text-slate-400"></i>
                                Account Settings
                            </a>
                            <a href="{{ route('instructor.dashboard') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-slate-50 font-medium">
                                <i data-lucide="sparkles" class="w-4 h-4 mr-2.5 text-indigo-500"></i>
                                Instructor Studio
                            </a>
                        </div>
                        <div class="py-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-rose-600 hover:bg-rose-50 font-bold">
                                    <i data-lucide="log-out" class="w-4 h-4 mr-2.5"></i>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </header>

        <!-- Admin View Injected Content -->
        <main class="flex-1 overflow-y-auto px-3.5 py-2.5 sm:px-5 sm:py-3 bg-slate-50">
            @yield('admin_content')
        </main>

    </div>
</div>
@endsection
