<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController; 

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/gymsub', [EnrollmentController::class, 'add']);
Route::get('/gymsub', [EnrollmentController::class, 'get']);
Route::put('/gymsub/{id}', [EnrollmentController::class, 'put']);
Route::delete('/gymsub/{id}', [EnrollmentController::class, 'delete']);