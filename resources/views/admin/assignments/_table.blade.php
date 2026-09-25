<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-700">
        <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-100">
            <tr>
                <th class="px-5 py-3.5">Student</th>
                <th class="px-5 py-3.5">Activity & Course</th>
                <th class="px-5 py-3.5">Submission / Artwork</th>
                <th class="px-5 py-3.5">Date</th>
                <th class="px-5 py-3.5">Grade / Stars</th>
                <th class="px-5 py-3.5 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($submissions as $submission)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $submission->user->avatar_url }}" class="w-8 h-8 rounded-xl object-cover ring-1 ring-slate-200" alt="">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $submission->user->name }}</span>
                                <span class="text-[11px] text-slate-400">{{ $submission->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="font-bold text-slate-900 block">{{ $submission->assignment->title }}</span>
                        <span class="text-[11px] text-amber-600 font-semibold">{{ $submission->assignment->course->title }}</span>
                    </td>
                    <td class="px-5 py-4">
                        @if($submission->file_path)
                            <a href="{{ $submission->file_url }}" target="_blank" class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 font-bold text-[11px] hover:bg-amber-100 transition-colors">
                                <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                <span>View Attachment</span>
                            </a>
                        @endif
                        @if($submission->submission_text)
                            <p class="text-[11px] text-slate-600 mt-1 line-clamp-2">{{ $submission->submission_text }}</p>
                        @endif
                        @if(!$submission->file_path && !$submission->submission_text)
                            <span class="text-slate-400 italic text-[11px]">No content attached</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-slate-400">
                        {{ $submission->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-5 py-4">
                        @if($submission->status === 'graded')
                            <div class="space-y-0.5">
                                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-md bg-emerald-50 text-emerald-700">
                                    {{ $submission->grade ?: '⭐ Graded' }} ({{ $submission->score }}/{{ $submission->assignment->points }})
                                </span>
                                @if($submission->feedback)
                                    <p class="text-[10px] text-slate-500 italic truncate max-w-xs">"{{ $submission->feedback }}"</p>
                                @endif
                            </div>
                        @else
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-amber-50 text-amber-700">
                                ⏳ Pending Review
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-right">
                        <button @click="gradeModalOpen = true; activeSubmission = {{ json_encode([
                            'id' => $submission->id,
                            'student_name' => $submission->user->name,
                            'assignment_title' => $submission->assignment->title,
                            'max_points' => $submission->assignment->points,
                            'current_score' => $submission->score,
                            'current_grade' => $submission->grade,
                            'current_feedback' => $submission->feedback,
                            'action_url' => route('admin.assignments.grade', $submission->id)
                        ]) }}" 
                                class="px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-[11px] shadow-sm transition-all inline-flex items-center space-x-1">
                            <i data-lucide="award" class="w-3.5 h-3.5"></i>
                            <span>{{ $submission->status === 'graded' ? 'Edit Grade' : 'Grade & Award' }}</span>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                        No activity submissions found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($submissions->hasPages())
    <div class="p-4 border-t border-slate-100">
        {{ $submissions->links() }}
    </div>
@endif
