<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    // to solve Illuminate\Database\Eloquent\MassAssignmentException
    protected $fillable = [
        'workout_id',
        'exercise_id',
        'set_number',
        'weight',
        'reps',
        'duration_seconds',
        'is_superset',
        'rest_interval',
        'is_active',
    ];

    public function workout()
    {
        return $this->belongsTo(Workout::class, "workout_id");
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, "exercise_id");
    }
}
