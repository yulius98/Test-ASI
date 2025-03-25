<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyClientController;

// Web routes for MyClient
Route::get('/my-client', [MyClientController::class, 'index'])->name('my_client.index');
Route::get('/my-client/create', [MyClientController::class, 'create'])->name('my_client.create');
Route::post('/my-client', [MyClientController::class, 'store'])->name('my_client.store');
Route::get('/my-client/{slug}/edit', [MyClientController::class, 'edit'])->name('my_client.edit');
Route::put('/my-client/{slug}', [MyClientController::class, 'update'])->name('my_client.update');
Route::delete('/my-client/{slug}', [MyClientController::class, 'delete'])->name('my_client.delete');