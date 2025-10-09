<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
        Route::get('/', action: [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/companies', action: [CompanyController::class, 'index'])->name('company.index');
        Route::get('/job-applications', action: [JobApplicationController::class, 'index'])->name('job-application.index');
        Route::get('/job-categories', action: [JobCategoryController::class, 'index'])->name('job-category.index');
        Route::get('/job-vacancies', action: [JobVacancyController::class, 'index'])->name('job-vacancy.index');
        Route::get('/users', action: [UserController::class, 'index'])->name('user.index');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
