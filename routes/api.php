<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttedanceController;
use App\Http\Controllers\PublicController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');


Route::get('/events', [EventController::class, 'index'])->middleware('auth:sanctum');
Route::get('/events/{id}', [EventController::class, 'show'])->middleware('auth:sanctum');
Route::post('/events', [EventController::class, 'create'])->middleware('auth:sanctum');
Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth:sanctum');


Route::get('/attedances', [AttedanceController::class, 'index'])->middleware('auth:sanctum');
Route::get('/attedances/{id}', [AttedanceController::class, 'show'])->middleware('auth:sanctum');
Route::post('/attedances', [AttedanceController::class, 'create'])->middleware('auth:sanctum');
Route::put('/attedances/{id}', [AttedanceController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/attedances/{id}', [AttedanceController::class, 'destroy'])->middleware('auth:sanctum');


// Public Access 
Route::get('/public/events', [PublicController::class, 'getEventAll']);
