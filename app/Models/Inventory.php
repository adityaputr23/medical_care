<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = ['name', 'category', 'quantity', 'unit', 'critical_level', 'status', 'price'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            if ($item->quantity <= 0) {
                $item->status = 'out_of_stock';
            } elseif ($item->quantity <= $item->critical_level / 2) {
                $item->status = 'critical';
            } elseif ($item->quantity <= $item->critical_level) {
                $item->status = 'low';
            } else {
                $item->status = 'available';
            }
        });
    }
}
