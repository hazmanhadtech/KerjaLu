<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/gigs/create', [\App\Http\Controllers\GigController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('gigs.create');

Route::post('/gigs', [\App\Http\Controllers\GigController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('gigs.store');

Route::get('/gigs/{gig}/edit', [\App\Http\Controllers\GigController::class, 'edit'])->middleware(['auth', 'verified'])->name('gigs.edit');
Route::put('/gigs/{gig}', [\App\Http\Controllers\GigController::class, 'update'])->middleware(['auth', 'verified'])->name('gigs.update');
Route::delete('/gigs/{gig}', [\App\Http\Controllers\GigController::class, 'destroy'])->middleware(['auth', 'verified'])->name('gigs.destroy');
Route::get('/gigs/{gig}', [\App\Http\Controllers\GigController::class, 'show'])->middleware(['auth', 'verified'])->name('gigs.show');

Route::get('/applications', [\App\Http\Controllers\ApplicationController::class, 'index'])->middleware(['auth', 'verified'])->name('applications.index');
Route::post('/gigs/{gig}/apply', [\App\Http\Controllers\ApplicationController::class, 'store'])->middleware(['auth', 'verified'])->name('applications.store');
Route::patch('/applications/{application}', [\App\Http\Controllers\ApplicationController::class, 'update'])->middleware(['auth', 'verified'])->name('applications.update');
Route::delete('/applications/{application}', [\App\Http\Controllers\ApplicationController::class, 'destroy'])->middleware(['auth', 'verified'])->name('applications.destroy');

Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->middleware(['auth', 'verified'])->name('admin.users');
Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->middleware(['auth', 'verified'])->name('admin.users.destroy');
Route::get('/admin/gigs', [\App\Http\Controllers\AdminController::class, 'gigs'])->middleware(['auth', 'verified'])->name('admin.gigs');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/switch-role', [ProfileController::class, 'switchRole'])->name('profile.switch-role');

    // Services
    Route::resource('services', \App\Http\Controllers\ServiceController::class);
    Route::post('/services/{service}/book', [\App\Http\Controllers\ServiceBookingController::class, 'store'])->name('services.book');
    Route::get('/my-bookings', [\App\Http\Controllers\ServiceBookingController::class, 'index'])->name('services.bookings.index');
    Route::patch('/bookings/{booking}', [\App\Http\Controllers\ServiceBookingController::class, 'update'])->name('services.bookings.update');

    // Payouts
    Route::post('/payouts/gig/{application}', [\App\Http\Controllers\PayoutController::class, 'payGig'])->name('payouts.gig');
    Route::post('/payouts/service/{booking}', [\App\Http\Controllers\PayoutController::class, 'payService'])->name('payouts.service');
    Route::get('/payouts', [\App\Http\Controllers\PayoutController::class, 'index'])->name('payouts.index');

    // Admin Payout Management
    Route::get('/admin/payouts', [\App\Http\Controllers\PayoutController::class, 'adminIndex'])
        ->middleware(['admin', 'password.confirm'])
        ->name('admin.payouts');
});

require __DIR__.'/auth.php';
