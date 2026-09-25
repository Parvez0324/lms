<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-700">
        <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-100">
            <tr>
                <th class="px-4 py-2.5">Course</th>
                <th class="px-4 py-2.5">Category</th>
                <th class="px-4 py-2.5">Price</th>
                <th class="px-4 py-2.5 text-center">Sections / Lessons</th>
                <th class="px-4 py-2.5 text-center">Students</th>
                <th class="px-4 py-2.5">Status</th>
                <th class="px-4 py-2.5 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($courses as $course)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center space-x-2.5">
                            <img src="{{ $course->thumbnail_url }}" class="w-10 h-7 rounded-lg object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                            <div>
                                <a href="{{ route('instructor.courses.show', $course->id) }}" class="font-semibold text-slate-900 hover:text-brand-600 block text-xs">
                                    {{ $course->title }}
                                </a>
                                <span class="text-[10px] text-slate-400 capitalize">{{ str_replace('_', ' ', $course->level) }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5 font-medium text-slate-600">
                        {{ $course->category->name ?? 'General' }}
                    </td>
                    <td class="px-4 py-2.5 font-bold text-slate-900">
                        {{ $course->is_free ? 'FREE' : '$' . number_format($course->effective_price, 2) }}
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        <span class="px-2 py-0.5 bg-brand-50 text-brand-700 font-semibold rounded text-[10px]">
                            {{ $course->sections_count }} sections • {{ $course->total_lessons_count }} lessons
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-center font-bold text-slate-800">
                        {{ $course->enrollments_count }}
                    </td>
                    <td class="px-4 py-2.5">
                        <span class="px-2 py-0.5 text-[9px] font-semibold rounded uppercase tracking-wider {{ $course->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $course->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        <div class="flex items-center justify-end space-x-1">
                            <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors" title="View Landing Page">
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                            <a href="{{ route('instructor.courses.show', $course->id) }}" class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-brand-600 hover:bg-slate-100 rounded-lg transition-colors" title="Curriculum Builder">
                                <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                            </a>
                            <a href="{{ route('instructor.courses.edit', $course->id) }}" class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-brand-600 hover:bg-slate-100 rounded-lg transition-colors" title="Edit Course Info">
                                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            </a>
                            <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Delete this course?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" title="Delete Course">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                        No courses found matching criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($courses->hasPages())
    <div class="p-4 border-t border-slate-100">
        {{ $courses->links() }}
    </div>
@endif
