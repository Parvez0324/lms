<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50/80 text-[10px] uppercase font-extrabold text-slate-500 border-b border-slate-200/80">
            <tr>
                <th class="px-4 py-3">Student</th>
                <th class="px-4 py-3">Course</th>
                <th class="px-4 py-3">Enrolled Date</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($enrollments as $enrollment)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $enrollment->user->avatar_url }}" class="w-8 h-8 rounded-xl object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $enrollment->user->name }}</span>
                                <span class="text-[11px] text-slate-400 font-medium">{{ $enrollment->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5">
                        <span class="font-bold text-slate-900 block">{{ $enrollment->course->title }}</span>
                        <span class="text-[11px] text-slate-400 font-medium">Instructor: {{ $enrollment->course->instructor->name }}</span>
                    </td>
                    <td class="px-4 py-2.5 text-slate-500 font-medium text-[11px]">
                        {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : $enrollment->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-2.5">
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md uppercase tracking-wider {{ $enrollment->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                            {{ $enrollment->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        <div class="flex items-center justify-end">
                            <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Revoke this enrollment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" title="Revoke Enrollment">
                                    <i data-lucide="user-x" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                        No enrollments recorded yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($enrollments->hasPages())
    <div class="p-3 border-t border-slate-100 text-xs">
        {{ $enrollments->links() }}
    </div>
@endif
