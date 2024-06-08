<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpenceManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/expenses', [ExpenceManagementController::class, 'index'])->name('expenses.index'); // List all expenses
Route::get('/expenses/create', [ExpenceManagementController::class, 'create'])->name('expenses.create'); // Show form to create a new expense
Route::post('/expenses', [ExpenceManagementController::class, 'store'])->name('expenses.store'); // Store a new expense
Route::get('/expenses/{expense}', [ExpenceManagementController::class, 'show'])->name('expenses.show'); // Show a specific expense
Route::get('/expenses/{expense}/edit', [ExpenceManagementController::class, 'edit'])->name('expenses.edit'); // Show form to edit a specific expense
Route::put('/expenses/{expense}', [ExpenceManagementController::class, 'update'])->name('expenses.update'); // Update a specific expense
Route::delete('/expenses/{expense}', [ExpenceManagementController::class, 'destroy'])->name('expenses.destroy'); // Delete a specific expense


});

require __DIR__.'/auth.php';
