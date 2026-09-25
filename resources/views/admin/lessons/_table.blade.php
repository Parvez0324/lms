<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50/80 text-[10px] uppercase font-extrabold text-slate-500 border-b border-slate-200/80">
            <tr>
                <th class="px-5 py-4">Lesson Title</th>
                <th class="px-5 py-4">Course & Section</th>
                <th class="px-5 py-4">Type</th>
                <th class="px-5 py-4">Duration</th>
                <th class="px-5 py-4">Preview Allowed</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($lessons as $lesson)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-4 font-bold text-slate-900">
                        <div class="flex items-center space-x-2.5">
                            @if($lesson->content_type === 'video')
                                <div class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="play-circle" class="w-4 h-4"></i>
                                </div>
                            @elseif($lesson->content_type === 'pdf')
                                <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                            @else
                                <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="book" class="w-4 h-4"></i>
                                </div>
                            @endif
                            <span>{{ $lesson->title }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-slate-900 font-bold block">{{ $lesson->section->course->title ?? 'None' }}</span>
                        <span class="text-[11px] text-slate-400 font-medium">Section: {{ $lesson->section->title ?? 'None' }}</span>
                    </td>
                    <td class="px-5 py-4 uppercase font-extrabold text-[10px] text-slate-500">
                        {{ $lesson->content_type }}
                    </td>
                    <td class="px-5 py-4 text-slate-600 font-medium">
                        {{ $lesson->duration_minutes }} mins
                    </td>
                    <td class="px-5 py-4">
                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg {{ $lesson->is_preview ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                            {{ $lesson->is_preview ? 'Free Preview' : 'Locked' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-slate-400">
                        No lessons found matching criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($lessons->hasPages())
    <div class="p-4 border-t border-slate-100">
        {{ $lessons->links() }}
    </div>
@endif
