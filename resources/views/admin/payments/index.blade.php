@extends('layouts.admin')

@section('title', 'Manage Payments & Sales')

@section('admin_content')
<div class="space-y-3.5 max-w-7xl mx-auto font-sans"
     x-data="{
        searchQuery: '{{ request('search') }}',
        statusFilter: '{{ request('status') }}',
        loading: false,
        async fetchPayments() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.statusFilter) params.append('status', this.statusFilter);
                params.append('ajax', '1');

                const response = await fetch('{{ route('admin.payments.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('payments-table-container').innerHTML = html;
                if (window.lucide) {
                    lucide.createIcons();
                }
            } catch (e) {
                console.error('AJAX search error:', e);
            } finally {
                this.loading = false;
            }
        }
     }">
    
    <!-- Header with Revenue Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5">
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Payment Transactions</h1>
            <p class="text-xs text-slate-500 mt-0.5">Audit platform revenue, transaction receipts, and checkout logs</p>
        </div>

        <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-200/80 shadow-2xs flex items-center space-x-2.5 self-start sm:self-auto">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="dollar-sign" class="w-3.5 h-3.5"></i>
            </div>
            <div>
                <span class="text-[9px] uppercase font-semibold text-slate-400">Total Processed</span>
                <div class="text-sm font-bold text-emerald-600">${{ number_format($totalRevenue, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Filters with AJAX -->
    <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row gap-2.5 items-center justify-between">
        <div class="flex flex-1 gap-2.5 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchPayments()" placeholder="Live search by transaction ID, student name, or email..." 
                       class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
            </div>

            <select x-model="statusFilter" @change="fetchPayments()" 
                    class="bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 py-1.5 pl-3 pr-8 focus:bg-white focus:border-rose-500">
                <option value="">All Statuses</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="refunded">Refunded</option>
            </select>
        </div>
    </div>

    <!-- Table with Dynamic AJAX Loading Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm relative">
        <div x-show="loading" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] flex items-center justify-center z-10 transition-opacity" style="display: none;">
            <div class="flex items-center space-x-2 text-rose-600 font-bold text-xs">
                <div class="w-4 h-4 border-2 border-rose-600 border-t-transparent rounded-full animate-spin"></div>
                <span>Filtering...</span>
            </div>
        </div>

        <div id="payments-table-container">
            @include('admin.payments._table')
        </div>
    </div>
</div>
@endsection
