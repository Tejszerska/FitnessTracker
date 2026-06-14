<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    // allow Mass Assignment
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

    public function sets()
    {
        return $this->hasMany(Set::class, 'workout_id')
            ->where('is_active', true);
    }
}
