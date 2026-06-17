<?php

namespace App\Services;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ExcerciseService
{

    public function getAll(): Collection
    {
        return Exercise::where("is_active", "=", true)
            ->where(function ($query) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', Auth::id());
            })->get();
    }

    public function addToDb(Request $request)
    {

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'muscle_group' => 'required|string|max:50',

            'has_weight' => 'nullable|boolean',
            'has_reps' => 'nullable|boolean',
            'has_duration' => 'nullable|boolean',
        ]);

        $model = new Exercise();
        $model->user_id = Auth::id();
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
        return Exercise::where('id', $id)
            ->where(function ($query) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', Auth::id());
            })->first();
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'muscle_group' => 'required|string|max:50',
            'has_weight' => 'nullable|boolean',
            'has_reps' => 'nullable|boolean',
            'has_duration' => 'nullable|boolean',
        ]);

        $model = Exercise::where('id', $id)->where('user_id', Auth::id())->first();

        if ($model) {
            $model->name = $request->input('name');
            $model->muscle_group = $request->input('muscle_group');
            $model->has_weight = $request->has('has_weight');
            $model->has_reps = $request->has('has_reps');
            $model->has_duration = $request->has('has_duration');
            $model->save();
        }
    }

    public function remove(int $id)
    {
        $exerciseToRemove = Exercise::where('id', $id)->where('user_id', Auth::id())->first();
        if ($exerciseToRemove) {
            $exerciseToRemove->is_active = 0;
            $exerciseToRemove->save();
        }
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
                $query->where('user_id', Auth::id());
            }
        } else {
            $query->where(function ($q) {
                $q->whereNull('user_id')->orWhere('user_id', Auth::id());
            });
        }

        return $query->get();
    }
}
