<?php

namespace App\Services;


use App\Models\Workout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class HomeService
{
    public function getLastWorkout()
    {
        return $lastWorkout = Workout::with('plan')
            ->where('is_active', true)
            ->where('user_id', Auth::id())
            ->orderBy('workout_date', 'desc')
            ->first();
    }
}
