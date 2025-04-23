<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends/{friendId}/send-request', [FriendController::class, 'sendRequest'])->name('friends.sendRequest');
    Route::post('/friends/{friendId}/accept-request', [FriendController::class, 'acceptRequest'])->name('friends.acceptRequest');
    Route::post('/friends/{friendId}/decline-request', [FriendController::class, 'declineRequest'])->name('friends.declineRequest');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::middleware('auth')->post('/posts/{post}/like', [LikeController::class, 'show'])->name('posts.like');
    Route::middleware('auth')->post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');



});

require __DIR__.'/auth.php';
