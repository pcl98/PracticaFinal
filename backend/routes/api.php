<?php

use App\Http\Controllers\AsisteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\UsuarioEstudianteController;

// Rutas para usuarios
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);


// Rutas de autenticación
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'user']);

// Rutas de clases
Route::get('/clases', [ClaseController::class, 'index']);
Route::post('/clases', [ClaseController::class, 'store']);
Route::delete('/clases/{id}', [ClaseController::class, 'destroy']);
Route::get('/clases/presencial', [ClaseController::class, 'getClasesPresenciales']);
Route::get('/clases/online', [ClaseController::class, 'getClasesOnline']);

// Rutas de estudiantes
Route::get('/estudiantes', [UsuarioEstudianteController::class, 'index']);

// Ruta para asiste
Route::get('/{id}/clases', [AsisteController::class, 'getClasesByUsuarioId']);