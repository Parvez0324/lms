<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-700">
        <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-100">
            <tr>
                <th class="px-4 py-3">Student</th>
                <th class="px-4 py-3">Activity & Course</th>
                <th class="px-4 py-3">Attachment</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Grade</th>
                <th class="px-4 py-3 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($submissions as $submission)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-2.5">
                            <img src="{{ $submission->user->avatar_url }}" class="w-7 h-7 rounded-lg object-cover ring-1 ring-slate-100 flex-shrink-0" alt="">
                            <div>
                                <span class="font-bold text-slate-900 block leading-tight">{{ $submission->user->name }}</span>
                                <span class="text-[10px] text-slate-400">{{ $submission->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-bold text-slate-900 block leading-tight">{{ $submission->assignment->title }}</span>
                        <span class="text-[10px] text-amber-600 font-semibold">{{ $submission->assignment->course->title }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @if($submission->file_path)
                            <a href="{{ $submission->file_url }}" target="_blank" class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold text-[10px] hover:bg-amber-100">
                                <i data-lucide="image" class="w-3 h-3"></i>
                                <span>View Work</span>
                            </a>
                        @endif
                        @if($submission->submission_text)
                            <p class="text-[10px] text-slate-600 mt-0.5 line-clamp-1">{{ $submission->submission_text }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-slate-400 text-[11px]">
                        {{ $submission->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-3">
                        @if($submission->status === 'graded')
                            <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                {{ $submission->grade ?: '⭐ Graded' }} ({{ $submission->score }}/{{ $submission->assignment->points }})
                            </span>
                        @else
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-amber-50 text-amber-700 border border-amber-200/60">
                                ⏳ Needs Review
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <button @click="gradeModalOpen = true; activeSubmission = {{ json_encode([
                            'id' => $submission->id,
                            'student_name' => $submission->user->name,
                            'assignment_title' => $submission->assignment->title,
                            'max_points' => $submission->assignment->points,
                            'current_score' => $submission->score,
                            'current_grade' => $submission->grade,
                            'current_feedback' => $submission->feedback,
                            'action_url' => route('instructor.assignments.grade', $submission->id)
                        ]) }}" 
                                class="px-2.5 py-1 rounded-lg bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-extrabold text-[11px] shadow-xs transition-all inline-flex items-center space-x-1">
                            <i data-lucide="award" class="w-3 h-3"></i>
                            <span>{{ $submission->status === 'graded' ? 'Edit Grade' : 'Grade' }}</span>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                        No student submissions matching criteria found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($submissions->hasPages())
    <div class="p-3.5 border-t border-slate-100">
        {{ $submissions->links() }}
    </div>
@endif
