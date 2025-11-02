<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReceitaController;
use App\Http\Controllers\Api\CategoriaController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    Route::apiResource('receitas', ReceitaController::class);
    Route::get('/receitas/search/{term}', [ReceitaController::class, 'search']);
    Route::get('/receitas/{id}/print', [ReceitaController::class, 'print']);
});