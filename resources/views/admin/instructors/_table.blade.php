<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50/80 text-[10px] uppercase font-extrabold text-slate-500 border-b border-slate-200/80">
            <tr>
                <th class="px-4 py-3">Instructor</th>
                <th class="px-4 py-3">Headline / Expertise</th>
                <th class="px-4 py-3 text-center">Courses</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($instructors as $instructor)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $instructor->avatar_url }}" class="w-8 h-8 rounded-xl object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                            <div>
                                <a href="{{ route('admin.instructors.show', $instructor->id) }}" class="font-bold text-slate-900 hover:text-rose-600 transition-colors">
                                    {{ $instructor->name }}
                                </a>
                                <span class="block text-[11px] text-slate-400 font-medium">{{ $instructor->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5 text-slate-600 font-medium text-[11px]">
                        {{ $instructor->headline ?: 'Instructor' }}
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 font-bold rounded-lg text-[10px]">
                            {{ $instructor->courses_count }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5">
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md uppercase tracking-wider {{ $instructor->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                            {{ $instructor->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        <div class="flex items-center justify-end space-x-1">
                            <a href="{{ route('admin.instructors.show', $instructor->id) }}" 
                               class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors" 
                               title="View Profile">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </a>
                            <button type="button" 
                                    @click="openEdit({{ json_encode(['id' => $instructor->id, 'name' => $instructor->name, 'email' => $instructor->email, 'headline' => $instructor->headline, 'phone' => $instructor->phone, 'bio' => $instructor->bio, 'status' => $instructor->status]) }})" 
                                    class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" 
                                    title="Quick Edit">
                                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            </button>
                            <form action="{{ route('admin.instructors.destroy', $instructor->id) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Delete this instructor?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" 
                                        title="Delete Instructor">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                        No instructors registered yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($instructors->hasPages())
    <div class="p-3 border-t border-slate-100 text-xs">
        {{ $instructors->links() }}
    </div>
@endif
