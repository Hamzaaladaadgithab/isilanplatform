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

        // Job Applications
        Route::resource('job-application', JobApplicationController::class);

        // Job Categories
        Route::resource('job-category', JobCategoryController::class);


        // Job Vacancies
        Route::resource('job-vacancy', JobVacancyController::class);

        // Users
        Route::resource('user', UserController::class);



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
