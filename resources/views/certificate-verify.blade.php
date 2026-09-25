@extends('layouts.app')

@section('title', 'Verify Certificate Credential')

@section('content')
<div class="bg-slate-50 min-h-[80vh] py-6 sm:py-8 font-sans">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        
        <!-- Header -->
        <div class="text-center space-y-2 mb-5">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-600 text-white flex items-center justify-center mx-auto shadow-md shadow-brand-500/20">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Verify Certificate Credential</h1>
            <p class="text-xs text-slate-500 max-w-sm mx-auto font-normal">
                Authenticate official certificates of completion issued by KAN Academy by entering the unique verification code.
            </p>
        </div>

        <!-- Lookup Form -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs mb-5">
            <form action="{{ route('certificate.verify') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="hash" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="code" value="{{ $searchCode }}" required 
                            placeholder="e.g. KAN-2026-UX89421" 
                            class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 uppercase font-mono bg-slate-50 focus:bg-white text-slate-900">
                </div>
                <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-all flex items-center justify-center space-x-1.5">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    <span>Verify Credential</span>
                </button>
            </form>
        </div>

        <!-- Verification Result -->
        @if($searched)
            @if($certificate)
                <div class="bg-white rounded-2xl border-2 border-emerald-500 shadow-xl p-5 sm:p-6 relative overflow-hidden animate-fade-in">
                    
                    <!-- Decorative watermark -->
                    <div class="absolute -right-8 -bottom-8 opacity-5 pointer-events-none text-slate-900">
                        <i data-lucide="award" class="w-48 h-48"></i>
                    </div>

                    <div class="flex items-center space-x-2 text-emerald-600 mb-4">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center">
                            <i data-lucide="check" class="w-3.5 h-3.5 font-bold"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider">Officially Verified Credential</span>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Recipient</span>
                            <h2 class="text-lg font-bold text-slate-900 mt-0.5">{{ $certificate->user->name }}</h2>
                            <p class="text-xs text-slate-500">{{ $certificate->user->email }}</p>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Completed Course</span>
                            <h3 class="text-base font-bold text-brand-700 mt-0.5">{{ $certificate->course->title }}</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-slate-100 text-xs">
                            <div>
                                <span class="text-slate-400 block text-[10px] font-medium uppercase tracking-wider">Verification Code</span>
                                <span class="font-mono font-bold text-slate-900 uppercase text-xs">{{ $certificate->certificate_code }}</span>
                            </div>

                            <div>
                                <span class="text-slate-400 block text-[10px] font-medium uppercase tracking-wider">Issue Date</span>
                                <span class="font-bold text-slate-900 text-xs">{{ $certificate->issued_at ? $certificate->issued_at->format('F d, Y') : $certificate->created_at->format('F d, Y') }}</span>
                            </div>

                            <div>
                                <span class="text-slate-400 block text-[10px] font-medium uppercase tracking-wider">Lead Instructor</span>
                                <span class="font-bold text-slate-900 text-xs">{{ $certificate->course->instructor->name }}</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-400">Issued by <strong class="text-slate-700">KAN Academy</strong></span>
                            <a href="{{ route('courses.show', $certificate->course->slug) }}" class="font-semibold text-brand-600 hover:underline flex items-center space-x-1">
                                <span>View Course Syllabus</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>

                </div>
            @else
                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-5 text-center space-y-2">
                    <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto">
                        <i data-lucide="alert-triangle" class="w-4.5 h-4.5"></i>
                    </div>
                    <h3 class="text-sm font-bold text-rose-900">Certificate Not Found</h3>
                    <p class="text-xs text-rose-700 max-w-sm mx-auto font-normal">
                        No official certificate record was found matching code <code class="font-mono font-bold bg-rose-200/60 px-1.5 py-0.5 rounded">{{ $searchCode }}</code>. Please double check the code format.
                    </p>
                </div>
            @endif
        @endif

    </div>
</div>
@endsection
