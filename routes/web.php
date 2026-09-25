<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\InstructorController as AdminInstructorController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Instructor\LessonController as InstructorLessonController;
use App\Http\Controllers\Instructor\QuizController as InstructorQuizController;
use App\Http\Controllers\Instructor\SectionController as InstructorSectionController;
use App\Http\Controllers\Instructor\StudentProgressController as InstructorStudentProgressController;

use App\Http\Controllers\Student\CertificateController as StudentCertificateController;
use App\Http\Controllers\Student\CoursePlayerController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\EnrollmentCheckoutController;
use App\Http\Controllers\Student\QuizEngineController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'welcome'])->name('home');
Route::get('/courses', [HomeController::class, 'indexCourses'])->name('courses.index');
Route::get('/courses/{slug}', [HomeController::class, 'showCourse'])->name('courses.show');
Route::get('/verify-certificate/{code?}', [HomeController::class, 'verifyCertificate'])->name('certificate.verify');
Route::get('/lang/{locale}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Admin Portal Routes (Role: admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Students
    Route::resource('students', AdminStudentController::class);
    Route::post('students/{student}/toggle-status', [AdminStudentController::class, 'toggleStatus'])->name('students.toggleStatus');

    // Instructors
    Route::resource('instructors', AdminInstructorController::class);

    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'show', 'edit']);

    // Courses Oversight
    Route::resource('courses', AdminCourseController::class)->only(['index', 'show', 'destroy']);
    Route::post('courses/{course}/toggle-publish', [AdminCourseController::class, 'togglePublish'])->name('courses.togglePublish');
    Route::post('courses/{course}/toggle-featured', [AdminCourseController::class, 'toggleFeatured'])->name('courses.toggleFeatured');

    // Lessons & Media
    Route::get('lessons', [AdminLessonController::class, 'index'])->name('lessons.index');

    // Enrollments
    Route::resource('enrollments', AdminEnrollmentController::class)->only(['index', 'create', 'store', 'destroy']);

    // Payments
    Route::resource('payments', AdminPaymentController::class)->only(['index', 'show']);

    // Quizzes & Assessment Bank
    Route::resource('quizzes', AdminQuizController::class)->only(['index', 'show']);

    // Certificates
    Route::resource('certificates', AdminCertificateController::class)->only(['index', 'store', 'destroy']);

    // Assignments & Student Grading
    Route::get('assignments', [\App\Http\Controllers\Admin\AdminAssignmentController::class, 'index'])->name('assignments.index');
    Route::post('assignments', [\App\Http\Controllers\Admin\AdminAssignmentController::class, 'store'])->name('assignments.store');
    Route::post('assignments/submissions/{submission}/grade', [\App\Http\Controllers\Admin\AdminAssignmentController::class, 'grade'])->name('assignments.grade');
    Route::delete('assignments/{assignment}', [\App\Http\Controllers\Admin\AdminAssignmentController::class, 'destroy'])->name('assignments.destroy');

    // Reports & Analytics
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
});

/*
|--------------------------------------------------------------------------
| Instructor Portal Routes (Role: instructor, admin)
|--------------------------------------------------------------------------
*/
Route::prefix('instructor')->name('instructor.')->middleware(['auth', 'role:instructor,admin'])->group(function () {
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');

    // Course Management & Curriculum Builder
    Route::resource('courses', InstructorCourseController::class);

    // Section Management
    Route::post('courses/{course}/sections', [InstructorSectionController::class, 'store'])->name('sections.store');
    Route::put('sections/{section}', [InstructorSectionController::class, 'update'])->name('sections.update');
    Route::delete('sections/{section}', [InstructorSectionController::class, 'destroy'])->name('sections.destroy');

    // Lesson Management
    Route::get('sections/{section}/lessons/create', [InstructorLessonController::class, 'create'])->name('lessons.create');
    Route::post('sections/{section}/lessons', [InstructorLessonController::class, 'store'])->name('lessons.store');
    Route::get('lessons/{lesson}/edit', [InstructorLessonController::class, 'edit'])->name('lessons.edit');
    Route::put('lessons/{lesson}', [InstructorLessonController::class, 'update'])->name('lessons.update');
    Route::delete('lessons/{lesson}', [InstructorLessonController::class, 'destroy'])->name('lessons.destroy');

    // Quiz & Questions Management
    Route::get('quizzes', [InstructorQuizController::class, 'index'])->name('quizzes.index');
    Route::get('courses/{course}/quizzes/create', [InstructorQuizController::class, 'create'])->name('quizzes.create');
    Route::post('courses/{course}/quizzes', [InstructorQuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}/edit', [InstructorQuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('quizzes/{quiz}', [InstructorQuizController::class, 'update'])->name('quizzes.update');
    Route::delete('quizzes/{quiz}', [InstructorQuizController::class, 'destroy'])->name('quizzes.destroy');

    Route::get('quizzes/{quiz}/questions', [InstructorQuizController::class, 'manageQuestions'])->name('quizzes.questions');
    Route::post('quizzes/{quiz}/questions', [InstructorQuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::delete('questions/{question}', [InstructorQuizController::class, 'deleteQuestion'])->name('quizzes.questions.destroy');

    // Assignments & Grading
    Route::get('assignments', [\App\Http\Controllers\Instructor\InstructorAssignmentController::class, 'index'])->name('assignments.index');
    Route::post('assignments', [\App\Http\Controllers\Instructor\InstructorAssignmentController::class, 'store'])->name('assignments.store');
    Route::post('assignments/submissions/{submission}/grade', [\App\Http\Controllers\Instructor\InstructorAssignmentController::class, 'grade'])->name('assignments.grade');

    // Student Progress Tracking
    Route::get('students', [InstructorStudentProgressController::class, 'index'])->name('students.index');
});

/*
|--------------------------------------------------------------------------
| Student Portal & Learning Experience Routes
|--------------------------------------------------------------------------
*/
Route::prefix('student')->name('student.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-courses', [StudentDashboardController::class, 'myCourses'])->name('my-courses');
    Route::get('/payments', [EnrollmentCheckoutController::class, 'payments'])->name('payments');

    // Assignments
    Route::get('/assignments', [\App\Http\Controllers\Student\StudentAssignmentController::class, 'index'])->name('assignments.index');
    Route::post('/assignments/{assignment}/submit', [\App\Http\Controllers\Student\StudentAssignmentController::class, 'submit'])->name('assignments.submit');

    // Course Enrollment & Payment
    Route::post('/course/{course:slug}/enroll', [EnrollmentCheckoutController::class, 'enroll'])->name('course.enroll');
    Route::get('/course/{course:slug}/checkout', [EnrollmentCheckoutController::class, 'showCheckout'])->name('course.checkout');
    Route::post('/course/{course:slug}/payment', [EnrollmentCheckoutController::class, 'processPayment'])->name('course.payment');

    // Classroom Course Player
    Route::get('/course/{course:slug}/learn', [CoursePlayerController::class, 'learn'])->name('course.learn');
    Route::get('/course/{course:slug}/lesson/{lesson:slug}', [CoursePlayerController::class, 'learn'])->name('course.lesson');
    Route::post('/lesson/{lesson}/complete', [CoursePlayerController::class, 'toggleComplete'])->name('lesson.complete');

    // Quizzes
    Route::get('/quiz/{quiz}', [QuizEngineController::class, 'showQuiz'])->name('quiz.show');
    Route::post('/quiz/{quiz}/submit', [QuizEngineController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/quiz/result/{attempt}', [QuizEngineController::class, 'quizResult'])->name('quiz.result');

    // Certificate
    Route::get('/course/{course:slug}/certificate', [StudentCertificateController::class, 'show'])->name('course.certificate');
});
