@extends('layouts.app')

@section('title', $service->name . ' - MedikaCare')

@section('content')

    <!-- Hero Header -->
    <section class="hero-section" style="padding: 60px 0;">
        <div class="container hero-grid">
            <div>
                <span class="badge-tag">Layanan Kami &rsaquo; {{ $service->name }}</span>
                <h1 class="hero-title" style="font-size: 44px; margin-bottom: 20px;">
                    Pemeriksaan <span style="color: var(--primary);">Kesehatan</span> Komprehensif
                </h1>
                <p class="hero-description" style="margin-bottom: 30px;">
                    Pendekatan proaktif untuk kesehatan Anda. Skrining 360° yang dirancang khusus untuk mendeteksi potensi masalah sejak dini dan memberikan peta jalan yang jelas untuk kebugaran jangka panjang Anda.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('doctors.index') }}" class="btn btn-primary">Pesan Paket Sekarang</a>
                    <a href="#" class="btn btn-outline">Unduh Brosur (PDF)</a>
                </div>
            </div>
            <div>
                <img class="hero-image" src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&q=80&w=600" alt="MedikaCare Service">
            </div>
        </div>
    </section>

    <!-- Why Checkup Matters Section -->
    <section class="container" style="padding: 80px 0;">
        <div class="section-header">
            <h2 class="section-title">Mengapa Pemeriksaan Rutin Itu Penting?</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px;">
            <div style="background: white; border: 1px solid var(--gray-200); padding: 32px; border-radius: 16px;">
                <span style="font-size: 28px;">🩺</span>
                <h4 style="font-size: 18px; font-weight: 700; margin: 16px 0 8px 0;">Skrining Diagnostik Canggih</h4>
                <p style="color: var(--gray-500); font-size: 14px;">Kami menggunakan alat diagnostik berbasis AI terbaru untuk menganalisis biomarker darah, kesehatan jantung, dan fungsi metabolisme dengan akurasi 99,8%.</p>
            </div>
            <div style="background: #008080; color: white; padding: 32px; border-radius: 16px;">
                <span style="font-size: 28px;">🧠</span>
                <h4 style="font-size: 18px; font-weight: 700; margin: 16px 0 8px 0; color: white;">Kesehatan Mental & Fisik</h4>
                <p style="opacity: 0.9; font-size: 14px;">Tinjauan komprehensif mencakup penilaian stres dan skrining neurologis untuk memastikan pikiran Anda sehat seperti tubuh Anda.</p>
            </div>
            <div style="background: white; border: 1px solid var(--gray-200); padding: 32px; border-radius: 16px;">
                <span style="font-size: 28px;">⚡</span>
                <h4 style="font-size: 18px; font-weight: 700; margin: 16px 0 8px 0;">Hasil Cepat</h4>
                <p style="color: var(--gray-500); font-size: 14px;">Dapatkan catatan kesehatan digital lengkap Anda melalui aplikasi MedikaCare kami yang aman dalam waktu 24 jam setelah janji temu Anda.</p>
            </div>
        </div>
    </section>

    <!-- How to Prepare Section (Darker theme matches UI screenshot 3) -->
    <section style="background-color: #0f172a; color: white; padding: 80px 0;">
        <div class="container" style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 48px; align-items: center;">
            <div>
                <h2 style="font-size: 32px; font-weight: 800; margin-bottom: 20px;">Bagaimana Cara <span style="color: var(--theme-cyan);">Mempersiapkan Diri</span></h2>
                <p style="opacity: 0.8; margin-bottom: 30px; font-size: 15px;">Ikuti langkah-langkah penting ini untuk memastikan hasil tes Anda akurat dan memberikan wawasan terbaik bagi dokter kami.</p>
                <div style="background-color: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border-left: 4px solid var(--theme-cyan);">
                    <p style="font-size: 14px; font-weight: 600; color: var(--theme-cyan);">Tip Pro:</p>
                    <p style="font-size: 13px; opacity: 0.8; margin-top: 4px;">Kenakan pakaian longgar dan catat obat-obatan yang sedang Anda konsumsi saat ini.</p>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div style="display: flex; gap: 20px; align-items: flex-start;">
                    <div style="background-color: var(--theme-cyan); color: #0f172a; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">1</div>
                    <div>
                        <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 6px;">Puasa 10-12 Jam</h4>
                        <p style="opacity: 0.7; font-size: 14px;">Jangan makan atau minum apapun (kecuali air putih) mulai malam hari sebelum pemeriksaan Anda yang dijadwalkan.</p>
                    </div>
                </div>
                <div style="display: flex; gap: 20px; align-items: flex-start;">
                    <div style="background-color: var(--theme-cyan); color: #0f172a; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">2</div>
                    <div>
                        <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 6px;">Tetap Hidrasi Dengan Baik</h4>
                        <p style="opacity: 0.7; font-size: 14px;">Minum banyak air putih sebelum pengambilan sampel darah membantu melancarkan proses pengambilan darah.</p>
                    </div>
                </div>
                <div style="display: flex; gap: 20px; align-items: flex-start;">
                    <div style="background-color: var(--theme-cyan); color: #0f172a; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">3</div>
                    <div>
                        <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 6px;">Dokumen Rekam Medis</h4>
                        <p style="opacity: 0.7; font-size: 14px;">Bawa riwayat/rekam medis Anda atau unggah ke aplikasi MedikaCare sebelum kedatangan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing / Plans Section -->
    <section class="container" style="padding: 100px 0;">
        <div class="section-header">
            <h2 class="section-title">Pilih Paket Anda</h2>
            <p class="section-subtitle">Harga transparan untuk layanan kesehatan premium terpercaya Anda.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
            @foreach($service->plans as $plan)
            <div style="background: white; border: 1px solid {{ $plan->is_recommended ? 'var(--primary)' : 'var(--gray-200)' }}; padding: 48px 32px; border-radius: 16px; position: relative; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; justify-content: space-between; {{ $plan->is_recommended ? 'transform: scale(1.03);' : '' }}">
                @if($plan->is_recommended)
                    <div style="position: absolute; top: -16px; left: 50%; transform: translateX(-50%); background-color: var(--primary); color: white; padding: 4px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; text-transform: uppercase;">Direkomendasikan</div>
                @endif

                <div>
                    <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 12px; text-align: center;">{{ $plan->name }}</h3>
                    <div style="font-size: 40px; font-weight: 800; color: var(--dark); text-align: center; margin: 24px 0;">
                        ${{ number_format($plan->price, 0) }}
                    </div>
                    
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px; padding: 0 10px;">
                        @foreach($plan->features as $feature)
                            <li style="display: flex; gap: 12px; font-size: 14px; color: var(--gray-500);">
                                <span style="color: var(--success); font-weight: bold;">✓</span> {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <a href="{{ route('doctors.index') }}" class="btn {{ $plan->is_recommended ? 'btn-primary' : 'btn-outline' }}" style="width: 100%;">Pilih Paket {{ $plan->name }}</a>
            </div>
            @endforeach
        </div>
    </section>

    <!-- FAQ Section -->
    <section style="background-color: #f8fafc; padding: 100px 0; border-top: 1px solid var(--gray-200);">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            </div>
            
            <div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 16px;" x-data="{ active: null }">
                @foreach($faqs as $index => $faq)
                <div style="background: white; border-radius: 12px; border: 1px solid var(--gray-200); overflow: hidden;">
                    <button @click="active = (active === {{ $index }} ? null : {{ $index }})" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 24px; text-align: left; font-weight: 700; font-size: 16px; color: var(--dark);">
                        {{ $faq['question'] }}
                        <span x-show="active !== {{ $index }}">&darr;</span>
                        <span x-show="active === {{ $index }}">&uarr;</span>
                    </button>
                    <div x-show="active === {{ $index }}" x-transition style="padding: 0 24px 24px 24px; color: var(--gray-500); font-size: 15px; line-height: 1.6;">
                        {{ $faq['answer'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
