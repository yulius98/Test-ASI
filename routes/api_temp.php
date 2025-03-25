<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyClientController;

// CRUD routes for MyClient
Route::post('/my-client', [MyClientController::class, 'create']);
Route::get('/my-client/{slug}', [MyClientController::class, 'read']);
Route::put('/my-client/{slug}', [MyClientController::class, 'update']);
Route::delete('/my-client/{slug}', [MyClientController::class, 'delete']);