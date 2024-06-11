<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController; 

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/enrollments', [EnrollmentController::class, 'add']);
Route::get('/enrollments', [EnrollmentController::class, 'get']);
Route::put('/enrollments/{id}', [EnrollmentController::class, 'put']);
Route::delete('/enrollments/{id}', [EnrollmentController::class, 'delete']);