<?php

namespace App\Http\Controllers;

use App\Services\WorkoutService;
use App\Services\PlanService;

use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    private WorkoutService $service;
    private PlanService $planService;


    public function __construct(WorkoutService $wService, PlanService $pService)
    {
        $this->service = $wService;
        $this->planService = $pService;
    }

    public function start(int $planId)
    {
        $workoutId = $this->service->addToDb($planId);

        return redirect("/workout/{$workoutId}");
    }

    public function play(int $workoutId)
    {
        $workout = $this->service->getById($workoutId);
        $plan = $this->planService->getById($workout->plan_id);

        return view('workout.play', [
            'workout' => $workout,
            'plan' => $plan
        ]);
    }

    public function finish(Request $request, int $workoutId)
    {
        // dd($setsData);
        $hasSavedSets = $this->service->saveSets($workoutId, $request);

        if ($hasSavedSets) {
            return redirect('/history')->with('success', 'Workout saved successfully!');
        } else {
            return redirect('/history')->with('error', 'Empty workout will not be saved in history.');
        }
    }
}
