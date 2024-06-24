<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StudentEnrollmentController;
use App\Http\Controllers\TeacherAuth\TLoginController;
use App\Http\Controllers\AdminAuth\AdminAuthController;
use App\Http\Controllers\TeacherAuth\TRegisterController;
use App\Http\Controllers\StudentAuth\LoginController as StudentLoginController;
use App\Http\Controllers\StudentAuth\RegisterController as StudentRegisterController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Student routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('register', [StudentRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [StudentRegisterController::class, 'register']);
    Route::get('login', [StudentLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [StudentLoginController::class, 'login']);
    Route::post('logout', [StudentLoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth:student'])->group(function () {
        Route::get('home', [HomeController::class, 'studentHome'])->name('home');
        Route::get('subject-search', [SubjectController::class, 'showSearchForm'])->name('subject.search');
        Route::get('subject-search/results', [SubjectController::class, 'searchResults'])->name('subject.search.results');
        Route::post('/enroll', [StudentEnrollmentController::class, 'enroll'])->name('subject.enroll');
        Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::post('/student/subject/leave', [HomeController::class, 'leaveSubject'])->name('subject.leave');

    });
});

// Teacher routes
Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('register', [TRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [TRegisterController::class, 'register']);
    Route::get('login', [TLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [TLoginController::class, 'login']);
    Route::post('logout', [TLoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth:teacher'])->group(function () {
        Route::get('home', [HomeController::class, 'teacherHome'])->name('home');
        Route::resource('subjects', SubjectController::class);
        Route::get('subjects/{subject}/students', [SubjectController::class, 'students'])->name('subjects.students');
        Route::post('dismissApprovalMessage', [HomeController::class, 'dismissApprovalMessage'])->name('dismissApprovalMessage');

        //subject creation routes
        Route::get('subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
        Route::get('subjects', [SubjectController::class, 'index'])->name('subjects.list');
        Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::get('subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');

        //student management routes
        Route::get('/students', [StudentEnrollmentController::class, 'manageStudents'])->name('students.index');
        Route::get('/student-management', [StudentEnrollmentController::class, 'manageStudents'])->name('student.management');
        Route::post('/subjects/{subject}/students/{student}/approve', [StudentEnrollmentController::class, 'approveStudent'])->name('students.approve');
        Route::post('/subjects/{subject}/students/{student}/reject', [StudentEnrollmentController::class, 'rejectStudent'])->name('students.reject');

        //view student enrolled page routes
        Route::get('/view-students/{subject?}', [SubjectController::class, 'viewStudents'])->name('view.students');

    });
});


// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('home', [HomeController::class, 'adminHome'])->name('home');
        Route::post('approve/{id}/{type}', [HomeController::class, 'approve'])->name('approve');
    });
});

// Generic routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/not-approved', function () {
    return view('not_approved');
})->name('not.approved');

Route::get('/close-notification', function () {
    session()->forget(['success', 'warning', 'error']);
});


?>
