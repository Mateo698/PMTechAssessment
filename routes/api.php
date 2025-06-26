<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/products', [ProductController::class,'getAll']);

Route::get('/products/{id}',[ProductController::class,'getByID']);

Route::put('/products/{id}',[ProductController::class,'updateByID']);

Route::delete('/products/{id}',[ProductController::class,'deleteByID']);

Route::post('/products/new',[ProductController::class,'save']);
