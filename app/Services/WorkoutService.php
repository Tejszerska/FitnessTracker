<?php

namespace App\Services;


use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class WorkoutService
{
    public function addToDb(int $planId)
    {
        $workout = new Workout();
        $workout->plan_id = $planId;
        $workout->user_id = "6"; // @TODO: auth()->id();
        $workout->workout_date = now();
        $workout->is_active = true;
        $workout->save();
        return $workout->id;
    }

    public function getById(int $id)
    {
        return Workout::where('id', $id)->where('is_active', true)->first();
    }
}
