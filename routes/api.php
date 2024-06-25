<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymController; 

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/gymsub', [GymController::class, 'add']);
Route::get('/gymsub', [GymController::class, 'get']);
Route::put('/gymsub/{id}', [GymController::class, 'put']);
Route::patch('/gymsub/{id}', [GymController::class, 'patch']);
Route::delete('/gymsub/{id}', [GymController::class, 'delete']);