<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    public function workout()
    {
        return $this->belongsTo(Workout::class, "workout_id");
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, "exercise_id");
    }
}
