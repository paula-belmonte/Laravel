<?php

use Illuminate\Support\Facades\Route;

Route::view('/chocolate', 'chocolate');
Route::get('/', function () {
	return view('welcome');
});


