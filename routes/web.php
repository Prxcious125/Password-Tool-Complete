<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Your actual dashboard view
    })->name('dashboard');
});

// Make sure your home route also points to dashboard
Route::redirect('/', '/dashboard');
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Password Tools Routes
Route::middleware(['auth','verified'])->group(function () {
    // Password Tools
    Route::get('/password/checker', [PasswordController::class, 'showChecker'])->name('password.checker');
    Route::post('/password/check', [PasswordController::class, 'checkStrength'])->name('password.check');
    Route::get('/password/generator', [PasswordController::class, 'showGenerator'])->name('password.generator');
    Route::post('/password/generate', [PasswordController::class, 'generatePassword'])->name('password.generate');
    Route::delete('/password/saved/{password}', [PasswordController::class, 'deleteSavedPassword'])->name('password.delete');
    Route::post('/password/save', [PasswordController::class, 'savePassword'])->name('password.save');
    Route::get('/password/history', [PasswordController::class, 'showHistory'])->name('password.history');
    Route::get('/passwords/add', [PasswordController::class, 'showAddForm'])->name('password.add');
    Route::post('/passwords/store', [PasswordController::class, 'storePassword'])->name('passwords.store');

});

require __DIR__.'/auth.php';