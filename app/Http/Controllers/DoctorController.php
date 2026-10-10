<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('user')->where('status', '!=', 'inactive');

        // Search by name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('specialty', 'like', "%{$search}%");
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Filter by Specialty
        if ($request->filled('specialties')) {
            $query->whereIn('specialty', $request->specialties);
        }

        // Filter by Experience
        if ($request->filled('experience')) {
            $exp = $request->experience;
            if ($exp === '5') {
                $query->where('experience_years', '>=', 5);
            } elseif ($exp === '10') {
                $query->where('experience_years', '>=', 10);
            } elseif ($exp === '20') {
                $query->where('experience_years', '>=', 20);
            }
        }

        $doctors = $query->paginate(12);

        // Get specialties list for filter sidebar
        $allSpecialties = ['General Physician', 'Pediatrician', 'Cardiologist', 'Neurologist', 'Pediatrics'];

        return view('doctors.index', compact('doctors', 'allSpecialties'));
    }

    public function book(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'type' => 'required|in:online,offline',
            'notes' => 'nullable|string',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk memesan konsultasi.');
        }

        $appointment = Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'type' => $request->type,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil dipesan! Menunggu konfirmasi dari dokter/admin.');
    }
}
