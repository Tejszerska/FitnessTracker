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

// adding exercise to the plan
Route::get("/plans/manage/{id}", [PlanController::class, "addExercise"]);
Route::post("/plans/manage/{id}/add-exercise/", [PlanController::class, "addExerciseToDB"]);

// change series value in a plan_item
Route::get("/plan/increment-series/{itemId}", [PlanController::class, "incrementSeries"]);
Route::get("/plan/decrement-series/{itemId}", [PlanController::class, "decrementSeries"]);


// change order value in a plan_item
Route::get("/plan/increment-order/{itemId}", [PlanController::class, "incrementOrder"]);
Route::get("/plan/decrement-order/{itemId}", [PlanController::class, "decrementOrder"]);

// remove plan item (exercise) from plan
Route::get("/plan/remove-exercise/{itemId}", [PlanController::class, "removeExercise"]);
