<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Models\ServicePlan;
use App\Models\Testimonial;
use App\Models\Inventory;
use App\Models\LandingContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@medikacare.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+62 812-3456-7890',
            'avatar' => null,
        ]);

        $doctorUsers = [
            [
                'name' => 'Dr. Sarah Jenkins',
                'email' => 'sarah.j@medikacare.com',
                'specialty' => 'Cardiologist',
                'medical_id' => 'MED-4402',
                'experience' => 12,
                'rating' => 4.9,
                'location' => 'Central Medical Plaza, NY',
                'status' => 'active',
                'bio' => 'Dr. Sarah Jenkins is an experienced Cardiologist specializing in preventive heart health and advanced cardiovascular therapies.',
            ],
            [
                'name' => 'Dr. Michael Chen',
                'email' => 'michael.c@medikacare.com',
                'specialty' => 'Cardiologist',
                'medical_id' => 'MED-1192',
                'experience' => 18,
                'rating' => 5.0,
                'location' => 'North Health Center, NY',
                'status' => 'active',
                'bio' => 'Dr. Michael Chen has over 18 years of experience treating complex heart conditions with a compassionate approach.',
            ],
            [
                'name' => 'Dr. Elena Rodriguez',
                'email' => 'elena.r@medikacare.com',
                'specialty' => 'Pediatrics',
                'medical_id' => 'MED-8821',
                'experience' => 8,
                'rating' => 4.8,
                'location' => 'Broadway Dental, NY',
                'status' => 'on_leave',
                'bio' => 'Dr. Elena Rodriguez is dedicated to providing high-quality pediatric care and ensuring children feel comfortable during visits.',
            ],
            [
                'name' => 'Dr. James Wilson',
                'email' => 'james.w@medikacare.com',
                'specialty' => 'General Physician',
                'medical_id' => 'MED-5512',
                'experience' => 15,
                'rating' => 4.7,
                'location' => 'Eastside Health, NY',
                'status' => 'active',
                'bio' => 'Dr. James Wilson is a trusted family physician focusing on holistic general health assessments and lifestyle coaching.',
            ],
            [
                'name' => 'Dr. Linda Hales',
                'email' => 'linda.h@medikacare.com',
                'specialty' => 'Neurologist',
                'medical_id' => 'MED-3341',
                'experience' => 22,
                'rating' => 4.8,
                'location' => 'NeuroCare Institute, NY',
                'status' => 'active',
                'bio' => 'Dr. Linda Hales is a renowned Neurologist specializing in neurodegenerative diseases and nerve disorders.',
            ],
            [
                'name' => 'Dr. Kevin Patel',
                'email' => 'kevin.p@medikacare.com',
                'specialty' => 'Pediatrician',
                'medical_id' => 'MED-7762',
                'experience' => 6,
                'rating' => 4.8,
                'location' => 'Little Smiles Clinic, NY',
                'status' => 'active',
                'bio' => 'Dr. Kevin Patel specializes in infant, child, and adolescent wellness and developmental care.',
            ],
        ];

        foreach ($doctorUsers as $doc) {
            $user = User::create([
                'name' => $doc['name'],
                'email' => $doc['email'],
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'phone' => '+62 811-987-' . rand(1000, 9999),
                'avatar' => null,
            ]);

            Doctor::create([
                'user_id' => $user->id,
                'medical_id' => $doc['medical_id'],
                'specialty' => $doc['specialty'],
                'experience_years' => $doc['experience'],
                'rating' => $doc['rating'],
                'reviews_count' => rand(50, 150),
                'location' => $doc['location'],
                'bio' => $doc['bio'],
                'status' => $doc['status'],
            ]);
        }

        // Create sample patients
        $patient1 = User::create([
            'name' => 'Santi Rahmawati',
            'email' => 'santi@example.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '+62 899-2234-5678',
        ]);
        Patient::create([
            'user_id' => $patient1->id,
            'date_of_birth' => '1995-04-12',
            'blood_type' => 'AB+',
            'address' => 'Jl. Kesehatan No. 12, Jakarta',
        ]);

        $patient2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '+62 878-1122-3344',
        ]);
        Patient::create([
            'user_id' => $patient2->id,
            'date_of_birth' => '1988-11-20',
            'blood_type' => 'O+',
            'address' => 'Jl. Sudirman No. 45, Jakarta',
        ]);

        $patient3 = User::create([
            'name' => 'H. Ahmad Fauzi',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '+62 852-9988-7766',
        ]);
        Patient::create([
            'user_id' => $patient3->id,
            'date_of_birth' => '1965-07-07',
            'blood_type' => 'A+',
            'address' => 'Jl. Melati No. 8, Bandung',
        ]);

        // 2. Services & Service Plans
        $srv1 = Service::create([
            'name' => 'General Checkup',
            'slug' => 'general-checkup',
            'description' => 'Pemeriksaan kesehatan menyeluruh untuk mendeteksi risiko penyakit sejak dini dengan akurasi tinggi.',
            'icon' => 'shield-check',
            'sort_order' => 1,
        ]);

        ServicePlan::create([
            'service_id' => $srv1->id,
            'name' => 'Standard',
            'features' => ['Core Blood Profile (20 Parameters)', 'Cardiology Consultation'],
            'price' => 199.00,
            'is_recommended' => false,
            'sort_order' => 1,
        ]);

        ServicePlan::create([
            'service_id' => $srv1->id,
            'name' => 'Premium Wellness',
            'features' => ['Core Blood Profile (20 Parameters)', 'Cardiology Consultation', 'Whole Body MRI | CT Scan'],
            'price' => 349.00,
            'is_recommended' => true,
            'sort_order' => 2,
        ]);

        ServicePlan::create([
            'service_id' => $srv1->id,
            'name' => 'Executive',
            'features' => ['Core Blood Profile (20 Parameters)', 'Cardiology Consultation', 'Whole Body MRI | CT Scan', 'Advanced Diagnostic Screening', 'Fast-Track Results (24h)'],
            'price' => 799.00,
            'is_recommended' => false,
            'sort_order' => 3,
        ]);

        Service::create([
            'name' => 'Pharmacy',
            'slug' => 'pharmacy',
            'description' => 'Layanan farmasi 24 jam dengan ketersediaan obat lengkap dan apoteker profesional yang siap membantu.',
            'icon' => 'pill',
            'sort_order' => 2,
        ]);

        Service::create([
            'name' => 'Lab Tests',
            'slug' => 'lab-tests',
            'description' => 'Hasil laboratorium presisi tinggi dengan waktu tunggu minimal untuk mendukung diagnosa medis Anda.',
            'icon' => 'test-tube',
            'sort_order' => 3,
        ]);

        // 3. Testimonials
        Testimonial::create([
            'patient_id' => $patient1->id,
            'rating' => 5,
            'content' => 'Pelayanan di MedikaCare sangat cepat. Dokter sangat detail menjelaskan kondisi saya tanpa membuat saya merasa terburu-buru. Fasilitasnya juga sangat bersih!',
            'is_featured' => true,
        ]);

        Testimonial::create([
            'patient_id' => $patient2->id,
            'rating' => 5,
            'content' => 'Layanan farmasi 24 jamnya sangat menolong saat keadaan darurat. Stok obat lengkap dan harganya bersahabat. Sangat merekomendasikan MedikaCare.',
            'is_featured' => true,
        ]);

        Testimonial::create([
            'patient_id' => $patient3->id,
            'rating' => 5,
            'content' => 'Proses booking online sangat mudah! Tidak perlu antre lama karena jadwalnya sangat on-time. Terima kasih MedikaCare atas profesionalitasnya.',
            'is_featured' => true,
        ]);

        // 4. Inventory
        Inventory::create([
            'name' => 'Amoxicillin 500mg',
            'category' => 'Obat-obatan',
            'quantity' => 150,
            'unit' => 'tablet',
            'critical_level' => 20,
            'price' => 15.00,
        ]);

        Inventory::create([
            'name' => 'Paracetamol 500mg',
            'category' => 'Obat-obatan',
            'quantity' => 400,
            'unit' => 'tablet',
            'critical_level' => 50,
            'price' => 5.00,
        ]);

        Inventory::create([
            'name' => 'Surgical Masks Box',
            'category' => 'Alat Pelindung Diri',
            'quantity' => 12,
            'unit' => 'box',
            'critical_level' => 30,
            'price' => 45.00,
        ]);

        Inventory::create([
            'name' => 'Syringes 3ml',
            'category' => 'Peralatan Medis',
            'quantity' => 4,
            'unit' => 'pcs',
            'critical_level' => 20,
            'price' => 12.00,
        ]);

        Inventory::create([
            'name' => 'Oxygen Tanks',
            'category' => 'Tabung Oksigen',
            'quantity' => 0,
            'unit' => 'tabung',
            'critical_level' => 5,
            'price' => 150.00,
        ]);

        // 5. Landing Contents
        LandingContent::setValue('hero_headline', 'Solusi Kesehatan Presisi & Penuh Kepedulian.');
        LandingContent::setValue('hero_subheadline', 'MedikaCare menghadirkan layanan medis kelas dunia dengan teknologi terkini untuk memastikan kesehatan Anda dan keluarga tetap terjaga dengan aman.');
        LandingContent::setValue('emergency_banner', 'true');
        LandingContent::setValue('show_doctor_ratings', 'true');
        LandingContent::setValue('hero_bg_image', '');
    }
}
