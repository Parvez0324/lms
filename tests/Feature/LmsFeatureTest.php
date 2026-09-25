<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LmsFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (User::count() === 0) {
            $this->seed();
        }
    }

    public function test_landing_page_renders_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('KAN');
        $response->assertSee('LMS');
    }

    public function test_language_switch_between_english_and_arabic()
    {
        $responseAr = $this->get('/lang/ar');
        $responseAr->assertRedirect();
        $this->assertEquals('ar', session('locale'));

        $homeAr = $this->get('/');
        $homeAr->assertStatus(200);
        $homeAr->assertSee('dir="rtl"', false);
        $homeAr->assertSee('استكشف الدورات');

        $responseEn = $this->get('/lang/en');
        $responseEn->assertRedirect();
        $this->assertEquals('en', session('locale'));

        $homeEn = $this->get('/');
        $homeEn->assertStatus(200);
        $homeEn->assertSee('dir="ltr"', false);
        $homeEn->assertSee('Explore Courses');
    }

    public function test_login_page_renders_split_screen_with_demo_roles()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Welcome to KAN LMS');
        $response->assertSee('admin@lms.com');
        $response->assertSee('instructor@lms.com');
        $response->assertSee('student@lms.com');
        $response->assertDontSee('Sign in with Google');
        $response->assertDontSee('Sign in with Microsoft');
    }

    public function test_register_page_renders_compact_form()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Create Your Account');
        $response->assertSee('Student');
        $response->assertSee('Instructor');
    }

    public function test_courses_catalog_renders()
    {
        $response = $this->get('/courses');
        $response->assertStatus(200);
        $response->assertSee('Explore Courses');
    }

    public function test_course_show_page_renders()
    {
        $course = Course::first();
        $this->assertNotNull($course, 'Course must exist');
        $response = $this->get('/courses/' . $course->slug);
        $response->assertStatus(200);
        $response->assertSee($course->title);
    }

    public function test_certificate_verification_works()
    {
        $cert = Certificate::first();
        if (!$cert) {
            $student = User::where('role', 'student')->first();
            $course = Course::first();
            $cert = Certificate::create([
                'user_id' => $student->id,
                'course_id' => $course->id,
                'certificate_code' => 'KAN-2026-TEST123',
                'issued_at' => now(),
            ]);
        }
        $this->assertNotNull($cert, 'Certificate must exist');
        $response = $this->get('/verify-certificate/' . $cert->certificate_code);
        $response->assertStatus(200);
        $response->assertSee('Officially Verified Credential');
        $response->assertSee($cert->user->name);
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::where('email', 'admin@lms.com')->first() ?: User::where('role', 'admin')->first();
        $this->assertNotNull($admin, 'Admin must exist');
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Admin');
    }

    public function test_instructor_can_access_instructor_studio()
    {
        $instructor = User::where('email', 'instructor@lms.com')->first() ?: User::where('role', 'instructor')->first();
        $this->assertNotNull($instructor, 'Instructor must exist');
        $response = $this->actingAs($instructor)->get('/instructor/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Instructor');
    }

    public function test_student_can_access_student_dashboard_and_my_courses()
    {
        $student = User::where('email', 'student@lms.com')->first() ?: User::where('role', 'student')->first();
        $this->assertNotNull($student, 'Student must exist');
        $response = $this->actingAs($student)->get('/student/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Welcome');

        $coursesResponse = $this->actingAs($student)->get('/student/my-courses');
        $coursesResponse->assertStatus(200);
        $coursesResponse->assertSee('My Enrolled Courses');
    }

    public function test_student_can_enter_course_classroom_player()
    {
        $student = User::where('email', 'student@lms.com')->first() ?: User::where('role', 'student')->first();
        $course = Course::has('lessons')->first();
        $this->assertNotNull($course, 'Course with lessons must exist');

        \App\Models\Enrollment::firstOrCreate([
            'user_id' => $student->id,
            'course_id' => $course->id,
        ], [
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        $response = $this->actingAs($student)->get('/student/course/' . $course->slug . '/learn');
        $response->assertStatus(200);
        $response->assertSee($course->title);
    }

    public function test_student_can_take_and_submit_quiz()
    {
        $student = User::where('email', 'student@lms.com')->first() ?: User::where('role', 'student')->first();
        $quiz = Quiz::with('questions')->first();
        
        if (!$quiz) {
            $course = Course::first();
            $quiz = Quiz::create([
                'course_id' => $course->id,
                'title' => 'Phonics Challenge',
                'description' => 'Test',
                'time_limit_minutes' => 15,
                'pass_percentage' => 70,
            ]);
            \App\Models\Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => 'Which letter makes Ah sound?',
                'options' => ['A', 'B', 'C'],
                'correct_answer' => '0',
                'points' => 1,
            ]);
            $quiz->load('questions');
        }

        $this->assertNotNull($quiz, 'Quiz must exist');

        $response = $this->actingAs($student)->get('/student/quiz/' . $quiz->id);
        $response->assertStatus(200);
        $response->assertSee($quiz->title);

        $answers = [];
        foreach ($quiz->questions as $q) {
            $answers[$q->id] = $q->correct_answer;
        }

        $submitResponse = $this->actingAs($student)->post('/student/quiz/' . $quiz->id . '/submit', [
            'answers' => $answers,
        ]);
        $submitResponse->assertRedirect();
    }

    public function test_student_can_view_and_submit_assignments()
    {
        $student = User::where('email', 'student@lms.com')->first() ?: User::where('role', 'student')->first();
        $assignment = Assignment::first();
        $this->assertNotNull($assignment, 'Assignment must exist');

        $response = $this->actingAs($student)->get(route('student.assignments.index'));
        $response->assertStatus(200);
        $response->assertSee('My Creative Assignments');

        $submitResponse = $this->actingAs($student)->post(route('student.assignments.submit', $assignment->id), [
            'submission_text' => 'I finished my drawing with bright colors and sunshine!',
        ]);
        $submitResponse->assertRedirect();
    }

    public function test_instructor_and_admin_can_grade_assignments()
    {
        $admin = User::where('email', 'admin@lms.com')->first() ?: User::where('role', 'admin')->first();
        $submission = AssignmentSubmission::first();
        $this->assertNotNull($submission, 'Submission must exist');

        $response = $this->actingAs($admin)->get(route('admin.assignments.index'));
        $response->assertStatus(200);
        $response->assertSee('Assignments', false);
        $response->assertSee('Student Grading', false);

        $gradeResponse = $this->actingAs($admin)->post(route('admin.assignments.grade', $submission->id), [
            'score' => 95,
            'grade' => '⭐⭐⭐ Super Star!',
            'feedback' => 'Wonderful and bright artwork!',
        ]);
        $gradeResponse->assertRedirect();

        $submission->refresh();
        $this->assertEquals(95, $submission->score);
        $this->assertEquals('graded', $submission->status);
    }
}
