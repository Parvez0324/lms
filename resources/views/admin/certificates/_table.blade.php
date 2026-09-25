<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50/80 text-[10px] uppercase font-extrabold text-slate-500 border-b border-slate-200/80">
            <tr>
                <th class="px-4 py-3">Certificate Code</th>
                <th class="px-4 py-3">Student</th>
                <th class="px-4 py-3">Course Completed</th>
                <th class="px-4 py-3">Issue Date</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($certificates as $cert)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-4 py-2.5 font-mono font-bold text-purple-700 text-xs">
                        {{ $cert->certificate_code }}
                    </td>
                    <td class="px-4 py-2.5">
                        <div class="flex items-center space-x-2.5">
                            <img src="{{ $cert->user->avatar_url }}" class="w-7 h-7 rounded-xl object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                            <div>
                                <span class="font-bold text-slate-900 block leading-tight">{{ $cert->user->name }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $cert->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5 font-bold text-slate-900">
                        {{ $cert->course->title }}
                    </td>
                    <td class="px-4 py-2.5 text-slate-500 font-medium text-[11px]">
                        {{ $cert->issued_at ? $cert->issued_at->format('M d, Y') : $cert->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        <div class="flex items-center justify-end space-x-1">
                            <a href="{{ route('certificate.verify', ['code' => $cert->certificate_code]) }}" target="_blank" 
                               class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors" 
                               title="Verify Online">
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                            <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Revoke this certificate?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" 
                                        title="Revoke Certificate">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                        No certificates issued yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($certificates->hasPages())
    <div class="p-3 border-t border-slate-100 text-xs">
        {{ $certificates->links() }}
    </div>
@endif
