<?php

namespace App\Services;


use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class WorkoutService
{
    public function addToDb(int $planId)
    {
        $workout = new Workout();
        $workout->plan_id = $planId;
        $workout->user_id = Auth::id();
        $workout->workout_date = now();
        $workout->is_active = true;
        $workout->save();
        return $workout->id;
    }

    public function getById(int $id)
    {
        return Workout::where('id', $id)
            ->where('is_active', true)
            ->where('user_id', Auth::id())
            ->first();
    }

    public function saveSets(int $workoutId, Request $request)
    {
        $workout = $this->getById($workoutId);
        if (!$workout) return;



        $validated = $request->validate([
            'sets' => 'nullable|array',
            'sets.*.*.weight' => 'nullable|numeric|min:0|max:1000',
            'sets.*.*.reps' => 'nullable|integer|min:0|max:500',
            'sets.*.*.duration_seconds' => 'nullable|integer|min:0',
            'sets.*.*.rest_interval' => 'nullable|integer|min:0',
            'sets.*.*.is_superset' => 'nullable|boolean',
        ]);

        $setsData = $request->input('sets', []);

        $savedCount = 0; // for checking if workout  has saved sets

        // 1. itarate through all exercises
        foreach ($setsData as $exerciseId => $seriesData) {

            // 2. itarate through all sets
            foreach ($seriesData as $setNumber => $setData) {

                // skipping if this line of form was completly empty
                $hasData = !empty($setData['weight']) ||
                    !empty($setData['reps']) ||
                    !empty($setData['duration_seconds']);

                if (!$hasData) {
                    continue;
                }

                //3. saving to db (create() because we use $fillable)
                \App\Models\Set::create([
                    'workout_id' => $workoutId,
                    'exercise_id' => $exerciseId,
                    'set_number' => $setNumber,

                    'weight' => $setData['weight'] ?? null,
                    'reps' => $setData['reps'] ?? null,
                    'duration_seconds' => $setData['duration_seconds'] ?? null,
                    'rest_interval' => $setData['rest_interval'] ?? null,

                    'is_superset' => isset($setData['is_superset']) ? 1 : 0,
                    'is_active' => true
                ]);
                $savedCount++;
            }
        }
        // if no series were filled, the workout is discarded
        if ($savedCount === 0) {
            $workout->is_active = false;
            $workout->save();
            return false;
        }

        return true;
    }
}
