<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'course']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        if ($request->ajax() || $request->has('ajax')) {
            return view('admin.payments._table', compact('payments'))->render();
        }

        return view('admin.payments.index', compact('payments', 'totalRevenue'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'course.instructor']);
        return view('admin.payments.show', compact('payment'));
    }
}
