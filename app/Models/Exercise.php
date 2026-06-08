<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\MuscleGroup;

class Exercise extends Model
{
    protected $casts = [
        'muscle_group' => MuscleGroup::class
    ];
}
