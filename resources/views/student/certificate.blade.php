@extends('layouts.app')

@section('title', 'Certificate of Completion - ' . $course->title . ' | KAN')

@section('content')
<div class="bg-slate-100 min-h-screen py-10 print:py-0 print:bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header Toolbar (Hidden when printing) -->
        <div class="flex items-center justify-between print:hidden">
            <div>
                <h1 class="text-xl font-black text-slate-900 flex items-center space-x-2">
                    <i data-lucide="award" class="w-5 h-5 text-brand-600"></i>
                    <span>Certificate of Completion</span>
                </h1>
                <p class="text-xs text-slate-500">Official digital credential issued by KAN Academy</p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="window.print()" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs rounded-2xl shadow-lg shadow-brand-500/25 flex items-center space-x-2 transition-all">
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Print / Save PDF</span>
                </button>
                <a href="{{ route('student.my-courses') }}" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-50">
                    Back to Courses
                </a>
            </div>
        </div>

        <!-- Academic / KAN Certificate Graphic Canvas -->
        <div class="bg-white rounded-3xl p-8 sm:p-14 shadow-2xl border-8 border-double border-slate-200 relative overflow-hidden text-center space-y-8 print:border-4 print:shadow-none print:m-0 print:p-8">
            
            <!-- Corner Ornaments -->
            <div class="absolute top-4 left-4 w-12 h-12 border-t-2 border-l-2 border-brand-500/60 pointer-events-none"></div>
            <div class="absolute top-4 right-4 w-12 h-12 border-t-2 border-r-2 border-brand-500/60 pointer-events-none"></div>
            <div class="absolute bottom-4 left-4 w-12 h-12 border-b-2 border-l-2 border-brand-500/60 pointer-events-none"></div>
            <div class="absolute bottom-4 right-4 w-12 h-12 border-b-2 border-r-2 border-brand-500/60 pointer-events-none"></div>

            <!-- Top Emblem & Header -->
            <div class="space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand-600 to-indigo-600 flex items-center justify-center text-white mx-auto shadow-xl shadow-brand-500/30">
                    <i data-lucide="award" class="w-8 h-8"></i>
                </div>
                <div class="text-[12px] font-black tracking-[0.25em] uppercase text-brand-600">KAN • EARLY LEARNING ACADEMY</div>
                <h2 class="text-3xl sm:text-4xl font-serif font-black tracking-tight text-slate-900 uppercase">
                    Certificate of Completion
                </h2>
                <p class="text-xs text-slate-400 font-bold tracking-wider uppercase">This is to officially certify that</p>
            </div>

            <!-- Student Name -->
            <div class="py-2 border-b-2 border-slate-900 max-w-lg mx-auto">
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 font-serif tracking-normal">
                    {{ $certificate->user->name }}
                </h3>
            </div>

            <!-- Course Description -->
            <div class="max-w-xl mx-auto space-y-2">
                <p class="text-xs text-slate-500">has successfully completed the playful curriculum, creative adventures, and foundational milestones for</p>
                <h4 class="text-xl sm:text-2xl font-black text-brand-600 font-serif leading-snug">
                    {{ $certificate->course->title }}
                </h4>
            </div>

            <!-- Signatures & Verification Row -->
            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-slate-100 items-end text-center text-xs">
                
                <!-- Instructor Signature -->
                <div class="space-y-2">
                    <div class="font-serif italic text-lg font-bold text-slate-800 border-b border-slate-300 pb-1 mx-auto max-w-[160px]">
                        {{ $certificate->course->instructor->name }}
                    </div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Lead Instructor</span>
                </div>

                <!-- Gold Verified Seal -->
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-amber-500 via-yellow-400 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/30 text-amber-950 font-black text-[9px] uppercase tracking-widest text-center border-4 border-white p-1">
                        <div class="w-full h-full rounded-full border border-amber-800/40 flex flex-col items-center justify-center">
                            <i data-lucide="check-circle" class="w-5 h-5 mb-0.5"></i>
                            <span class="font-black text-[8px] tracking-wider">OFFICIAL SEAL</span>
                        </div>
                    </div>
                </div>

                <!-- Issue Date & Dean -->
                <div class="space-y-2">
                    <div class="font-semibold text-slate-800 border-b border-slate-300 pb-1 mx-auto max-w-[160px]">
                        {{ $certificate->issued_at ? $certificate->issued_at->format('F d, Y') : $certificate->created_at->format('F d, Y') }}
                    </div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Date Issued</span>
                </div>

            </div>

            <!-- Footer Verification Code & Online Link -->
            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400">
                <div>
                    Credential ID: <strong class="font-mono text-slate-800 uppercase">{{ $certificate->certificate_code }}</strong>
                </div>
                <div>
                    Verify online at: <a href="{{ route('certificate.verify', ['code' => $certificate->certificate_code]) }}" class="text-brand-600 font-bold hover:underline">{{ route('certificate.verify', ['code' => $certificate->certificate_code]) }}</a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
