<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\HomeControllerTeacher;
use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\TeacherAuth\TLoginController;
use App\Http\Controllers\TeacherAuth\TRegisterController;
use App\Http\Controllers\StudentAuth\LoginController as StudentLoginController;
use App\Http\Controllers\StudentAuth\RegisterController as StudentRegisterController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::prefix('student')->group(function () {
    Route::get('register', [StudentRegisterController::class, 'showRegistrationForm'])->name('student.register');
    Route::post('register', [StudentRegisterController::class, 'register']);
    Route::get('login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');
    Route::post('login', [StudentLoginController::class, 'login']);
    Route::post('logout', [StudentLoginController::class, 'logout'])->name('student.logout');
    Route::get('home', [HomeController::class, 'index'])->name('student.home');
});

Route::prefix('teacher')->group(function () {
    Route::get('register', [TRegisterController::class, 'showRegistrationForm'])->name('teacher.register');
    Route::post('register', [TRegisterController::class, 'register']);
    Route::get('login', [TLoginController::class, 'showLoginForm'])->name('teacher.login');
    Route::post('login', [TLoginController::class, 'login']);
    Route::post('logout', [TLoginController::class, 'logout'])->name('teacher.logout');
    Route::get('home', [HomeControllerTeacher::class, 'teacherindex'])->name('teacher.home');  
});

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('home', [HomeController::class, 'adminHome'])->middleware('auth:admin')->name('admin.home');
    Route::get('approve/students', [AdminApprovalController::class, 'showStudents'])->name('admin.approve.students');
    Route::get('approve/teachers', [AdminApprovalController::class, 'showTeachers'])->name('admin.approve.teachers');
    Route::post('approve/student/{id}', [AdminApprovalController::class, 'approveStudent'])->name('admin.approve.student');
    Route::post('approve/teacher/{id}', [AdminApprovalController::class, 'approveTeacher'])->name('admin.approve.teacher');
});

