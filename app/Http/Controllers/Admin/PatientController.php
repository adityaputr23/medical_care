<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $patients = $query->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $user = $patient->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'emergency_contact' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $patient->update([
            'date_of_birth' => $request->date_of_birth,
            'blood_type' => $request->blood_type,
            'emergency_contact' => $request->emergency_contact,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Rekam medis pasien berhasil diperbarui.');
    }
}
