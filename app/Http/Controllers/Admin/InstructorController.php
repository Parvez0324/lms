<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'instructor')->withCount('courses');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('headline', 'like', "%{$search}%");
            });
        }

        $instructors = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax() || $request->has('ajax')) {
            return view('admin.instructors._table', compact('instructors'))->render();
        }

        return view('admin.instructors.index', compact('instructors'));
    }

    public function create()
    {
        return view('admin.instructors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::min(6)],
            'headline' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,banned'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'headline' => $request->headline,
            'bio' => $request->bio,
            'phone' => $request->phone,
            'role' => 'instructor',
            'status' => $request->status,
        ]);

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor onboarded successfully!');
    }

    public function show(User $instructor)
    {
        $instructor->load(['courses.category', 'courses.sections.lessons', 'courses.enrollments']);
        return view('admin.instructors.show', compact('instructor'));
    }

    public function edit(User $instructor)
    {
        return view('admin.instructors.edit', compact('instructor'));
    }

    public function update(Request $request, User $instructor)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $instructor->id],
            'headline' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,banned'],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => Password::min(6)]);
            $data['password'] = Hash::make($request->password);
        }

        $instructor->update($data);

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor profile updated successfully!');
    }

    public function destroy(User $instructor)
    {
        $instructor->delete();
        return redirect()->route('admin.instructors.index')->with('success', 'Instructor account deleted.');
    }
}
