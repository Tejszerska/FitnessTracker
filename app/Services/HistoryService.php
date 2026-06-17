<?php

namespace App\Services;

use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HistoryService
{
    public function getAllWorkouts(Request $request)
    {
        $query = Workout::with('plan')
            ->has('sets')
            ->where('is_active', true)
            ->where('user_id', Auth::id());

        if ($request->filled('filter_date')) {
            $query->whereDate('workout_date', $request->input('filter_date'))
                ->where('user_id', Auth::id());
        }

        return $query->orderBy('workout_date', 'desc')->get();
    }

    public function getWorkoutDetails(int $id)
    {
        return Workout::with(['plan', 'sets.exercise'])
            ->where('id', $id)
            ->where('is_active', true)
            ->where('user_id', Auth::id())
            ->first();
    }

    public function removeWorkout(int $id)
    {
        $workoutToRemove = Workout::where('id', $id)->where('user_id', Auth::id())->first();
        if ($workoutToRemove) {
            $workoutToRemove->is_active = 0;
            $workoutToRemove->save();
        }
    }

    public function updateWorkout(int $workoutId, Request $request)
    {
        $workout = Workout::where('id', $workoutId)->where('user_id', Auth::id())->first();
        if (!$workout) return;

        $validated = $request->validate([
            'sets' => 'nullable|array',
            'sets.*.*.weight' => 'nullable|numeric|min:0|max:1000',
            'sets.*.*.reps' => 'nullable|integer|min:0|max:500',
            'sets.*.*.duration_seconds' => 'nullable|numeric|min:0',
            'sets.*.*.rest_interval' => 'nullable|integer|min:0',
            'sets.*.*.is_superset' => 'nullable|boolean',
        ]);

        $setsData = $request->input('sets', []);

        // 1. itarate through all exercises
        foreach ($setsData as $exerciseId => $seriesData) {

            // 2. itarate through all sets
            foreach ($seriesData as $setNumber => $setData) {

                \App\Models\Set::updateOrCreate(
                    // I. identyfing set
                    [
                        'workout_id' => $workoutId,
                        'exercise_id' => $exerciseId,
                        'set_number' => $setNumber,
                    ],
                    // II. what is updated
                    [
                        'weight' => $setData['weight'] ?? null,
                        'reps' => $setData['reps'] ?? null,
                        'duration_seconds' => $setData['duration_seconds'] ?? null,
                        'rest_interval' => $setData['rest_interval'] ?? null,
                        'is_superset' => isset($setData['is_superset']) ? 1 : 0,
                        'is_active' => true
                    ]
                );
            }
        }
    }
}
