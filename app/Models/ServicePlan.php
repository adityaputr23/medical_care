<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePlan extends Model
{
    protected $fillable = ['service_id', 'name', 'features', 'price', 'is_recommended', 'sort_order'];

    protected $casts = [
        'features' => 'array',
        'is_recommended' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
