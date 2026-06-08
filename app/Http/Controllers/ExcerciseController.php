<?php

namespace App\Http\Controllers;

use App\Services\ExcerciseService;
use App\Enums\MuscleGroup;
use Illuminate\Http\Request;

class ExcerciseController extends Controller
{
    private ExcerciseService $service;

    public function __construct(ExcerciseService $exService)
    {
        $this->service = $exService;
    }

    public function index()
    {
        $models = $this->service->getAll();

        return view('exercise.index', ["models" => $models, 'muscleGroups' => MuscleGroup::cases()]);
    }

    public function create()
    {
        return view('exercise.create', ['muscleGroups' => MuscleGroup::cases()]);
    }

    public function post(Request $request)
    {
        $this->service->addToDb($request);

        $models = $this->service->getAll();
        return view('exercise.create', ['muscleGroups' => MuscleGroup::cases()]);
    }


    public function edit(int $id)
    {
        $model = $this->service->getById($id);
        return view('exercise.edit', ["model" => $model, 'muscleGroups' => MuscleGroup::cases()]);
    }

    public function update(Request $request, int $id)
    {
        $model = $this->service->update($request, $id);
        $models = $this->service->getAll();
        return view('exercise.index', ["models" => $models, 'muscleGroups' => MuscleGroup::cases()]);
    }
}
