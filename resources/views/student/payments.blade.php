@extends('layouts.student')

@section('title', 'Purchase History & Invoices - KAN')

@section('student_content')
<div class="space-y-5 max-w-7xl mx-auto">
    
    <!-- Header Banner -->
    <div class="flex items-center justify-between bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight flex items-center space-x-2">
                <span>🧾</span>
                <span>Purchase History & Receipts</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Review all your past activity enrollments and order invoices</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3">Transaction ID</th>
                        <th class="px-4 py-3">Activity Item</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Payment Method</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 font-mono font-bold text-amber-600 text-[11px]">
                                {{ $payment->transaction_id }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-bold text-slate-900 block">{{ $payment->course->title }}</span>
                                <span class="text-[10px] text-slate-400">Teacher: {{ $payment->course->instructor->name }}</span>
                            </td>
                            <td class="px-4 py-3 font-black text-emerald-600 text-xs">
                                ${{ number_format($payment->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 uppercase font-bold text-[10px] text-slate-500">
                                {{ $payment->payment_method }}
                            </td>
                            <td class="px-4 py-3 text-slate-400 text-[11px]">
                                {{ $payment->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md uppercase tracking-wider {{ $payment->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $payment->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                No purchase transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="p-3.5 border-t border-slate-100">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
