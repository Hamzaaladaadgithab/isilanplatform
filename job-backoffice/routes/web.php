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

        // Companies
        Route::resource('company', CompanyController::class);
        Route::put('company/{id}/restore', [CompanyController::class, 'restore'])->name('company.restore');

        // Job Applications
        Route::resource('job-application', JobApplicationController::class);
        Route::put('job-application/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-application.restore');

        // Job Categories
        Route::resource('job-category', JobCategoryController::class);

        Route::put('job-category/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-category.restore');


        // Job Vacancies
        Route::resource('job-vacancy', JobVacancyController::class);

        Route::put('job-vacancy/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancy.restore');


        // Users
        Route::resource('user', UserController::class);



        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
