<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsisteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\UsuarioEstudianteController;
use App\Http\Controllers\ClaseOnlineController;
use App\Http\Controllers\ClasePresencialController;
use App\Http\Controllers\UsuarioProfesorController;
use App\Http\Controllers\ExamenController;



// Rutas para usuarios
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/search-by-fields', [UsuarioController::class, 'searchByFields']);
Route::get('/usuarios/search', [UsuarioController::class, 'search']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::patch('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);


// Rutas de autenticación
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'user']);

// Rutas de clases
Route::get('/clases', [ClaseController::class, 'index']);
Route::get('/clases/search-by-fields', [ClaseController::class, 'searchByFields']);
Route::get('/clases/search', [ClaseController::class, 'search']);
Route::post('/clases', [ClaseController::class, 'store']);
Route::get('/clases/presencial', [ClaseController::class, 'getClasesPresenciales']);
Route::get('/clases/online', [ClaseController::class, 'getClasesOnline']);
Route::get('/clases/{id}', [ClaseController::class, 'show']);
Route::delete('/clases/{id}', [ClaseController::class, 'destroy']);
Route::patch('/clases/{id}', [ClaseController::class, 'update']);

// Rutas de clases presenciales
Route::get('/clases-presenciales', [ClasePresencialController::class, 'index']);
Route::post('/clases-presenciales', [ClasePresencialController::class, 'store']);
Route::get('/clases-presenciales/search', [ClasePresencialController::class, 'search']);
Route::get('/clases-presenciales/search-by-fields', [ClasePresencialController::class, 'searchByFields']);
Route::get('/clases-presenciales/{id}', [ClasePresencialController::class, 'show']);
Route::patch('/clases-presenciales/{id}', [ClasePresencialController::class, 'update']);
Route::delete('/clases-presenciales/{id}', [ClasePresencialController::class, 'destroy']);

// Rutas de clases online
Route::get('/clases-online', [ClaseOnlineController::class, 'index']);
Route::post('/clases-online', [ClaseOnlineController::class, 'store']);
Route::get('/clases-online/search', [ClaseOnlineController::class, 'search']);
Route::get('/clases-online/search-by-fields', [ClaseOnlineController::class, 'searchByFields']);
Route::get('/clases-online/{id}', [ClaseOnlineController::class, 'show']);
Route::patch('/clases-online/{id}', [ClaseOnlineController::class, 'update']);
Route::delete('/clases-online/{id}', [ClaseOnlineController::class, 'destroy']);

// Rutas de estudiantes
Route::get('/estudiantes', [UsuarioEstudianteController::class, 'index']);
Route::post('/estudiantes', [UsuarioEstudianteController::class, 'store']);
Route::get('/estudiantes/search-by-fields', [UsuarioEstudianteController::class, 'searchByFields']);
Route::get('/estudiantes/search', [UsuarioEstudianteController::class, 'search']);
Route::get('/estudiantes/{id}', [UsuarioEstudianteController::class, 'show']);
Route::patch('/estudiantes/{id}', [UsuarioEstudianteController::class, 'update']);
Route::delete('/estudiantes/{id}', [UsuarioEstudianteController::class, 'destroy']);

// Rutas para profesores
Route::get('/profesores', [UsuarioProfesorController::class, 'index']);
Route::post('/profesores', [UsuarioProfesorController::class, 'store']);
Route::get('/profesores/search-by-fields', [UsuarioProfesorController::class, 'searchByFields']);
Route::get('/profesores/search', [UsuarioProfesorController::class, 'search']);
Route::get('/profesores/{id}', [UsuarioProfesorController::class, 'show']);
Route::patch('/profesores/{id}', [UsuarioProfesorController::class, 'update']);
Route::delete('/profesores/{id}', [UsuarioProfesorController::class, 'destroy']);

// Rutas para exámenes
Route::get('/examenes', [ExamenController::class, 'index']);
Route::post('/examenes', [ExamenController::class, 'store']);
Route::get('/examenes/search-by-fields', [ExamenController::class, 'searchByFields']);
Route::get('/examenes/search', [ExamenController::class, 'search']);
Route::get('/examenes/{id}', [ExamenController::class, 'show']);
Route::patch('/examenes/{id}', [ExamenController::class, 'update']);
Route::delete('/examenes/{id}', [ExamenController::class, 'destroy']);


// Ruta para asiste
Route::get('/{id}/clases', [AsisteController::class, 'getClasesByUsuarioId']);