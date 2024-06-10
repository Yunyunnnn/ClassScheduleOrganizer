<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StudentAuth\LoginController as StudentLoginController;
use App\Http\Controllers\StudentAuth\RegisterController as StudentRegisterController;
use App\Http\Controllers\TeacherAuth\TLoginController;
use App\Http\Controllers\TeacherAuth\TRegisterController;
use App\Http\Controllers\AdminAuth\AdminAuthController;
use Illuminate\Support\Facades\Route;

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
    });
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('home', [HomeController::class, 'adminHome'])->name('home');
        Route::post('approve/{id}/{type}', [HomeController::class, 'approved'])->name('approve');
    });
});

// Generic routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/not-approved', function () {
    return view('not_approved');
})->name('not.approved');

