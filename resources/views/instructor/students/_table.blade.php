<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-700">
        <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-100">
            <tr>
                <th class="px-4 py-2.5">Student</th>
                <th class="px-4 py-2.5">Course Enrolled</th>
                <th class="px-4 py-2.5">Enrolled Date</th>
                <th class="px-4 py-2.5">Learning Progress</th>
                <th class="px-4 py-2.5 text-right">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($enrollments as $enrollment)
                @php $prog = $enrollment->course->getStudentProgressPercentage($enrollment->user_id); @endphp
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center space-x-2.5">
                            <img src="{{ $enrollment->user->avatar_url }}" class="w-7 h-7 rounded-lg object-cover ring-1 ring-slate-100 flex-shrink-0" alt="">
                            <div>
                                <span class="font-semibold text-slate-900 block leading-tight text-xs">{{ $enrollment->user->name }}</span>
                                <span class="text-[10px] text-slate-400 font-normal">{{ $enrollment->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5 font-semibold text-slate-900">
                        {{ $enrollment->course->title }}
                    </td>
                    <td class="px-4 py-2.5 text-slate-400 font-normal">
                        {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : $enrollment->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-2.5">
                        <div class="w-36 sm:w-40 space-y-1">
                            <div class="flex justify-between text-[10px] text-slate-500 font-medium">
                                <span>Completed</span>
                                <span class="font-bold text-slate-800">{{ $prog }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-1.5 rounded-full transition-all" style="width: {{ $prog }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        <span class="px-2 py-0.5 text-[9px] font-bold rounded-lg uppercase tracking-wider {{ $enrollment->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-50 text-blue-700' }}">
                            {{ $enrollment->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-slate-400">
                        No student enrollments found matching criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($enrollments->hasPages())
    <div class="p-3 border-t border-slate-100">
        {{ $enrollments->links() }}
    </div>
@endif
