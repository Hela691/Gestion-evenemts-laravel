<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;



//Auth::routes();


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::get('/', [EventController::class, 'index'])->name('home');
Route::resource('events', EventController::class);
Route::get('events/create', [EventController::class, 'create'])->name('events.create');
Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');


Route::post('/events/{event}/participate', [EventController::class, 'participate'])->name('events.participate');


Route::middleware('auth:sanctum')->get('/user/events', [EventController::class, 'getUserEvents']);

// Route pour le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   

use App\Http\Controllers\ProfileController;

Route::middleware('auth')->get('/profile', [ProfileController::class, 'index'])->name('profile');

// Route pour mettre à jour le profil
Route::middleware('auth')->put('/profile', [ProfileController::class, 'update'])->name('profile.update');