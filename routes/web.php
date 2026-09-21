<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ✅ Protect dashboard with admin middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'admin'])->name('dashboard');

// ✅ Change Password view
Route::get('/change-password', function () {
    return view('auth.change-password');
})->middleware('auth')->name('password.change');

Route::middleware('auth')->group(function () {
     // Profile view page
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    // Profile edit form
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // ✅ Full resource routes for policies
    Route::resource('policies', PolicyController::class)->except(['show']);

    // ✅ Export route for policies
    Route::get('/policies/export', [PolicyController::class, 'export'])->name('policies.export');
});

// ✅ Staff-only routes (hard block)
Route::middleware(['auth', 'staff'])->group(function () {
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('admin.users.updateRole');
});

// ✅ Chatbot routes
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/query', [ChatbotController::class, 'query'])->name('chatbot.query');

require __DIR__.'/auth.php';




