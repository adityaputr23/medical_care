<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Inventory;
use App\Models\LandingContent;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = User::where('role', 'patient')->count();
        $appointmentsToday = Appointment::whereDate('appointment_date', Carbon::today())->count();
        
        // Inventory stability calculation
        $totalInventory = Inventory::count();
        $criticalInventory = Inventory::where('quantity', '<=', \DB::raw('critical_level'))->count();
        $inventoryStability = $totalInventory > 0 ? round((($totalInventory - $criticalInventory) / $totalInventory) * 100) : 100;

        $doctors = Doctor::with('user')->paginate(5);

        // Landing content configurations
        $heroHeadline = LandingContent::getValue('hero_headline', 'Solusi Kesehatan Presisi & Penuh Kepedulian.');
        $heroSubheadline = LandingContent::getValue('hero_subheadline', '');
        $emergencyBanner = LandingContent::getValue('emergency_banner', 'true');
        $showDoctorRatings = LandingContent::getValue('show_doctor_ratings', 'true');

        return view('admin.dashboard', compact(
            'totalPatients', 'appointmentsToday', 'inventoryStability', 'criticalInventory', 
            'doctors', 'heroHeadline', 'heroSubheadline', 'emergencyBanner', 'showDoctorRatings'
        ));
    }
}
