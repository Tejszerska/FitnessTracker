<?php

namespace App\Http\Controllers;

use App\Services\HistoryService;
use App\Services\WorkoutService;
use App\Services\PlanService;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    private HistoryService $service;
    private WorkoutService $workoutService;
    private PlanService $planService;

    public function __construct(HistoryService $hService, WorkoutService $wService, PlanService $pService)
    {
        $this->service = $hService;
        $this->workoutService = $wService;
        $this->planService = $pService;
    }

    public function index()
    {
        $workouts = $this->service->getAllWorkouts();
        return view('history.index', ['workouts' => $workouts]);
    }

    public function show(int $workoutId)
    {
        $workout = $this->service->getWorkoutDetails($workoutId);
        return view('history.show', ['workout' => $workout]);
    }

    public function edit(int $workoutId)
    {
        $workout = $this->workoutService->getById($workoutId);
        $plan = $this->planService->getById($workout->plan_id);

        return view('history.edit', [
            'workout' => $workout,
            'plan' => $plan
        ]);
    }


    public function update(Request $request, int $workoutId)
    {
        $setsData = $request->input('sets');
        $this->service->updateWorkout($workoutId, $setsData);
        return redirect('/history')->with('success', 'Workout has been updated.');
    }


    public function remove(int $id)
    {
        $model = $this->service->getWorkoutDetails($id);
        if ($model === null) {
            return redirect('/history')->with('error', 'Workout not found.');
        }

        $this->service->removeWorkout($id);

        $models = $this->service->getAllWorkouts();
        return redirect('/history')->with('success', 'Workout has been deleted.');
    }
}
