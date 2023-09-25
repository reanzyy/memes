<?php

use App\Livewire\Counter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimelineController;

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

Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('login', [AuthController::class, 'storeLogin'])->name('login.process');
Route::post('register', [AuthController::class, 'storeRegister'])->name('register.process');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', TimelineController::class)->name('dashboard');
Route::get('/detail/{post:identifier}', [PostController::class, 'show'])->name('post.show');
Route::post('/comment', [PostController::class, 'comment'])->name('post.comment')->middleware('isUser');
Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/', [PostController::class, 'store'])->name('post.store');
Route::delete('/{post:identifier}', [PostController::class, 'delete'])->name('post.delete');
Route::post('like/{post:id}', [PostController::class, 'like'])->name('post.like');

Route::get('/profile/{user:username}', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
