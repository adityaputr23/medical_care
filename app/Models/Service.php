<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'hero_image', 'is_active', 'sort_order'];

    public function plans()
    {
        return $this->hasMany(ServicePlan::class)->orderBy('sort_order');
    }
}
