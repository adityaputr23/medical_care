<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = ['message_id', 'consultation_id', 'medications', 'notes', 'pdf_path'];

    protected $casts = [
        'medications' => 'array',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
