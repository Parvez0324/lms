<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50/80 text-[10px] uppercase font-extrabold text-slate-500 border-b border-slate-200/80">
            <tr>
                <th class="px-4 py-3">Quiz Title</th>
                <th class="px-4 py-3">Course</th>
                <th class="px-4 py-3 text-center">Questions</th>
                <th class="px-4 py-3">Pass Percentage</th>
                <th class="px-4 py-3">Time Limit</th>
                <th class="px-4 py-3 text-center">Attempts</th>
                <th class="px-4 py-3 text-right">Inspect</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($quizzes as $quiz)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-4 py-2.5 font-bold text-slate-900">
                        <a href="{{ route('admin.quizzes.show', $quiz->id) }}" class="hover:text-rose-600 transition-colors">
                            {{ $quiz->title }}
                        </a>
                    </td>
                    <td class="px-4 py-2.5 text-slate-600 font-medium">
                        {{ $quiz->course->title }}
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        <span class="px-2 py-0.5 bg-purple-50 text-purple-700 font-bold rounded-lg text-[10px]">
                            {{ $quiz->questions_count }} Qs
                        </span>
                    </td>
                    <td class="px-4 py-2.5 font-bold text-emerald-600">
                        {{ $quiz->pass_percentage }}%
                    </td>
                    <td class="px-4 py-2.5 text-slate-500">
                        {{ $quiz->time_limit_minutes }} mins
                    </td>
                    <td class="px-4 py-2.5 text-center font-bold text-slate-800">
                        {{ $quiz->attempts_count }}
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.quizzes.show', $quiz->id) }}" 
                               class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors" 
                               title="Inspect Quiz">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                        No quizzes found matching criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($quizzes->hasPages())
    <div class="p-3 border-t border-slate-100 text-xs">
        {{ $quizzes->links() }}
    </div>
@endif
