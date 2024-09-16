<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use a2i\organogram\Http\Controllers\OrganogramController;
use a2i\organogram\Http\Controllers\HomeController;
use a2i\organogram\Http\Controllers\OfficeController;


// \Illuminate\Support\Facades\Auth::routes();
// use Auth;

// Route::controller(OrganogramController::class)->group(function () {
//     Route::get('/doptor', 'index');
//     Route::post('/doptor', 'send');
// });

Route::middleware(['web','auth'])->group(function () {
   
    Route::controller((OfficeController::class))->group(function(){
        Route::get('/load_active_offices', 'loadOfficeStatistics');
        Route::get('/load_active_organograms', 'loadOrganogramStatistics');
        Route::get('/load_all_users', 'loadAllUsers');
        Route::get('/load_active_units', 'loadUnitStatistics');
    });
    //load_statistics
    // Route::get('/load_active_offices', [App\Http\Controllers\OfficeController::class, 'loadOfficeStatistics']);
    // Route::get('/load_active_units', [App\Http\Controllers\OfficeController::class, 'loadUnitStatistics']);
    // Route::get('/load_active_organograms', [App\Http\Controllers\OfficeController::class, 'loadOrganogramStatistics']);
    // Route::get('/load_all_users', [App\Http\Controllers\OfficeController::class, 'loadAllUsers']);
    // Route::get('/load_active_units', [OfficeController::class, 'loadUnitStatistics']);
    // Route::get('/load_active_organograms', [OfficeController::class, 'loadOrganogramStatistics']);
    // Route::get('/load_all_users', [OfficeController::class, 'loadAllUsers']);
    Route::get('/', function () {
        return redirect(route('dashboard'));
    })->name('index');

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [\a2i\organogram\Http\Controllers\UserController::class, 'profile'])->name('profile');
    //load_statistics
    
});

// Route::get('/load_active_offices', [OfficeController::class, 'loadOfficeStatistics'])->name('load_active_offices')->middleware(['web']);

// Route::get('/', function () {
//     return redirect(route('dashboard'));
// })->name('index')->middleware(['web','auth']);
// Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard')->middleware(['web','auth']);


// Route::get('/profile', [\a2i\organogram\Http\Controllers\UserController::class, 'profile'])->name('profile')->middleware(['web','auth']);

