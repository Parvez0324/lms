@extends('layouts.admin')

@section('title', 'Payment Receipt - ' . $payment->transaction_id)

@section('admin_content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Payment Receipt</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Transaction Ref: {{ $payment->transaction_id }}</p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back</span>
        </a>
    </div>

    <!-- Printable Receipt Card -->
    <div class="bg-white text-slate-900 rounded-3xl p-8 sm:p-10 shadow-sm border border-slate-200/80">
        
        <div class="flex items-center justify-between pb-6 border-b border-slate-100">
            <div>
                <span class="text-xl font-extrabold tracking-tight text-slate-900">KAN<span class="text-rose-600">LMS</span></span>
                <span class="block text-[10px] uppercase font-bold text-slate-400">Official Payment Receipt</span>
            </div>
            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-lg uppercase">
                {{ $payment->status }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-6 py-6 text-xs border-b border-slate-100">
            <div>
                <span class="text-slate-400 font-semibold block">Billed To:</span>
                <strong class="text-slate-900 text-sm block mt-0.5">{{ $payment->user->name }}</strong>
                <span class="text-slate-500">{{ $payment->user->email }}</span>
            </div>

            <div class="text-right">
                <span class="text-slate-400 font-semibold block">Payment Info:</span>
                <span class="font-mono text-slate-800 font-bold block mt-0.5">{{ $payment->transaction_id }}</span>
                <span class="text-slate-500">{{ $payment->created_at->format('M d, Y - H:i:s') }}</span>
                <span class="text-slate-500 block uppercase">Via {{ $payment->payment_method }}</span>
            </div>
        </div>

        <div class="py-6">
            <table class="w-full text-xs text-left">
                <thead class="text-[10px] font-extrabold uppercase text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="pb-3">Course Item</th>
                        <th class="pb-3 text-right">Price</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-4">
                            <strong class="text-sm font-bold text-slate-900 block">{{ $payment->course->title }}</strong>
                            <span class="text-slate-400 font-medium">Instructor: {{ $payment->course->instructor->name }}</span>
                        </td>
                        <td class="py-4 text-right font-black text-slate-900 text-sm">
                            ${{ number_format($payment->amount, 2) }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="border-t border-slate-200">
                        <td class="pt-4 font-bold text-slate-700">Total Paid:</td>
                        <td class="pt-4 text-right font-black text-emerald-600 text-lg">
                            ${{ number_format($payment->amount, 2) }} USD
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="pt-6 border-t border-slate-100 text-center text-[11px] text-slate-400">
            Thank you for learning with KAN LMS. If you have any billing inquiries, please contact support.
        </div>

    </div>
</div>
@endsection
