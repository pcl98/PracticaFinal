<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClaseController;

Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

Route::get('/clase', [ClaseController::class, 'index']);
Route::post('/clase', [ClaseController::class, 'store']);
Route::delete('/clase/{id}', [ClaseController::class, 'destroy']);
