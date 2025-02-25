<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/login', 'auth.login');
Route::view('/register','auth.register');

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
