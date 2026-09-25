@extends('layouts.app')

@section('title', 'Checkout - ' . $course->title)

@section('content')
<div class="bg-slate-50 min-h-[85vh] py-12" x-data="{ paymentMethod: 'card' }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 text-center sm:text-left">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Complete Your Enrollment</h1>
            <p class="text-sm text-slate-500 mt-1">Review your order details and select a secure payment method</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Payment Form -->
            <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
                
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 flex items-center">
                    <i data-lucide="credit-card" class="w-4 h-4 mr-2 text-brand-600"></i>
                    Payment Method
                </h3>

                <!-- Method Picker -->
                <div class="grid grid-cols-3 gap-3">
                    <label @click="paymentMethod = 'card'" 
                           :class="paymentMethod === 'card' ? 'border-brand-600 bg-brand-50/70 text-brand-900 font-bold ring-2 ring-brand-500/20' : 'border-slate-200 text-slate-700'"
                           class="flex flex-col items-center justify-center p-3.5 border rounded-2xl cursor-pointer text-xs transition-all text-center">
                        <input type="radio" name="method_select" value="card" x-model="paymentMethod" class="sr-only">
                        <i data-lucide="credit-card" class="w-5 h-5 text-brand-600 mb-1"></i>
                        <span>Credit / Debit</span>
                    </label>

                    <label @click="paymentMethod = 'paypal'" 
                           :class="paymentMethod === 'paypal' ? 'border-blue-600 bg-blue-50/70 text-blue-900 font-bold ring-2 ring-blue-500/20' : 'border-slate-200 text-slate-700'"
                           class="flex flex-col items-center justify-center p-3.5 border rounded-2xl cursor-pointer text-xs transition-all text-center">
                        <input type="radio" name="method_select" value="paypal" x-model="paymentMethod" class="sr-only">
                        <i data-lucide="wallet" class="w-5 h-5 text-blue-600 mb-1"></i>
                        <span>PayPal</span>
                    </label>

                    <label @click="paymentMethod = 'mock'" 
                           :class="paymentMethod === 'mock' ? 'border-emerald-600 bg-emerald-50/70 text-emerald-900 font-bold ring-2 ring-emerald-500/20' : 'border-slate-200 text-slate-700'"
                           class="flex flex-col items-center justify-center p-3.5 border rounded-2xl cursor-pointer text-xs transition-all text-center">
                        <input type="radio" name="method_select" value="mock" x-model="paymentMethod" class="sr-only">
                        <i data-lucide="zap" class="w-5 h-5 text-emerald-600 mb-1"></i>
                        <span>Instant 1-Click</span>
                    </label>
                </div>

                <!-- Form -->
                <form action="{{ route('student.course.payment', $course->slug) }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="payment_method" :value="paymentMethod">

                    <!-- Credit Card input fields -->
                    <div x-show="paymentMethod === 'card'" class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Cardholder Name</label>
                            <input type="text" name="card_name" value="{{ Auth::user()->name }}" 
                                   placeholder="John Doe" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-brand-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Card Number</label>
                            <input type="text" name="card_number" placeholder="4242 •••• •••• 4242" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-brand-500 font-mono">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Expiry Date</label>
                                <input type="text" placeholder="MM/YY" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-brand-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">CVC / CVV</label>
                                <input type="password" placeholder="•••" maxlength="4" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-brand-500">
                            </div>
                        </div>
                    </div>

                    <!-- PayPal info -->
                    <div x-show="paymentMethod === 'paypal'" style="display: none;" class="p-4 bg-blue-50 border border-blue-100 rounded-2xl text-xs text-blue-800 space-y-1">
                        <div class="font-bold flex items-center"><i data-lucide="wallet" class="w-4 h-4 mr-1"></i> PayPal Express Checkout</div>
                        <p class="text-[11px] text-blue-600">You will be securely billed ${{ number_format($course->effective_price, 2) }} via PayPal sandbox simulator.</p>
                    </div>

                    <!-- Instant Simulation info -->
                    <div x-show="paymentMethod === 'mock'" style="display: none;" class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-xs text-emerald-800 space-y-1">
                        <div class="font-bold flex items-center"><i data-lucide="zap" class="w-4 h-4 mr-1"></i> Instant Demo Payment</div>
                        <p class="text-[11px] text-emerald-600">Simulates an approved banking transaction instantly and generates a digital receipt.</p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-brand-500/25 transition-all flex items-center justify-center space-x-2">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                            <span>Pay ${{ number_format($course->effective_price, 2) }} & Complete Enrollment</span>
                        </button>
                    </div>
                </form>

                <div class="flex items-center justify-center space-x-2 text-[11px] text-slate-400">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i>
                    <span>256-Bit SSL Encrypted & Secure Checkout</span>
                </div>

            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-5 bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-sm space-y-5">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Order Summary</h3>

                <div class="flex items-start space-x-3.5 pb-4 border-b border-slate-100">
                    <img src="{{ $course->thumbnail_url }}" class="w-16 h-12 rounded-xl object-cover ring-1 ring-slate-200" alt="">
                    <div>
                        <h4 class="font-bold text-xs text-slate-900 line-clamp-2">{{ $course->title }}</h4>
                        <span class="text-[10px] text-slate-400 block mt-0.5">By {{ $course->instructor->name }}</span>
                    </div>
                </div>

                <div class="space-y-2 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span>Original Price</span>
                        <span class="font-semibold">${{ number_format($course->price, 2) }}</span>
                    </div>

                    @if($course->discount_price && $course->discount_price < $course->price)
                        <div class="flex justify-between text-emerald-600 font-bold">
                            <span>Promotional Discount</span>
                            <span>-${{ number_format($course->price - $course->discount_price, 2) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-slate-500">
                        <span>Tax</span>
                        <span>$0.00</span>
                    </div>

                    <div class="flex justify-between pt-3 border-t border-slate-100 text-sm font-black text-slate-900">
                        <span>Total Due</span>
                        <span class="text-emerald-600">${{ number_format($course->effective_price, 2) }}</span>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 text-[11px] text-slate-500 space-y-1">
                    <div class="font-bold text-slate-700">Course Perks:</div>
                    <div>✓ Lifetime access to lectures</div>
                    <div>✓ Downloadable resources & PDFs</div>
                    <div>✓ Official Certificate of Completion</div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
