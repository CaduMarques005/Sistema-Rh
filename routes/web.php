<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (app()->isLocal()) {
        auth()->loginUsingId(2);
        redirect('calendar.show');
    }

    return to_route('login');

});



Route::middleware('auth')->group(function () {
    //users region
    Route::get('/users', [UserController::class, 'index'])->name('users.index'); //admin
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); //admin

    //endRegion

    // Requests Region

    Route::get('/requests', [RequestsController::class, 'index'])->name('requests.index');
    Route::get('/requests', [RequestsController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestsController::class, 'store'])->name('requests.store');
    Route::get('/requests/list', [RequestsController::class, 'show'])->name('requests.show');
    Route::post('/requests/list/{event_id}', [RequestsController::class, 'approve'])->name('approve'); //admin
    Route::delete('/requests/list/{event_id}', [RequestsController::class, 'denied'])->name('denied'); //admin
    // End Region

    Route::get('/calendar', [CalendarController::class, 'calendar'])->name('calendar'); //admin
    Route::get('/calendar/user', [CalendarController::class, 'userCalendar'])->name('calendar.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
