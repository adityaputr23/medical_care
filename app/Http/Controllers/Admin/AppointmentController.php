<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor.user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->latest()->paginate(15);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $oldStatus = $appointment->status;
        $appointment->status = $request->status;
        $appointment->save();

        // If newly confirmed, create a consultation chat room
        if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
            // Check if there is already an active consultation for this patient and doctor
            $existing = Consultation::where('patient_id', $appointment->patient_id)
                ->where('doctor_id', $appointment->doctor_id)
                ->where('status', '!=', 'closed')
                ->first();

            if (!$existing) {
                Consultation::create([
                    'appointment_id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'status' => 'open',
                    'started_at' => Carbon::now(),
                ]);
            }
        }

        return back()->with('success', 'Status janji temu berhasil diperbarui.');
    }
}
