<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExcerciseController;


Route::get('/', function () {
    return view('welcome');
});

Route::get("/", [HomeController::class, "index"]);
Route::get("/exercises", [ExcerciseController::class, "index"]);


Route::get("/exercises/add", [ExcerciseController::class, "create"]);
Route::post("/exercises/add", [ExcerciseController::class, "post"]);


Route::get("/exercises/edit/{id}", [ExcerciseController::class, "edit"]);
Route::post("/exercises/edit/{id}", [ExcerciseController::class, "update"]);
