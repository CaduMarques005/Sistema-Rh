<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use Tests\Fixtures\Controllers\UserController;

Route::get('/', function () {
    if (app()->isLocal()) {
        auth()->loginUsingId(1);
        redirect('dashboard');
    }

    return to_route('login');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    #users region
    Route::get('/users', [UserController::class, 'index'])->name('users.index');


    Route::get('/calendar', [CalendarController::class, 'calendar'])->name('calendar');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
