<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

//CRUD Operations

Route::get('/products', [ProductController::class,'getAll'])->middleware(middleware: ['auth:api']);

Route::get('/products/{id}',[ProductController::class,'getByID'])->middleware(middleware: ['auth:api']);

Route::put('/products/{id}',[ProductController::class,'updateByID'])->middleware(middleware: ['auth:api']);

Route::delete('/products/{id}',[ProductController::class,'deleteByID'])->middleware(middleware: ['auth:api']);

Route::post('/products/new',[ProductController::class,'save'])->middleware(middleware: ['auth:api']);

//Auth operations

Route::post('/register',[AuthController::class,'register']);

Route::post('/login',[AuthController::class,'login']);

Route::post('/logout',[AuthController::class,'logout'])->middleware(middleware: ['auth:api']);
