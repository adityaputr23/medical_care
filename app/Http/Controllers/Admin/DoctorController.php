<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('user');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('specialty', 'like', "%{$search}%");
        }

        $doctors = $query->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'medical_id' => 'required|string|unique:doctors',
            'specialty' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'location' => 'nullable|string',
            'status' => 'required|in:active,on_leave,inactive',
            'bio' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'medical_id' => $request->medical_id,
            'specialty' => $request->specialty,
            'experience_years' => $request->experience_years,
            'location' => $request->location,
            'status' => $request->status,
            'bio' => $request->bio,
        ]);

        return back()->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $user = $doctor->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'medical_id' => 'required|string|unique:doctors,medical_id,' . $doctor->id,
            'specialty' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'location' => 'nullable|string',
            'status' => 'required|in:active,on_leave,inactive',
            'bio' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $doctor->update([
            'medical_id' => $request->medical_id,
            'specialty' => $request->specialty,
            'experience_years' => $request->experience_years,
            'location' => $request->location,
            'status' => $request->status,
            'bio' => $request->bio,
        ]);

        return back()->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $user = $doctor->user;
        
        $doctor->delete();
        $user->delete();

        return back()->with('success', 'Dokter berhasil dihapus.');
    }
}
