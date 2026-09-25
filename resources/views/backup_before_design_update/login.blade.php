@extends('layouts.app')

@section('title', 'Sign In - KAN')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-4 px-4">
    <div class="max-w-[360px] w-full space-y-3.5 bg-white p-5 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100">
        
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-400 via-rose-400 to-sky-400 flex items-center justify-center shadow-md shadow-amber-400/25 mb-2">
                <i data-lucide="sparkles" class="w-4.5 h-4.5 text-white"></i>
            </div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">KAN</h2>
            <p class="text-[11px] text-slate-500 mt-0.5">Sign in to your learning portal</p>
        </div>

        <!-- Quick Demo Switcher Buttons -->
        <div class="bg-amber-50/60 p-2.5 rounded-xl border border-amber-200/70">
            <div class="text-[9px] font-extrabold text-amber-800/80 uppercase tracking-wider text-center mb-1.5">
                ⚡ 1-Click Demo Login
            </div>
            <div class="grid grid-cols-3 gap-1.5">
                <button type="button" onclick="fillCredentials('admin@lms.com', 'password')" 
                        class="px-1.5 py-1 text-[11px] font-bold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 rounded-lg transition-colors text-center shadow-xs">
                    Admin
                </button>
                <button type="button" onclick="fillCredentials('instructor@lms.com', 'password')" 
                        class="px-1.5 py-1 text-[11px] font-bold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/80 rounded-lg transition-colors text-center shadow-xs">
                    Instructor
                </button>
                <button type="button" onclick="fillCredentials('student@lms.com', 'password')" 
                        class="px-1.5 py-1 text-[11px] font-bold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 rounded-lg transition-colors text-center shadow-xs">
                    Student
                </button>
            </div>
        </div>

        <!-- Login Form -->
        <form class="space-y-3" action="{{ route('login') }}" method="POST">
            @csrf

            <div>
                <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                    </div>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           value="{{ old('email') }}"
                           placeholder="you@example.com"
                           class="block w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-slate-900 transition-colors">
                </div>
            </div>

            <div>
                <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="key-round" class="w-3.5 h-3.5"></i>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           placeholder="••••••••"
                           class="block w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-slate-900 transition-colors">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                           class="h-3.5 w-3.5 text-amber-600 focus:ring-amber-500 border-slate-300 rounded">
                    <label for="remember" class="ml-1.5 block text-[11px] font-semibold text-slate-600">Remember me</label>
                </div>
            </div>

            <div class="pt-0.5">
                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 rounded-xl shadow-md shadow-amber-500/25 text-xs font-bold text-white bg-gradient-to-r from-amber-500 via-rose-500 to-indigo-600 hover:opacity-95 transition-all">
                    Sign In
                </button>
            </div>
        </form>

        <!-- Footer link -->
        <div class="text-center pt-1 border-t border-slate-100">
            <p class="text-[11px] text-slate-500">
                New to KAN? 
                <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-700 hover:underline">
                    Create free account
                </a>
            </p>
        </div>

    </div>
</div>

<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection
