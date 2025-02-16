<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClaseController;

// Rutas para usuarios
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);


// Rutas de autenticación
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'user']);

Route::get('/clase', [ClaseController::class, 'index']);
Route::post('/clase', [ClaseController::class, 'store']);
Route::delete('/clase/{id}', [ClaseController::class, 'destroy']);
