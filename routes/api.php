<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;

// Rotas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Usuário
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Boards
    Route::get('/boards', [BoardController::class, 'index']);
    Route::post('/boards', [BoardController::class, 'store']);
    Route::get('/boards/{id}', [BoardController::class, 'show']);
    Route::put('/boards/{id}', [BoardController::class, 'update']);
    Route::delete('/boards/{id}', [BoardController::class, 'destroy']);

    // Categories
    Route::post('/boards/{boardId}/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::post('/boards/{boardId}/categories/reorder', [CategoryController::class, 'reorder']);

    // Tasks
    Route::post('/categories/{categoryId}/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    Route::post('/tasks/{id}/move', [TaskController::class, 'move']);
    Route::post('/categories/{categoryId}/tasks/reorder', [TaskController::class, 'reorder']);
});
