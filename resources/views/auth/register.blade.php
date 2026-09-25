@extends('layouts.base')

@section('title', __('messages.create_account') . ' - KAN LMS')

@section('body')
<div class="h-screen w-full flex flex-col lg:flex-row overflow-hidden bg-slate-950 font-sans" 
     x-data="{ 
         selectedRole: '{{ old('role', request('role', 'student')) }}',
         showPassword: false
     }">

    <!-- Left Hero Showcase (Enterprise LMS) -->
    <div class="relative flex-1 lg:w-1/2 xl:w-7/12 bg-slate-950 text-white flex flex-col p-4 sm:p-6 lg:p-7 overflow-hidden">
        
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1800&q=80" 
                 class="w-full h-full object-cover object-center opacity-25 filter brightness-75 contrast-125" 
                 alt="Collaboration & Education">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#040d1a] via-[#081b33]/95 to-[#0b2447]/90 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-radial-at-t from-sky-500/10 via-transparent to-transparent"></div>
        </div>

        <!-- Top Navigation / Logo -->
        <div class="relative z-10 flex items-center justify-between flex-shrink-0">
            <a href="{{ route('home') }}" class="flex items-center space-x-2.5 rtl:space-x-reverse group">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-sky-500 to-blue-600 flex items-center justify-center shadow-md shadow-sky-500/30 ring-1 ring-white/20 group-hover:scale-105 transition-transform">
                    <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
                </div>
                <div>
                    <div class="text-base font-black tracking-tight text-white flex items-center gap-1.5 leading-none">
                        <span>KAN</span>
                        <span class="text-sky-400 font-extrabold text-[11px] px-1 py-0.5 rounded bg-sky-500/20 border border-sky-400/30">LMS</span>
                    </div>
                    <p class="text-[10px] text-slate-300 font-medium tracking-wide mt-0.5">{{ __('messages.tagline') }}</p>
                </div>
            </a>

            <div class="hidden md:flex items-center space-x-3.5 rtl:space-x-reverse text-[11px] font-semibold text-slate-300">
                <a href="{{ route('courses.index') }}" class="hover:text-sky-400 transition-colors">{{ __('messages.explore_courses') }}</a>
                <span class="text-slate-600">•</span>
                <a href="{{ route('certificate.verify') }}" class="hover:text-sky-400 transition-colors">{{ __('messages.verify_certificate') }}</a>
            </div>
        </div>

        <!-- Middle Value Highlights -->
        <div class="relative z-10 flex-1 flex flex-col justify-start pt-4 sm:pt-5 lg:pt-6 space-y-3.5 max-w-lg">
            <div class="inline-flex items-center space-x-2 rtl:space-x-reverse px-2.5 py-1 rounded-full bg-sky-500/10 border border-sky-400/30 text-sky-300 text-[10px] font-extrabold tracking-widest uppercase self-start">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                <span>{{ __('messages.lms_badge') }}</span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white leading-tight">
                {{ __('messages.hero_title_left') }}
                <span class="bg-gradient-to-r from-sky-400 via-blue-300 to-indigo-300 bg-clip-text text-transparent">
                    {{ __('messages.hero_title_accent') }}
                </span>
            </h1>

            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-md">
                {{ __('messages.hero_desc_left') }}
            </p>

            <div class="grid grid-cols-2 gap-2.5 pt-1">
                <div class="p-3 rounded-xl bg-white/[0.04] border border-white/10 backdrop-blur-sm">
                    <div class="w-7 h-7 rounded-lg bg-sky-500/20 text-sky-400 flex items-center justify-center mb-1.5">
                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white mb-0.5">{{ __('messages.role_student') }}</h4>
                    <p class="text-[10px] text-slate-400">{{ __('messages.student_role_desc') }}</p>
                </div>
                <div class="p-3 rounded-xl bg-white/[0.04] border border-white/10 backdrop-blur-sm">
                    <div class="w-7 h-7 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center mb-1.5">
                        <i data-lucide="presentation" class="w-3.5 h-3.5"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white mb-0.5">{{ __('messages.role_instructor') }}</h4>
                    <p class="text-[10px] text-slate-400">{{ __('messages.instructor_role_desc') }}</p>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="flex items-center space-x-5 rtl:space-x-reverse pt-2 border-t border-white/10 text-xs text-slate-300">
                <div>
                    <span class="font-extrabold text-white text-base">{{ __('messages.stat_students') }}</span>
                    <span class="text-slate-400 ms-1 text-[10px]">{{ __('messages.stat_students_label') }}</span>
                </div>
                <div>
                    <span class="font-extrabold text-sky-400 text-base">{{ __('messages.stat_courses') }}</span>
                    <span class="text-slate-400 ms-1 text-[10px]">{{ __('messages.stat_courses_label') }}</span>
                </div>
                <div>
                    <span class="font-extrabold text-emerald-400 text-base">{{ __('messages.stat_uptime') }}</span>
                    <span class="text-slate-400 ms-1 text-[10px]">{{ __('messages.stat_uptime_label') }}</span>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="relative z-10 mt-auto pt-2.5 border-t border-white/10 flex items-center justify-between text-[10px] text-slate-400 flex-shrink-0">
            <span class="uppercase tracking-widest text-[9px] text-slate-300">{{ __('messages.global_reach') }}</span>
            <span class="font-bold text-sky-300 text-[9px]">{{ __('messages.countries') }}</span>
        </div>

    </div>

    <!-- Right Side: Elevated Auth Card on Slate Canvas -->
    <div class="flex-shrink-0 w-full lg:w-1/2 xl:w-5/12 bg-slate-50 text-slate-900 flex flex-col justify-between p-3.5 sm:p-4 lg:py-4 lg:px-6 shadow-2xl border-l border-slate-200/90 z-20 h-full overflow-y-auto lg:overflow-hidden">
        
        <!-- Top Language Switcher -->
        <div class="flex justify-between items-center w-full max-w-sm mx-auto flex-shrink-0">
            <a href="{{ route('home') }}" class="lg:hidden flex items-center space-x-1.5 text-slate-900 font-black text-xs">
                <div class="w-6 h-6 rounded-lg bg-sky-600 text-white flex items-center justify-center">
                    <i data-lucide="sparkles" class="w-3 h-3"></i>
                </div>
                <span>KAN LMS</span>
            </a>

            <div class="ms-auto flex items-center space-x-1.5 rtl:space-x-reverse">
                <div class="flex items-center bg-white p-0.5 rounded-lg border border-slate-200 shadow-2xs text-[10.5px] font-bold">
                    <a href="{{ route('locale.switch', 'en') }}" 
                       class="px-2 py-0.5 rounded-md transition-all {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        English
                    </a>
                    <a href="{{ route('locale.switch', 'ar') }}" 
                       class="px-2 py-0.5 rounded-md transition-all {{ app()->getLocale() === 'ar' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        العربية
                    </a>
                </div>
            </div>
        </div>

        <!-- Elevated White Card Container -->
        <div class="my-auto py-1 w-full max-w-sm mx-auto flex-shrink-0">
            <div class="bg-white rounded-2xl p-4 sm:p-4.5 shadow-xl shadow-slate-200/70 border border-slate-200/90 space-y-2.5">
                
                <!-- Header -->
                <div class="text-left rtl:text-right">
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-tight">
                        {{ __('messages.create_account') }}
                    </h2>
                    <p class="text-[11px] text-slate-500 mt-0.5 font-normal">
                        {{ __('messages.register_subtitle') }}
                    </p>
                </div>

                <!-- Registration Form -->
                <form class="space-y-2.5" action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Role Selection Toggle -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                            {{ __('messages.i_want_to') }}
                        </label>
                        <div class="grid grid-cols-2 gap-2">
                            <label @click="selectedRole = 'student'" 
                                   :class="selectedRole === 'student' ? 'border-blue-600 bg-blue-50/80 text-blue-900 ring-1 ring-blue-600' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'"
                                   class="flex items-center p-1.5 border rounded-xl cursor-pointer transition-all">
                                <input type="radio" name="role" value="student" x-model="selectedRole" class="sr-only">
                                <div class="w-5 h-5 rounded-md bg-blue-600/10 text-blue-600 flex items-center justify-center me-2 flex-shrink-0">
                                <i data-lucide="book-open" class="w-3 h-3"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold leading-tight">{{ __('messages.role_student') }}</div>
                                    <div class="text-[8px] text-slate-500 font-normal">{{ __('messages.student_role_desc') }}</div>
                                </div>
                            </label>

                            <label @click="selectedRole = 'instructor'" 
                                   :class="selectedRole === 'instructor' ? 'border-blue-600 bg-blue-50/80 text-blue-900 ring-1 ring-blue-600' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'"
                                   class="flex items-center p-1.5 border rounded-xl cursor-pointer transition-all">
                                <input type="radio" name="role" value="instructor" x-model="selectedRole" class="sr-only">
                                <div class="w-5 h-5 rounded-md bg-indigo-600/10 text-indigo-600 flex items-center justify-center me-2 flex-shrink-0">
                                    <i data-lucide="presentation" class="w-3 h-3"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold leading-tight">{{ __('messages.role_instructor') }}</div>
                                    <div class="text-[8px] text-slate-500 font-normal">{{ __('messages.instructor_role_desc') }}</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">
                            {{ __('messages.full_name') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                            </div>
                            <input id="name" name="name" type="text" required 
                                   value="{{ old('name') }}"
                                   placeholder="e.g. Alex Johnson"
                                   class="block w-full ps-9 pe-3 py-1.5 sm:py-2 text-xs text-slate-800 font-normal placeholder:font-normal placeholder:text-slate-400 rounded-xl border border-slate-200 bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 shadow-2xs transition-all outline-none">
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">
                            {{ __('messages.email_address') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                   value="{{ old('email') }}"
                                   placeholder="alex@company.com"
                                   class="block w-full ps-9 pe-3 py-1.5 sm:py-2 text-xs text-slate-800 font-normal placeholder:font-normal placeholder:text-slate-400 rounded-xl border border-slate-200 bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 shadow-2xs transition-all outline-none">
                        </div>
                    </div>

                    <!-- Headline / Expertise (for instructors) -->
                    <div x-show="selectedRole === 'instructor'" x-cloak>
                        <label for="headline" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">
                            {{ __('messages.headline') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                            </div>
                            <input id="headline" name="headline" type="text" 
                                   value="{{ old('headline') }}"
                                   placeholder="{{ __('messages.headline_placeholder') }}"
                                   class="block w-full ps-9 pe-3 py-1.5 sm:py-2 text-xs text-slate-800 font-normal placeholder:font-normal placeholder:text-slate-400 rounded-xl border border-slate-200 bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 shadow-2xs transition-all outline-none">
                        </div>
                    </div>

                    <!-- Password & Confirm -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div>
                            <label for="password" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">
                                {{ __('messages.password') }}
                            </label>
                            <input id="password" name="password" type="password" required 
                                   placeholder="••••••••"
                                   class="block w-full px-3 py-1.5 sm:py-2 text-xs text-slate-800 font-normal placeholder:font-normal placeholder:text-slate-400 rounded-xl border border-slate-200 bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 shadow-2xs transition-all outline-none">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">
                                {{ __('messages.confirm_password') }}
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                   placeholder="••••••••"
                                   class="block w-full px-3 py-1.5 sm:py-2 text-xs text-slate-800 font-normal placeholder:font-normal placeholder:text-slate-400 rounded-xl border border-slate-200 bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 shadow-2xs transition-all outline-none">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-1">
                        <button type="submit" 
                                class="w-full flex items-center justify-center space-x-1.5 rtl:space-x-reverse py-2.5 px-3 rounded-xl shadow-md shadow-blue-600/25 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 active:scale-[0.99] transition-all">
                            <span>{{ __('messages.btn_register') }}</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 rtl:rotate-180"></i>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="text-center pt-0.5">
                    <p class="text-[11px] text-slate-600 font-normal">
                        {{ __('messages.have_account') }}
                        <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline">
                            {{ __('messages.signin_here') }}
                        </a>
                    </p>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="pt-2 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between text-[10px] text-slate-400 font-normal gap-1 w-full max-w-sm mx-auto">
            <span>{{ __('messages.copyright') }}</span>
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                <a href="#" class="hover:text-slate-600 transition-colors">{{ __('messages.privacy') }}</a>
                <span>•</span>
                <a href="#" class="hover:text-slate-600 transition-colors">{{ __('messages.terms') }}</a>
                <span>•</span>
                <a href="#" class="hover:text-slate-600 transition-colors">{{ __('messages.support') }}</a>
            </div>
        </div>

    </div>

</div>
@endsection
