<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')->withCount('enrollments');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax() || $request->has('ajax')) {
            return view('admin.students._table', compact('students'))->render();
        }

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::min(6)],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,banned'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'student',
            'status' => $request->status,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully!');
    }

    public function show(User $student)
    {
        $student->load(['enrollments.course', 'quizAttempts.quiz', 'certificates.course', 'payments.course']);
        return view('admin.students.show', compact('student'));
    }

    public function edit(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $student->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,banned'],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => Password::min(6)]);
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }

    public function toggleStatus(User $student)
    {
        $student->status = $student->status === 'active' ? 'banned' : 'active';
        $student->save();

        return back()->with('success', 'Student status updated to ' . $student->status);
    }
}
