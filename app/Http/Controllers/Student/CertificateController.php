<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function show(Course $course)
    {
        $user = Auth::user();

        // Verify if certificate already exists
        $certificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->with(['user', 'course.instructor'])
            ->first();

        if (!$certificate) {
            $progress = $course->getStudentProgressPercentage($user->id);

            if ($progress < 100 && !Auth::user()->isAdmin()) {
                return redirect()->route('student.course.learn', $course->slug)->with('error', 'You must complete 100% of the course lectures to claim your certificate.');
            }

            // Generate Certificate
            $certificate = Certificate::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'certificate_code' => 'LMS-' . date('Y') . '-' . strtoupper(Str::random(6)),
                'issued_at' => now(),
            ]);

            Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->update(['status' => 'completed', 'completed_at' => now()]);
        }

        return view('student.certificate', compact('certificate', 'course'));
    }
}
