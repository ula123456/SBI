<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
                                
  Route::apiResource('categories', CategoryController::class);
  Route::apiResource('products', ProductController::class);
  Route::get('products/export', [ProductController::class, 'exportExcel']);
  Route::get('products/export', [\App\Http\Controllers\Api\ProductController::class, 'exportExcel']);
  Route::get('/', fn() => 'ok');