@extends('layouts.base')

@section('title', __('messages.welcome_back') . ' - KAN LMS')

@section('body')
<div class="h-screen w-full flex flex-col lg:flex-row overflow-hidden bg-slate-950 font-sans" x-data="{
    showPassword: false,
    email: '{{ old('email', '') }}',
    password: '',
    fillRole(roleEmail, rolePass) {
        this.email = roleEmail;
        this.password = rolePass;
    }
}">

    <!-- Left Hero Showcase (Enterprise LMS) -->
    <div class="relative flex-1 lg:w-7/12 xl:w-3/5 bg-slate-950 text-white flex flex-col p-4 sm:p-6 lg:p-7 overflow-hidden">
        
        <!-- Background City/Office Image with Deep Navy Gradient Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1800&q=80" 
                 class="w-full h-full object-cover object-center opacity-25 filter brightness-75 contrast-125" 
                 alt="Enterprise Campus Background">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#040d1a] via-[#081b33]/95 to-[#0b2447]/90 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-radial-at-t from-sky-500/10 via-transparent to-transparent"></div>
        </div>

        <!-- Top Navigation Bar in Left Panel -->
        <div class="relative z-10 flex items-center justify-between flex-shrink-0">
            <!-- Brand Logo & Tagline -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2.5 rtl:space-x-reverse group">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gradient-to-tr from-sky-500 to-blue-600 flex items-center justify-center shadow-md shadow-sky-500/30 ring-1 ring-white/20 group-hover:scale-105 transition-transform">
                    <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
                </div>
                <div>
                    <div class="text-sm sm:text-base font-black tracking-tight text-white flex items-center gap-1.5 leading-none">
                        <span>KAN</span>
                        <span class="text-sky-400 font-extrabold text-[10px] sm:text-[11px] px-1 py-0.5 rounded bg-sky-500/20 border border-sky-400/30">LMS</span>
                    </div>
                    <p class="text-[9.5px] sm:text-[10px] text-slate-300 font-medium tracking-wide mt-0.5">{{ __('messages.tagline') }}</p>
                </div>
            </a>

            <!-- LMS Category Navigation Links (Desktop) -->
            <div class="hidden md:flex items-center space-x-3.5 rtl:space-x-reverse text-[11px] font-semibold text-slate-300">
                <a href="{{ route('courses.index') }}" class="hover:text-sky-400 transition-colors">{{ __('messages.explore_courses') }}</a>
                <span class="text-slate-600">•</span>
                <a href="{{ route('certificate.verify') }}" class="hover:text-sky-400 transition-colors">{{ __('messages.verify_certificate') }}</a>
                <span class="text-slate-600">•</span>
                <a href="{{ route('home') }}" class="hover:text-sky-400 transition-colors">{{ __('messages.categories_sub') }}</a>
            </div>
        </div>

        <!-- Main Hero Pitch & LMS Feature Grid -->
        <div class="relative z-10 flex-1 flex flex-col justify-start pt-4 sm:pt-5 lg:pt-6 space-y-3.5 max-w-xl">
            
            <!-- Badge -->
            <div class="inline-flex items-center space-x-2 rtl:space-x-reverse px-2.5 py-0.5 rounded-full bg-sky-500/10 border border-sky-400/30 text-sky-300 text-[9.5px] font-extrabold tracking-widest uppercase self-start">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                <span>{{ __('messages.lms_badge') }}</span>
            </div>

            <!-- Headline -->
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight text-white leading-tight">
                {{ __('messages.hero_title_left') }}
                <span class="bg-gradient-to-r from-sky-400 via-blue-300 to-indigo-300 bg-clip-text text-transparent">
                    {{ __('messages.hero_title_accent') }}
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xs sm:text-[13px] text-slate-300 font-normal leading-relaxed max-w-lg">
                {{ __('messages.hero_desc_left') }}
            </p>

            <!-- 6 Feature Chips Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 pt-0.5">
                
                <!-- 1. Course Management -->
                <div class="p-2 rounded-xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 backdrop-blur-sm transition-all duration-200 group">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse mb-0.5">
                        <div class="w-5 h-5 rounded-md bg-sky-500/20 text-sky-400 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="book-open" class="w-3 h-3"></i>
                        </div>
                        <h4 class="text-[10.5px] font-bold text-white group-hover:text-sky-300 transition-colors truncate">{{ __('messages.feature_courses') }}</h4>
                    </div>
                    <p class="text-[9.5px] text-slate-400 leading-snug line-clamp-1">{{ __('messages.feature_courses_desc') }}</p>
                </div>

                <!-- 2. Interactive Curriculum -->
                <div class="p-2 rounded-xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 backdrop-blur-sm transition-all duration-200 group">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse mb-0.5">
                        <div class="w-5 h-5 rounded-md bg-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="layers" class="w-3 h-3"></i>
                        </div>
                        <h4 class="text-[10.5px] font-bold text-white group-hover:text-sky-300 transition-colors truncate">{{ __('messages.feature_curriculum') }}</h4>
                    </div>
                    <p class="text-[9.5px] text-slate-400 leading-snug line-clamp-1">{{ __('messages.feature_curriculum_desc') }}</p>
                </div>

                <!-- 3. Student 360 -->
                <div class="p-2 rounded-xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 backdrop-blur-sm transition-all duration-200 group">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse mb-0.5">
                        <div class="w-5 h-5 rounded-md bg-indigo-500/20 text-indigo-400 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="user-check" class="w-3 h-3"></i>
                        </div>
                        <h4 class="text-[10.5px] font-bold text-white group-hover:text-sky-300 transition-colors truncate">{{ __('messages.feature_student360') }}</h4>
                    </div>
                    <p class="text-[9.5px] text-slate-400 leading-snug line-clamp-1">{{ __('messages.feature_student360_desc') }}</p>
                </div>

                <!-- 4. Quizzes & Tasks -->
                <div class="p-2 rounded-xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 backdrop-blur-sm transition-all duration-200 group">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse mb-0.5">
                        <div class="w-5 h-5 rounded-md bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="clipboard-check" class="w-3 h-3"></i>
                        </div>
                        <h4 class="text-[10.5px] font-bold text-white group-hover:text-sky-300 transition-colors truncate">{{ __('messages.feature_quizzes') }}</h4>
                    </div>
                    <p class="text-[9.5px] text-slate-400 leading-snug line-clamp-1">{{ __('messages.feature_quizzes_desc') }}</p>
                </div>

                <!-- 5. Reports & Analytics -->
                <div class="p-2 rounded-xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 backdrop-blur-sm transition-all duration-200 group">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse mb-0.5">
                        <div class="w-5 h-5 rounded-md bg-amber-500/20 text-amber-400 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="bar-chart-3" class="w-3 h-3"></i>
                        </div>
                        <h4 class="text-[10.5px] font-bold text-white group-hover:text-sky-300 transition-colors truncate">{{ __('messages.feature_reports') }}</h4>
                    </div>
                    <p class="text-[9.5px] text-slate-400 leading-snug line-clamp-1">{{ __('messages.feature_reports_desc') }}</p>
                </div>

                <!-- 6. Campus Collaboration -->
                <div class="p-2 rounded-xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 backdrop-blur-sm transition-all duration-200 group">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse mb-0.5">
                        <div class="w-5 h-5 rounded-md bg-rose-500/20 text-rose-400 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="users" class="w-3 h-3"></i>
                        </div>
                        <h4 class="text-[10.5px] font-bold text-white group-hover:text-sky-300 transition-colors truncate">{{ __('messages.feature_collab') }}</h4>
                    </div>
                    <p class="text-[9.5px] text-slate-400 leading-snug line-clamp-1">{{ __('messages.feature_collab_desc') }}</p>
                </div>

            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-2 border-t border-white/10">
                <div>
                    <div class="text-lg sm:text-xl font-black text-white">{{ __('messages.stat_students') }}</div>
                    <div class="text-[8.5px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('messages.stat_students_label') }}</div>
                </div>
                <div>
                    <div class="text-lg sm:text-xl font-black text-sky-400">{{ __('messages.stat_courses') }}</div>
                    <div class="text-[8.5px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('messages.stat_courses_label') }}</div>
                </div>
                <div>
                    <div class="text-lg sm:text-xl font-black text-indigo-300">{{ __('messages.stat_certificates') }}</div>
                    <div class="text-[8.5px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('messages.stat_certificates_label') }}</div>
                </div>
                <div>
                    <div class="text-lg sm:text-xl font-black text-emerald-400">{{ __('messages.stat_uptime') }}</div>
                    <div class="text-[8.5px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('messages.stat_uptime_label') }}</div>
                </div>
            </div>

        </div>

        <!-- Bottom Global Reach -->
        <div class="relative z-10 mt-auto pt-2 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[9.5px] text-slate-400 font-semibold tracking-wider flex-shrink-0">
            <span class="text-slate-300 uppercase tracking-widest text-[9px]">{{ __('messages.global_reach') }}</span>
            <span class="text-sky-300 font-bold tracking-widest text-[9px]">{{ __('messages.countries') }}</span>
        </div>

    </div>

    <!-- Right Side: Elevated Auth Card on Slate Canvas (Fitted without Scroll) -->
    <div class="flex-shrink-0 w-full lg:w-5/12 xl:w-2/5 bg-slate-50 text-slate-900 flex flex-col justify-between p-3.5 sm:p-4 lg:py-4 lg:px-6 shadow-2xl border-l border-slate-200/90 z-20 h-full overflow-y-auto lg:overflow-hidden">
        
        <!-- Top Right Language Switcher -->
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
                
                <!-- Auth Header -->
                <div class="text-left rtl:text-right">
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-tight">
                        {{ __('messages.welcome_back') }}
                    </h2>
                    <p class="text-[11px] text-slate-500 mt-0.5 font-normal">
                        {{ __('messages.login_subtitle') }}
                    </p>
                </div>

                <!-- Quick 1-Click Role Login Panel -->
                <div class="bg-slate-50 p-2 rounded-xl border border-slate-200/80">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[9.5px] font-black uppercase tracking-wider text-slate-700 flex items-center gap-1">
                            <i data-lucide="zap" class="w-3 h-3 text-amber-500 fill-amber-500"></i>
                            <span>{{ __('messages.quick_demo') }}</span>
                        </span>
                        <span class="text-[8.5px] text-slate-400 font-semibold">1-Click Auto Fill</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1.5">
                        <button type="button" @click="fillRole('admin@lms.com', 'password')" 
                                class="px-1.5 py-1 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200/80 rounded-lg transition-all shadow-2xs hover:border-rose-400 text-center flex flex-col items-center justify-center group">
                            <span class="text-[9.5px] font-extrabold group-hover:scale-105 transition-transform">{{ __('messages.role_admin') }}</span>
                            <span class="text-[7.5px] font-normal text-slate-400">admin@lms...</span>
                        </button>
                        <button type="button" @click="fillRole('instructor@lms.com', 'password')" 
                                class="px-1.5 py-1 bg-white hover:bg-indigo-50 text-indigo-700 border border-indigo-200/80 rounded-lg transition-all shadow-2xs hover:border-indigo-400 text-center flex flex-col items-center justify-center group">
                            <span class="text-[9.5px] font-extrabold group-hover:scale-105 transition-transform">{{ __('messages.role_instructor') }}</span>
                            <span class="text-[7.5px] font-normal text-slate-400">instructor@...</span>
                        </button>
                        <button type="button" @click="fillRole('student@lms.com', 'password')" 
                                class="px-1.5 py-1 bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-200/80 rounded-lg transition-all shadow-2xs hover:border-emerald-400 text-center flex flex-col items-center justify-center group">
                            <span class="text-[9.5px] font-extrabold group-hover:scale-105 transition-transform">{{ __('messages.role_student') }}</span>
                            <span class="text-[7.5px] font-normal text-slate-400">student@lms...</span>
                        </button>
                    </div>
                </div>

                <!-- Main Login Form -->
                <form class="space-y-2.5" action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">
                            {{ __('messages.email_address') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                   x-model="email"
                                   placeholder="you@company.com"
                                   class="block w-full ps-9 pe-3 py-1.5 text-xs text-slate-800 font-normal placeholder:font-normal placeholder:text-slate-400 rounded-xl border border-slate-200 bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 shadow-2xs transition-all outline-none">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-0.5">
                            <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700">
                                {{ __('messages.password') }}
                            </label>
                            <a href="#" class="text-[9.5px] font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                {{ __('messages.forgot_password') }}
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                            </div>
                            <input id="password" name="password" :type="showPassword ? 'text' : 'password'" autocomplete="current-password" required 
                                   x-model="password"
                                   placeholder="••••••••"
                                   class="block w-full ps-9 pe-9 py-1.5 text-xs text-slate-800 font-normal placeholder:font-normal placeholder:text-slate-400 rounded-xl border border-slate-200 bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 shadow-2xs transition-all outline-none">
                            <button type="button" @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 end-0 pe-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i :data-lucide="showPassword ? 'eye-off' : 'eye'" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" checked
                               class="h-3.5 w-3.5 text-blue-600 focus:ring-blue-500 border-slate-300 rounded cursor-pointer">
                        <label for="remember" class="ms-1.5 block text-[11px] font-normal text-slate-600 cursor-pointer">
                            {{ __('messages.remember_me') }}
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-0.5">
                        <button type="submit" 
                                class="w-full flex items-center justify-center space-x-1.5 rtl:space-x-reverse py-2 px-4 rounded-xl shadow-md shadow-blue-600/20 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 active:scale-[0.99] transition-all">
                            <span>{{ __('messages.btn_signin') }}</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 rtl:rotate-180"></i>
                        </button>
                    </div>
                </form>

                <!-- Registration Link -->
                <div class="text-center pt-0.5">
                    <p class="text-[11px] text-slate-600 font-normal">
                        {{ __('messages.no_account') }}
                        <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline">
                            {{ __('messages.request_access') }}
                        </a>
                    </p>
                </div>

                <!-- Security Trust Card -->
                <div class="p-2 rounded-xl bg-slate-50 border border-slate-200/70 flex items-center space-x-2 rtl:space-x-reverse">
                    <div class="w-5 h-5 rounded-md bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="shield-check" class="w-3 h-3"></i>
                    </div>
                    <p class="text-[9.5px] text-slate-500 leading-snug font-normal flex-1">
                        {{ __('messages.security_note') }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Footer Copyright & Legal Links -->
        <div class="pt-1.5 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between text-[9.5px] text-slate-400 font-normal gap-1 w-full max-w-sm mx-auto flex-shrink-0">
            <span>{{ __('messages.copyright') }}</span>
            <div class="flex items-center space-x-2.5 rtl:space-x-reverse">
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
