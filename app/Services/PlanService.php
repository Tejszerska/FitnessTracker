<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\PlanItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PlanService
{
    public function getAll(Request $request): Collection
    {
        $query = Plan::where("is_active", "=", true)
            ->where("user_id", Auth::id());

        if ($request->filled('search_name')) {
            $searchTerm = $request->input('search_name');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function addToDb(Request $request)
    {
        $validated = $request->validate([
            'plan_name' => 'required|string|min:3|max:100',
        ]);


        $model = new Plan();
        $model->user_id = Auth::id();
        $model->name = $request->input('plan_name');
        $model->is_active = true;
        $model->save();
        return $model;
    }

    public function getById(int $id)
    {
        return Plan::where('id', $id)
            ->where('is_active', true)
            ->where('user_id', Auth::id())
            ->first();
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'plan_name' => 'required|string|min:3|max:100',
        ]);

        $model = $this->getById($id);
        if ($model) {
            $model->name = $request->input('plan_name');
            $model->save();
        }
    }

    public function remove(int $id)
    {
        $planToRemove = $this->getById($id);
        if ($planToRemove) {
            $planToRemove->is_active = 0;
            $planToRemove->save();
        }
    }

    public function addExerciseToPlan(int $planId, Request $request)
    {
        $validated = $request->validate([
            'exercise_id' => 'required|integer|exists:exercises,id',
            'series_count' => 'required|integer|min:1|max:20',
        ]);

        // for order
        $currentItemsCount = PlanItem::where('plan_id', $planId)
            ->where('is_active', true)
            ->count();

        $model = new PlanItem();
        $model->plan_id = $planId;
        $model->exercise_id = $request->input('exercise_id');
        $model->series_count = $request->input('series_count');
        $model->order = $currentItemsCount + 1;
        $model->is_active = true;

        $model->save();
    }

    public function incrementSeries(int $itemId)
    {
        $planItem = PlanItem::find($itemId);
        if ($planItem !== null) {
            $planItem->series_count += 1;
            $planItem->save();
        }
    }

    public function decrementSeries(int $itemId)
    {
        $planItem = PlanItem::find($itemId);
        if ($planItem->series_count > 1) {
            $planItem->series_count -= 1;
            $planItem->save();
        }
    }

    public function incrementOrder(int $itemId)
    {
        $planItem = PlanItem::find($itemId);
        if ($planItem === null) return;

        // item that is lower in the order
        $nextItem = PlanItem::where('plan_id', $planItem->plan_id)
            ->where('order', $planItem->order + 1)
            ->first();

        // if exists, swap
        if ($nextItem !== null) {
            $nextItem->order -= 1;
            $planItem->order += 1;

            $nextItem->save();
            $planItem->save();
        }
    }

    public function decrementOrder(int $itemId)
    {
        $planItem = PlanItem::find($itemId);
        if ($planItem === null) return;

        // item that is higher in the order
        $prevItem = PlanItem::where('plan_id', $planItem->plan_id)
            ->where('order', $planItem->order - 1)
            ->first();

        // if exists, swap
        if ($prevItem !== null) {
            $prevItem->order += 1;
            $planItem->order -= 1;

            $prevItem->save();
            $planItem->save();
        }
    }

    public function removeExercise(int $itemId)
    {
        $planItem = PlanItem::find($itemId);
        if ($planItem === null) return;

        $plan_id = $planItem->plan_id;
        $removedItemOrder = $planItem->order;

        // decrement items with higher order
        PlanItem::where('plan_id', $plan_id)
            ->where('is_active', true)
            ->where('order', '>', $removedItemOrder)
            ->decrement('order');

        $planItem->is_active = 0;
        $planItem->order = 0;
        $planItem->save();
    }
}
