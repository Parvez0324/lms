@extends('layouts.admin')

@section('title', 'Student Profile - ' . $student->name)

@section('admin_content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $student->name }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Student dossier, enrolled courses, and activity history</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.students.edit', $student->id) }}" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-sm transition-colors">
                Edit Account
            </a>
            <a href="{{ route('admin.students.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Back</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Student Info Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center space-x-4">
                <img class="w-16 h-16 rounded-2xl object-cover ring-2 ring-rose-500/20" src="{{ $student->avatar_url }}" alt="">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">{{ $student->name }}</h3>
                    <p class="text-xs text-slate-400 font-medium">{{ $student->email }}</p>
                    <span class="inline-block mt-2 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md {{ $student->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                        {{ $student->status }}
                    </span>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 space-y-3 text-xs text-slate-500">
                <div class="flex justify-between">
                    <span class="font-medium">Phone:</span>
                    <span class="text-slate-800 font-semibold">{{ $student->phone ?: 'None' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Registered:</span>
                    <span class="text-slate-800 font-semibold">{{ $student->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Total Enrollments:</span>
                    <span class="text-rose-600 font-bold">{{ $student->enrollments->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Certificates Earned:</span>
                    <span class="text-purple-600 font-bold">{{ $student->certificates->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses & Progress -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 flex items-center">
                <i data-lucide="book-open" class="w-4 h-4 mr-2 text-rose-600"></i>
                Enrolled Courses & Progress
            </h3>

            <div class="divide-y divide-slate-100">
                @forelse($student->enrollments as $enrollment)
                    @php $progress = $enrollment->course->getStudentProgressPercentage($student->id); @endphp
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                        <div>
                            <span class="font-bold text-slate-900 block text-sm">{{ $enrollment->course->title }}</span>
                            <span class="text-[11px] text-slate-400 font-medium">Enrolled on {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : $enrollment->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-32">
                                <div class="flex justify-between text-[10px] text-slate-500 mb-1 font-semibold">
                                    <span>Progress</span>
                                    <span class="font-bold text-slate-800">{{ $progress }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-rose-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wider {{ $enrollment->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                {{ $enrollment->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-6 text-center">Student has not enrolled in any courses yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
