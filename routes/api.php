<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['cors'])->group(function (){
    Route::post('/doctor.register', [\App\Http\Controllers\AppController::class, 'doctorRegister']);
    Route::post('/nurse.create', [\App\Http\Controllers\AppController::class, 'createNurse']);
    Route::post('/login', [\App\Http\Controllers\AppController::class, 'login']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
