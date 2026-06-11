<?php

namespace App\Services;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class ExcerciseService
{

    public function getAll(): Collection
    {
        return Exercise::where("is_active", "=", true)->get();
    }

    public function addToDb(Request $request)
    {
        $model = new Exercise();
        $model->user_id = $request->input("user_id");
        /*
        just for now - later use:
        $model->user_id = auth()->id();
        */
        $model->name = $request->input('name');
        $model->muscle_group = $request->input('muscle_group');
        $model->is_active = true;

        $model->has_weight = $request->has('has_weight');
        $model->has_reps = $request->has('has_reps');
        $model->has_duration = $request->has('has_duration');
        $model->save();
    }

    public function getById(int $id)
    {
        return Exercise::find($id);
    }

    public function update(Request $request, $id)
    {
        $model = Exercise::find($id);
        $model->user_id = $request->input("user_id");
        /*
        @TODO AUTH
        just for now - later use:
        $model->user_id = auth()->id();
        */
        $model->name = $request->input('name');
        $model->muscle_group = $request->input('muscle_group');
        $model->is_active = true;

        $model->has_weight = $request->has('has_weight');
        $model->has_reps = $request->has('has_reps');
        $model->has_duration = $request->has('has_duration');
        $model->save();
    }

    public function remove(int $id)
    {
        $exerciseToRemove = Exercise::find($id);
        $exerciseToRemove->is_active = 0;
        $exerciseToRemove->save();
    }

    public function getFiltered(Request $request): Collection
    {
        $query = Exercise::where('is_active', true);

        if ($request->filled('filter_group')) {
            $query->where('muscle_group', $request->input('filter_group'));
        }

        if ($request->filled('filter_source') && $request->input('filter_source') !== 'all') {
            if ($request->input('filter_source') === 'system') {
                $query->whereNull('user_id');
            } elseif ($request->input('filter_source') === 'user') {
                $query->whereNotNull('user_id');
            }
        }

        return $query->get();
    }
}
