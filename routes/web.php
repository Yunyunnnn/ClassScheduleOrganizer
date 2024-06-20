<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\TeacherAuth\TLoginController;
use App\Http\Controllers\AdminAuth\AdminAuthController;
use App\Http\Controllers\TeacherAuth\TRegisterController;
use App\Http\Controllers\StudentAuth\LoginController as StudentLoginController;
use App\Http\Controllers\StudentAuth\RegisterController as StudentRegisterController;

// Existing routes for Welcome, Student, Teacher, Admin
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Student routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('register', [StudentRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [StudentRegisterController::class, 'register']);
    Route::get('login', [StudentLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [StudentLoginController::class, 'login']);
    Route::post('logout', [StudentLoginController::class, 'logout'])->name('logout');

    Route::get('subject-search', [SubjectController::class, 'showSearchForm'])->name('subject.search');
    Route::post('subject-search/results', [SubjectController::class, 'search'])->name('subject.search.results');
    
    Route::middleware(['auth:student'])->group(function () {
        Route::get('home', [HomeController::class, 'studentHome'])->name('home');
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
        Route::get('subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
        Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::get('subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
        Route::post('dismissApprovalMessage', [HomeController::class, 'dismissApprovalMessage'])->name('dismissApprovalMessage');
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

?>
