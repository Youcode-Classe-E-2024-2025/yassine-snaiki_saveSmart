<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');



Route::get('/user/dashboard', [ProfileController::class,'dashboard']);
Route::get('/user/profiles', [ProfileController::class,'profiles']);
Route::post('/user/profiles', [ProfileController::class,'createProfile']);

Route::get('/login', [AuthController::class,'showLogin']);
Route::get('/register', [AuthController::class,'showRegister']);


Route::post('/login',[AuthController::class,'login']);
Route::get('/logout',[AuthController::class,'logout']);
Route::get('/close',[ProfileController::class,'closeProfile']);
Route::post('/register',[AuthController::class,'register']);


Route::delete('/user/profiles/{id}',[ProfileController::class,'DeleteProfile']);
Route::post('/user/profiles/{id}',[ProfileController::class,'profile']);
Route::get('/user/profiles/{id}',[ProfileController::class,'showProfile']);

Route::post('/transactions/add',[TransactionController::class,'create']);


