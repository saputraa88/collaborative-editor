<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::get('/document/{id}', [DocumentController::class, 'index']);

Route::post('/update-document/{id}', [DocumentController::class, 'updateDocument']);

Route::post('/save/{id}', [DocumentController::class, 'save']);

Route::post('/cursor-update', [DocumentController::class, 'cursorUpdate']);

Route::get('/history/{id}', [DocumentController::class, 'history']);

Route::get('/logs/{id}', [DocumentController::class, 'logs']);