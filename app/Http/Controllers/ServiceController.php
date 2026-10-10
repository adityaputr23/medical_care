<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        return view('services.index', compact('services'));
    }

    public function show($slug)
    {
        $service = Service::with('plans')->where('slug', $slug)->firstOrFail();
        
        // FAQs khusus untuk General Checkup/Layanan
        $faqs = [
            [
                'question' => 'Berapa lama seluruh proses pemeriksaan berlangsung?',
                'answer' => 'Proses pemeriksaan berkisar antara 2 hingga 4 jam, tergantung pada paket yang Anda pilih. Hasil laboratorium awal biasanya selesai dalam 24 jam.'
            ],
            [
                'question' => 'Apakah asuransi saya menutupi biaya pemeriksaan?',
                'answer' => 'Kami bekerja sama dengan berbagai penyedia asuransi kesehatan utama. Harap periksa dengan bagian administrasi kami atau agen asuransi Anda sebelum kedatangan.'
            ],
            [
                'question' => 'Dapatkah saya meminta pemeriksaan tambahan untuk ditambahkan?',
                'answer' => 'Tentu saja. Anda dapat mendiskusikan kebutuhan tambahan Anda dengan dokter pendamping kami selama konsultasi awal.'
            ]
        ];

        return view('services.show', compact('service', 'faqs'));
    }
}
