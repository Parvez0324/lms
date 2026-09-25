@extends('layouts.app')

@section('title', 'My Profile - KAN LMS')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-3.5 sm:py-4 font-sans"
     x-data="{ activeTab: '{{ $errors->has('current_password') || $errors->has('password') ? 'security' : 'personal' }}' }">
    
    <!-- Compact Header -->
    <div class="mb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5">
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Account & Profile Settings</h1>
            <p class="text-xs text-slate-500 font-normal mt-0.5">Manage your public bio, personal information, and login credentials</p>
        </div>

        <div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 transition-colors">
                    <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                    <span>Admin Studio</span>
                </a>
            @elseif(Auth::user()->isInstructor())
                <a href="{{ route('instructor.dashboard') }}" class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                    <span>Instructor Studio</span>
                </a>
            @else
                <a href="{{ route('student.dashboard') }}" class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                    <span>Student Dashboard</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Alert / Feedback Messages -->
    @if(session('success'))
        <div class="mb-3 p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-3 p-2.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium space-y-1">
            <div class="font-bold flex items-center space-x-1.5">
                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 flex-shrink-0"></i>
                <span>Please review the errors below:</span>
            </div>
            <ul class="list-disc list-inside text-[11px] text-rose-700 pl-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3.5 sm:gap-4 items-start">
        
        <!-- Left Column: User Summary Card (Compact) -->
        <div class="lg:col-span-4 bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col items-center text-center">
            <img class="w-16 h-16 rounded-xl object-cover ring-2 ring-blue-500/20 shadow-xs mb-2" 
                 src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
            
            <h3 class="text-sm font-bold text-slate-900 leading-tight">{{ $user->name }}</h3>
            <p class="text-[11px] text-slate-500 font-normal mt-0.5">{{ $user->email }}</p>
            
            <span class="inline-block mt-2 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-md {{ $user->isAdmin() ? 'bg-rose-100 text-rose-700' : ($user->isInstructor() ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700') }}">
                {{ $user->role }}
            </span>

            <div class="w-full border-t border-slate-100 mt-3 pt-3 text-left space-y-2 text-xs">
                <div class="flex justify-between text-slate-500 text-[11px]">
                    <span class="font-normal">Member Since</span>
                    <span class="font-semibold text-slate-800">{{ $user->created_at->format('M Y') }}</span>
                </div>
                <div class="flex justify-between text-slate-500 text-[11px]">
                    <span class="font-normal">Status</span>
                    <span class="font-bold text-emerald-600 capitalize">{{ $user->status }}</span>
                </div>
                @if($user->isStudent())
                    <div class="flex justify-between text-slate-500 text-[11px]">
                        <span class="font-normal">Enrolled Courses</span>
                        <span class="font-semibold text-slate-800">{{ $user->enrollments()->count() }}</span>
                    </div>
                @elseif($user->isInstructor())
                    <div class="flex justify-between text-slate-500 text-[11px]">
                        <span class="font-normal">Created Courses</span>
                        <span class="font-semibold text-slate-800">{{ $user->courses()->count() }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Tabbed Forms (Personal Details & Security) -->
        <div class="lg:col-span-8 bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs">
            
            <!-- Tab Buttons -->
            <div class="flex items-center space-x-1.5 bg-slate-100/90 p-1 rounded-xl mb-3 text-xs w-fit">
                <button type="button" @click="activeTab = 'personal'" 
                        class="flex items-center space-x-1.5 px-3 py-1 rounded-lg text-xs font-semibold transition-all"
                        :class="activeTab === 'personal' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-800'">
                    <i data-lucide="user" class="w-3.5 h-3.5"></i>
                    <span>Personal Details</span>
                </button>
                <button type="button" @click="activeTab = 'security'" 
                        class="flex items-center space-x-1.5 px-3 py-1 rounded-lg text-xs font-semibold transition-all"
                        :class="activeTab === 'security' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-800'">
                    <i data-lucide="key" class="w-3.5 h-3.5"></i>
                    <span>Security & Password</span>
                </button>
            </div>

            <!-- Tab 1: Edit Profile Form -->
            <div x-show="activeTab === 'personal'">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                   class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-900">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                   class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-900">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Professional Headline</label>
                        <input type="text" name="headline" value="{{ old('headline', $user->headline) }}" 
                               placeholder="e.g. Senior Software Engineer & AI Researcher"
                               class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-900">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   placeholder="+1 (555) 000-0000"
                                   class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-900">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Profile Avatar Image</label>
                            <input type="file" name="avatar" accept="image/*" 
                                   class="w-full text-xs text-slate-500 file:mr-2.5 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Biography / About Me</label>
                        <textarea name="bio" rows="2" 
                                  placeholder="Write a short summary about your background, experience, and interests..."
                                  class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-900">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <div class="flex justify-end pt-1">
                        <button type="submit" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg shadow-xs transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab 2: Password Update Form -->
            <div x-show="activeTab === 'security'" style="display: none;">
                <form action="{{ route('profile.password') }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Current Password *</label>
                        <input type="password" name="current_password" required 
                               placeholder="••••••••"
                               class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-900">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">New Password *</label>
                            <input type="password" name="password" required 
                                   placeholder="••••••••"
                                   class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-900">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Confirm New Password *</label>
                            <input type="password" name="password_confirmation" required 
                                   placeholder="••••••••"
                                   class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-900">
                        </div>
                    </div>

                    <div class="flex justify-end pt-1">
                        <button type="submit" class="px-4 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-lg shadow-xs transition-colors">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
