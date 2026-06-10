<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExcerciseController;
use App\Http\Controllers\PlanController;

Route::get('/', function () {
    return view('welcome');
});
Route::get("/", [HomeController::class, "index"]);

// EXERCISES 
Route::get("/exercises", [ExcerciseController::class, "index"]);

Route::get("/exercises/add", [ExcerciseController::class, "create"]);
Route::post("/exercises/add", [ExcerciseController::class, "post"]);

Route::get("/exercises/edit/{id}", [ExcerciseController::class, "edit"]);
Route::post("/exercises/edit/{id}", [ExcerciseController::class, "update"]);

Route::get("/exercises/delete/{id}", [ExcerciseController::class, "remove"]);

// PLANS

Route::get("/plans", [PlanController::class, "index"]);

Route::get("/plans/add", [PlanController::class, "create"]);
Route::post("/plans/add", [PlanController::class, "post"]);

Route::get("/plans/edit/{id}", [PlanController::class, "edit"]);
Route::post("/plans/edit/{id}", [PlanController::class, "update"]);

Route::get("/plans/delete/{id}", [PlanController::class, "remove"]);

// PLAN_ITEMS

Route::get("/plans/manage/{id}", [PlanController::class, "manage"]);
Route::post("/plans/manage/{id}", [PlanController::class, "saveManaged"]);
