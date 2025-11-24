<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Models\Tweet;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Public Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Public Profile Page
Route::get('/user/{user}', [ProfileController::class, 'show'])
    ->name('profile.show');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard (Breeze default)
    Route::get('/dashboard', function () {
        $tweets = Tweet::with('user')->latest()->get();
        return view('dashboard', compact('tweets'));
    })->middleware(['verified'])->name('dashboard');

    // HOME TIMELINE (Main feed)
    Route::get('/home', function () {
        $tweets = \App\Models\Tweet::with('user')->latest()->get();
        return view('dashboard', compact('tweets'));
    })->middleware(['auth', 'verified'])->name('home');

    // Tweet CRUD
    Route::resource('tweets', TweetController::class);

    // LIKE / UNLIKE
    Route::post('/tweets/{tweet}/like', [LikeController::class, 'like'])
        ->name('tweets.like');

    Route::delete('/tweets/{tweet}/like', [LikeController::class, 'unlike'])
        ->name('tweets.unlike');

    // Your own profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Groups
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/requests/{request}/approve', [GroupController::class, 'approveRequest'])->name('groups.requests.approve');
    Route::post('/groups/requests/{request}/decline', [GroupController::class, 'declineRequest'])->name('groups.requests.decline');
});

// Auth Routes (Login/Register)
require __DIR__.'/auth.php';
