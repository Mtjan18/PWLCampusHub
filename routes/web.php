<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

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
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

// Route dashboard untuk MEMBER
Route::get('/member/dashboard', function () {
    return view('member.dashboard');
})->middleware(['auth', 'verified'])->name('member.dashboard');

// Route dashboard untuk PANITIA 
Route::get('/panitia/dashboard', function () {
    return view('panitia.dashboard');
})->middleware(['auth', 'verified'])->name('panitia.dashboard');
require __DIR__.'/auth.php';
