<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificate::with(['user', 'course.instructor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('certificate_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('course', function ($cq) use ($search) {
                      $cq->where('title', 'like', "%{$search}%");
                  });
        }

        $certificates = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax() || $request->has('ajax')) {
            return view('admin.certificates._table', compact('certificates'))->render();
        }

        $students = User::where('role', 'student')->orderBy('name')->get(['id', 'name', 'email']);
        $courses = Course::orderBy('title')->get(['id', 'title']);

        return view('admin.certificates.index', compact('certificates', 'students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $existing = Certificate::where('user_id', $validated['user_id'])
            ->where('course_id', $validated['course_id'])
            ->first();

        if ($existing) {
            return back()->with('info', 'This student already has a certificate for this course (' . $existing->certificate_code . ').');
        }

        $certificate = Certificate::create([
            'user_id' => $validated['user_id'],
            'course_id' => $validated['course_id'],
            'certificate_code' => 'KAN-' . date('Y') . '-' . strtoupper(Str::random(6)),
            'issued_at' => now(),
        ]);

        // Ensure enrollment is marked completed or created
        $enrollment = Enrollment::firstOrCreate(
            ['user_id' => $validated['user_id'], 'course_id' => $validated['course_id']],
            ['status' => 'completed', 'enrolled_at' => now()]
        );
        $enrollment->update(['status' => 'completed', 'completed_at' => now()]);

        return back()->with('success', 'Certificate successfully issued to ' . $certificate->user->name . '! (Code: ' . $certificate->certificate_code . ')');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return back()->with('success', 'Certificate revoked.');
    }
}
