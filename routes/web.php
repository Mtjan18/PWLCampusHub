<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Member;
use App\Http\Middleware\Panitia;
use App\Http\Controllers\Admin\AdminController;


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
Route::get('/panitia/dashboard', function () {
    return view('panitia.dashboard');
})->middleware(['auth', Panitia::class])->name('panitia.dashboard');
require __DIR__ . '/auth.php';
