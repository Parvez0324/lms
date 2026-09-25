@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-4 sm:py-6 px-4 sm:px-6 lg:px-8" x-data="{ selectedRole: '{{ old('role', request('role', 'student')) }}' }">
    <div class="max-w-md w-full space-y-4 bg-white p-6 sm:p-7 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100">
        
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-11 h-11 rounded-2xl bg-gradient-to-tr from-brand-600 via-brand-500 to-accent-500 flex items-center justify-center shadow-lg shadow-brand-500/25 mb-2.5">
                <i data-lucide="user-plus" class="w-5 h-5 text-white"></i>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Create Your Account</h2>
            <p class="mt-0.5 text-xs text-slate-500">Join thousands of students and instructors worldwide</p>
        </div>

        <!-- Registration Form -->
        <form class="mt-4 space-y-3.5" action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Account Type Picker -->
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">I want to:</label>
                <div class="grid grid-cols-2 gap-2.5">
                    <label @click="selectedRole = 'student'" 
                           :class="selectedRole === 'student' ? 'border-brand-600 bg-brand-50/70 text-brand-900 ring-2 ring-brand-500/30' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'"
                           class="flex items-center p-2.5 border rounded-xl cursor-pointer transition-all">
                        <input type="radio" name="role" value="student" x-model="selectedRole" class="sr-only">
                        <div class="w-7 h-7 rounded-lg bg-brand-500/10 text-brand-600 flex items-center justify-center mr-2.5 flex-shrink-0">
                            <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold leading-tight">Student</div>
                            <div class="text-[9px] text-slate-500">Learn courses</div>
                        </div>
                    </label>

                    <label @click="selectedRole = 'instructor'" 
                           :class="selectedRole === 'instructor' ? 'border-brand-600 bg-brand-50/70 text-brand-900 ring-2 ring-brand-500/30' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'"
                           class="flex items-center p-2.5 border rounded-xl cursor-pointer transition-all">
                        <input type="radio" name="role" value="instructor" x-model="selectedRole" class="sr-only">
                        <div class="w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-600 flex items-center justify-center mr-2.5 flex-shrink-0">
                            <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold leading-tight">Instructor</div>
                            <div class="text-[9px] text-slate-500">Teach & earn</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                    </div>
                    <input id="name" name="name" type="text" required 
                           value="{{ old('name') }}"
                           placeholder="Sarah Connor"
                           class="block w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 text-slate-900 transition-colors">
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                    </div>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           value="{{ old('email') }}"
                           placeholder="sarah@example.com"
                           class="block w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 text-slate-900 transition-colors">
                </div>
            </div>

            <!-- Headline / Expertise (for instructors) -->
            <div x-show="selectedRole === 'instructor'" style="display: none;">
                <label for="headline" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Professional Headline</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                    </div>
                    <input id="headline" name="headline" type="text" 
                           value="{{ old('headline') }}"
                           placeholder="e.g. Senior Software Architect"
                           class="block w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 text-slate-900 transition-colors">
                </div>
            </div>

            <!-- Password & Confirm -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" required 
                           placeholder="••••••••"
                           class="block w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 text-slate-900 transition-colors">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           placeholder="••••••••"
                           class="block w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 text-slate-900 transition-colors">
                </div>
            </div>

            <div class="pt-1.5">
                <button type="submit" 
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-lg shadow-brand-500/25 text-xs font-bold text-white bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all">
                    Complete Registration
                </button>
            </div>
        </form>

        <!-- Footer link -->
        <div class="text-center pt-1">
            <p class="text-xs text-slate-500">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-700 hover:underline">
                    Sign in here
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
