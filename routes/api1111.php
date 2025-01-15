<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\TagController;
/*

Route::middleware('auth:sanctum')->get('user', function(Request $request){
    return $request->user();
});*/

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::get('recipes', [CategoryController::class, 'index']);
Route::get('recipes/{recipe}', [CategoryController::class, 'show']);

Route::get('tags', [CategoryController::class, 'index']);
Route::get('tags/{tag}', [CategoryController::class, 'show']);


