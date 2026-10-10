<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\LandingContent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::with(['patient'])->where('is_featured', true)->get();
        
        $heroHeadline = LandingContent::getValue('hero_headline', 'Solusi Kesehatan Presisi & Penuh Kepedulian.');
        $heroSubheadline = LandingContent::getValue('hero_subheadline', 'MedikaCare menghadirkan layanan medis kelas dunia dengan teknologi terkini...');
        $emergencyBanner = LandingContent::getValue('emergency_banner', 'true') === 'true';

        return view('home.index', compact('services', 'testimonials', 'heroHeadline', 'heroSubheadline', 'emergencyBanner'));
    }
}
