<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EnrollmentCheckoutController extends Controller
{
    public function enroll(Course $course)
    {
        $user = Auth::user();

        if ($user->isEnrolledIn($course->id)) {
            return redirect()->route('student.course.learn', $course->slug)->with('info', 'You are already enrolled in this course.');
        }

        if (!$course->is_free) {
            return redirect()->route('student.course.checkout', $course->slug);
        }

        // Free Course Enrollment
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        return redirect()->route('student.course.learn', $course->slug)->with('success', 'Enrolled successfully! Happy learning.');
    }

    public function showCheckout(Course $course)
    {
        $user = Auth::user();

        if ($user->isEnrolledIn($course->id)) {
            return redirect()->route('student.course.learn', $course->slug)->with('info', 'You already own this course.');
        }

        return view('student.checkout', compact('course'));
    }

    public function processPayment(Request $request, Course $course)
    {
        $user = Auth::user();

        if ($user->isEnrolledIn($course->id)) {
            return redirect()->route('student.course.learn', $course->slug)->with('info', 'You already own this course.');
        }

        $request->validate([
            'payment_method' => ['required', 'in:card,paypal,mock,stripe'],
            'card_name' => ['nullable', 'string', 'max:255'],
            'card_number' => ['nullable', 'string', 'max:30'],
        ]);

        $transactionId = 'TXN-' . strtoupper(Str::random(10));
        $amount = $course->effective_price;

        // Record payment
        $payment = Payment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'transaction_id' => $transactionId,
            'amount' => $amount,
            'currency' => 'USD',
            'payment_method' => $request->payment_method,
            'status' => 'completed',
            'payload' => [
                'payer_name' => $request->card_name ?: $user->name,
                'gateway' => $request->payment_method,
                'ip' => $request->ip(),
            ],
        ]);

        // Activate Enrollment
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        return redirect()->route('student.course.learn', $course->slug)->with('success', 'Payment of $' . number_format($amount, 2) . ' successful! Welcome to the course.');
    }

    public function payments()
    {
        $payments = Auth::user()->payments()->with('course.instructor')->latest()->paginate(10);
        return view('student.payments', compact('payments'));
    }
}
