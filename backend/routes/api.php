<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('booking', [BookingController::class, 'index']);
Route::get('rooms', [RoomController::class, 'index']);
Route::middleware('auth:sanctum')->post('bookings', [BookingController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);
