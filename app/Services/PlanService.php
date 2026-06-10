<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\PlanItem;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class PlanService
{

    public function getAll(): Collection
    {
        return Plan::where("is_active", "=", true)->get();
    }

    public function addToDb(Request $request)
    {
        $model = new Plan();
        $model->user_id = "6";
        /*
        just for now - later use:
        $model->user_id = auth()->id();
        */
        $model->name = $request->input('plan_name');
        $model->save();
        return $model;
    }

    public function getById(int $id)
    {
        return Plan::find($id);
    }

    public function update(Request $request, $id)
    {
        $model = Plan::find($id);
        $model->user_id = "6";
        /*
        @TODO AUTH
        just for now - later use:
        $model->user_id = auth()->id();
        */
        $model->name = $request->input('plan_name');
        $model->save();
    }

    public function remove(int $id)
    {
        $PlanToRemove = Plan::find($id);
        $PlanToRemove->is_active = 0;
        $PlanToRemove->save();
    }

    public function createPlanItemModel(int $planId)
    {
        $model = new PlanItem();
        $model->plan_id = $planId;
        return $model;
    }

    public function addExerciseToPlan(int $planId, Request $request)
    {
        $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'series_count' => 'required|integer|min:1',
            'order' => 'required|integer|min:1'
        ]);

        $model = new PlanItem();
        $model->plan_id = $planId;
        $model->exercise_id = $request->input('exercise_id');
        $model->series_count = $request->input('series_count');
        $model->order = $request->input('order');
        $model->is_active = true;

        $model->save();
    }
}
