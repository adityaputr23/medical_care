<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id', 'medical_id', 'specialty', 'experience_years',
        'rating', 'reviews_count', 'location', 'bio', 'status', 'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => 'Active',
            'on_leave' => 'On Leave',
            'inactive' => 'Inactive',
            default => 'Unknown',
        };
    }
}
