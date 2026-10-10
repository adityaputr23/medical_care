<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Message;
use App\Models\Prescription;
use App\Models\Doctor;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $consultationsQuery = Consultation::with(['patient', 'doctor.user', 'latestMessage']);

        if ($user->role === 'patient') {
            $consultationsQuery->where('patient_id', $user->id);
        } elseif ($user->role === 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                $consultationsQuery->where('doctor_id', $doctor->id);
            } else {
                return redirect()->route('home')->with('error', 'Data dokter tidak ditemukan.');
            }
        } else {
            // Admin can see all active rooms
        }

        $consultations = $consultationsQuery->latest()->get();
        $activeConsultation = null;
        $messages = collect();

        if ($request->filled('room')) {
            $activeConsultation = Consultation::with(['patient', 'doctor.user', 'messages.prescription'])
                ->where('id', $request->room)
                ->first();

            if ($activeConsultation) {
                // Security check
                if ($user->role === 'patient' && $activeConsultation->patient_id !== $user->id) {
                    abort(403);
                }
                if ($user->role === 'doctor' && $activeConsultation->doctor_id !== $user->doctor->id) {
                    abort(403);
                }

                $messages = $activeConsultation->messages;
            }
        } elseif ($consultations->isNotEmpty()) {
            $activeConsultation = $consultations->first();
            $messages = $activeConsultation->messages;
        }

        return view('chat.index', compact('consultations', 'activeConsultation', 'messages'));
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'body' => 'required_without:file|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $consultation = Consultation::findOrFail($id);
        $user = Auth::user();

        // Security check
        if ($user->role === 'patient' && $consultation->patient_id !== $user->id) {
            abort(403);
        }
        if ($user->role === 'doctor' && $consultation->doctor_id !== $user->doctor->id) {
            abort(403);
        }

        $filePath = null;
        $type = 'text';

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('chat_files', 'public');
            $type = 'file';
        }

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'sender_id' => $user->id,
            'body' => $request->body ?? 'Mengirimkan berkas',
            'type' => $type,
            'file_path' => $filePath,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => [
                'id' => $message->id,
                'body' => $message->body,
                'type' => $message->type,
                'created_at' => $message->created_at->setTimezone('Asia/Jakarta')->format('H:i'),
                'sender_id' => $message->sender_id,
            ]
        ]);
    }

    public function sendPrescription(Request $request, $id)
    {
        $request->validate([
            'medications' => 'required|array|min:1',
            'medications.*.name' => 'required|string',
            'medications.*.dosage' => 'required|string',
            'medications.*.frequency' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $consultation = Consultation::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'doctor') {
            abort(403, 'Hanya dokter yang dapat memberikan resep.');
        }

        // Format message body
        $body = "Resep Obat Baru:\n";
        foreach ($request->medications as $med) {
            $body .= "- {$med['name']} ({$med['dosage']}): {$med['frequency']}\n";
        }
        if ($request->notes) {
            $body .= "Catatan: {$request->notes}";
        }

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'sender_id' => $user->id,
            'body' => $body,
            'type' => 'prescription',
        ]);

        Prescription::create([
            'message_id' => $message->id,
            'consultation_id' => $consultation->id,
            'medications' => $request->medications,
            'notes' => $request->notes,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => [
                'id' => $message->id,
                'body' => $message->body,
                'type' => $message->type,
                'created_at' => $message->created_at->setTimezone('Asia/Jakarta')->format('H:i'),
                'sender_id' => $message->sender_id,
            ]
        ]);
    }

    public function downloadPrescription($id)
    {
        $prescription = Prescription::with(['consultation.patient', 'consultation.doctor.user'])->findOrFail($id);
        
        // Simple printable HTML view for the prescription mockup
        return view('chat.prescription_pdf', compact('prescription'));
    }
}
