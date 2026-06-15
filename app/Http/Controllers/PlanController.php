<?php

namespace App\Http\Controllers;

use App\Services\PlanService;
use App\Enums\MuscleGroup;
use App\Services\ExcerciseService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    private PlanService $service;
    private ExcerciseService $exerciseService;

    public function __construct(PlanService $pService, ExcerciseService $eService)
    {
        $this->service = $pService;
        $this->exerciseService = $eService;
    }


    // == CRUD for plan   ==
    public function index()
    {
        $models = $this->service->getAll();
        return view('plan.index', ["models" => $models, 'muscleGroups' => MuscleGroup::cases()]);
    }

    public function create()
    {
        return view('plan.create', ['muscleGroups' => MuscleGroup::cases()]);
    }

    public function post(Request $request)
    {
        $plan = $this->service->addToDb($request);
        $exercises = $this->exerciseService->getAll();

        return redirect("/plans/manage/{$plan->id}")->with('success', 'Plan created! You can now add exercises.');
    }

    public function edit(int $id, Request $request)
    {
        $plan = $this->service->getById($id);
        if ($plan === null) {
            return redirect('/plans')->with('error', 'Plan not found.');
        }

        $exercises = $this->exerciseService->getFiltered($request);

        return view('plan.edit', [
            'model' => $plan,
            'exercises' => $exercises,
            'muscleGroups' => MuscleGroup::cases(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);

        return redirect()->back()->with('success', 'Plan updated succesfully!');
    }

    public function remove(int $id)
    {
        $model = $this->service->getById($id);
        if ($model === null) {
            return redirect('/plans')->with('error', 'Plan not found.');
        }
        $this->service->remove($id);
        return redirect('/plans')->with('success', 'Plan has been deleted.');
    }

    // == add an exercise to the plan  ==
    public function addExercise(int $planId, Request $request)
    {
        $plan = $this->service->getById($planId);
        if ($plan === null) {
            return redirect('/plans')->with('error', 'Plan not found.');
        }

        $exercises = $this->exerciseService->getFiltered($request);

        return view('plan.manage-plan', [
            'model' => $plan,
            'exercises' => $exercises,
            'muscleGroups' => MuscleGroup::cases(),
        ]);
    }

    public function addExerciseToDB(int $planId, Request $request)
    {
        $this->service->addExerciseToPlan($planId, $request);
        return redirect()->back()->with('success', 'Exercise added to plan successfully! You can add another one.');
    }

    // == changing plan's items ==

    public function incrementSeries(int $itemId)
    {
        $this->service->incrementSeries($itemId);
        return redirect()->back();
    }

    public function decrementSeries(int $itemId)
    {
        $this->service->decrementSeries($itemId);
        return redirect()->back();
    }

    public function incrementOrder(int $itemId)
    {
        $this->service->incrementOrder($itemId);
        return redirect()->back();
    }

    public function decrementOrder(int $itemId)
    {
        $this->service->decrementOrder($itemId);
        return redirect()->back();
    }

    public function removeExercise(int $itemId)
    {
        $this->service->removeExercise($itemId);
        return redirect()->back();
    }
}
