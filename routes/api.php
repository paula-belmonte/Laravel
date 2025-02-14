<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChocolateController;
use App\Http\Controllers\Api\TiposController;


Route::apiResource('chocolates', ChocolateController::class);
Route::apiResource('tipos', TiposController::class);
Route::get('/user', function (Request $request) {
	return $request->user();
});
