<div class="overflow-x-auto">
    <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50/80 text-[10px] uppercase font-extrabold text-slate-500 border-b border-slate-200/80">
            <tr>
                <th class="px-4 py-3">Transaction ID</th>
                <th class="px-4 py-3">Student</th>
                <th class="px-4 py-3">Course Purchased</th>
                <th class="px-4 py-3">Amount</th>
                <th class="px-4 py-3">Method</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Receipt</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($payments as $payment)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-4 py-2.5 font-mono font-bold text-rose-600 text-[11px]">
                        {{ $payment->transaction_id }}
                    </td>
                    <td class="px-4 py-2.5">
                        <div class="flex items-center space-x-2.5">
                            <img src="{{ $payment->user->avatar_url }}" class="w-7 h-7 rounded-xl object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                            <div>
                                <span class="font-bold text-slate-900 block leading-tight">{{ $payment->user->name }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $payment->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5 font-bold text-slate-900">
                        {{ $payment->course->title }}
                    </td>
                    <td class="px-4 py-2.5 font-black text-emerald-600 text-xs">
                        ${{ number_format($payment->amount, 2) }}
                    </td>
                    <td class="px-4 py-2.5 uppercase font-extrabold text-[10px] text-slate-400">
                        {{ $payment->payment_method }}
                    </td>
                    <td class="px-4 py-2.5 text-slate-500 font-medium text-[11px]">
                        {{ $payment->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-4 py-2.5">
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md uppercase tracking-wider {{ $payment->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                            {{ $payment->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.payments.show', $payment->id) }}" 
                               class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors" 
                               title="View Receipt">
                                <i data-lucide="receipt" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-slate-400">
                        No payment logs recorded.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($payments->hasPages())
    <div class="p-3 border-t border-slate-100 text-xs">
        {{ $payments->links() }}
    </div>
@endif
