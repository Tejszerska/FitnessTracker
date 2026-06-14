<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public function planItems()
    {
        return $this->hasMany(PlanItem::class, 'plan_id')
            ->where('is_active', true)
            ->orderBy('order', 'asc');
    }
    
}
