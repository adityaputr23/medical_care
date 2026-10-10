<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['doctor.user'])
            ->where('patient_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function cancel($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', Auth::id())
            ->firstOrFail();

        if ($appointment->status === 'pending') {
            $appointment->update(['status' => 'cancelled']);
            return back()->with('success', 'Janji temu berhasil dibatalkan.');
        }

        return back()->with('error', 'Janji temu tidak dapat dibatalkan.');
    }
}
