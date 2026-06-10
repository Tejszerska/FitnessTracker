<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanItem extends Model
{
    public function plan()
    {
        return $this->belongsTo(Plan::class, "plan_id");
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, "exercise_id");
    }
}
