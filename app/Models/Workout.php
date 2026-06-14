<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    public function sets()
    {
        return $this->hasMany(Set::class, 'workout_id')
            ->where('is_active', true);
    }
}
