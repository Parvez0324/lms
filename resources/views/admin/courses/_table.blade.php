<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50/80 text-[10px] uppercase font-extrabold text-slate-500 border-b border-slate-200/80">
            <tr>
                <th class="px-4 py-3">Course</th>
                <th class="px-4 py-3">Instructor</th>
                <th class="px-4 py-3">Price</th>
                <th class="px-4 py-3 text-center">Enrollments</th>
                <th class="px-4 py-3">Featured</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($courses as $course)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $course->thumbnail_url }}" class="w-12 h-8 rounded-xl object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                            <div>
                                <a href="{{ route('admin.courses.show', $course->id) }}" class="font-bold text-slate-900 hover:text-rose-600 transition-colors block leading-tight">
                                    {{ $course->title }}
                                </a>
                                <span class="block text-[10px] text-slate-400 font-medium">{{ $course->category->name ?? 'Uncategorized' }} • {{ $course->sections_count }} sections</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5">
                        <div class="flex items-center space-x-2">
                            <img src="{{ $course->instructor->avatar_url }}" class="w-6 h-6 rounded-lg object-cover ring-1 ring-slate-200" alt="">
                            <span class="text-slate-800 font-semibold text-[11px]">{{ $course->instructor->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-2.5 font-bold text-slate-900">
                        {{ $course->is_free ? 'FREE' : '$' . number_format($course->effective_price, 2) }}
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        <span class="px-2 py-0.5 bg-amber-50 text-amber-700 font-bold rounded-lg text-[10px]">
                            {{ $course->enrollments_count }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5">
                        <form action="{{ route('admin.courses.toggleFeatured', $course->id) }}" method="POST" class="inline-block m-0 p-0">
                            @csrf
                            <button type="submit" class="px-2 py-0.5 text-[10px] font-bold rounded-md transition-colors {{ $course->is_featured ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                {{ $course->is_featured ? '★ Featured' : 'Normal' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-2.5">
                        <form action="{{ route('admin.courses.togglePublish', $course->id) }}" method="POST" class="inline-block m-0 p-0">
                            @csrf
                            <button type="submit" class="px-2 py-0.5 text-[10px] font-bold rounded-md uppercase tracking-wider transition-colors {{ $course->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                {{ $course->status }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        <div class="flex items-center justify-end space-x-1">
                            <a href="{{ route('courses.show', $course->slug) }}" target="_blank" 
                               class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors" 
                               title="Preview Public Page">
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                            <a href="{{ route('admin.courses.show', $course->id) }}" 
                               class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors" 
                               title="Inspect Course">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </a>
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Are you sure you want to permanently delete this course?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" 
                                        title="Delete Course">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                        No courses found matching your criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($courses->hasPages())
    <div class="p-3 border-t border-slate-100 text-xs">
        {{ $courses->links() }}
    </div>
@endif
