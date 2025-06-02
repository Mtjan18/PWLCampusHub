<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Member;
use App\Http\Middleware\Panitia;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Panitia\PanitiaController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


// Route dashboard untuk ADMIN

Route::middleware(['auth', Admin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/committee', [AdminController::class, 'committee'])->name('committee.index');
    Route::get('/finance', [AdminController::class, 'finance'])->name('finance.index');
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/events', [AdminController::class, 'events'])->name('events');
    Route::post('/members/promote', [AdminController::class, 'promote'])->name('members.promote');
});


// Route dashboard untuk MEMBER
Route::get('/member/dashboard', function () {
    return view('member.dashboard');
})->middleware(['auth', Member::class])->name('member.dashboard');

// Route dashboard untuk PANITIA 
Route::middleware(['auth', Panitia::class])->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/dashboard', [PanitiaController::class, 'dashboard'])->name('dashboard');

    // Event
    Route::get('/events/create', [PanitiaController::class, 'createEvent'])->name('events.create');
    Route::post('/events/store', [PanitiaController::class, 'storeEvent'])->name('events.store');

    // Event Session
    Route::get('/events/{event}/sessions/create', [PanitiaController::class, 'createSession'])->name('sessions.create');
    Route::post('/events/{event}/sessions/store', [PanitiaController::class, 'storeSession'])->name('sessions.store');

    // Tambahkan route panitia lainnya di sini ke depan
});


require __DIR__ . '/auth.php';
