<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('consultation.{id}', function ($user, $id) {
    $consultation = \App\Models\Consultation::find($id);
    if (!$consultation) {
        return false;
    }
    
    // Check if the user is the patient or the doctor in this consultation
    if ($user->role === 'patient') {
        return (int) $user->id === (int) $consultation->patient_id;
    }
    
    if ($user->role === 'doctor') {
        return (int) $user->doctor->id === (int) $consultation->doctor_id;
    }
    
    if ($user->role === 'admin') {
        return true;
    }

    return false;
});
