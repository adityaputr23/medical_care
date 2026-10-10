@extends('layouts.app')

@section('title', 'MedikaCare - ' . __('Solusi Kesehatan Presisi & Penuh Kepedulian'))

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-grid">
            <div>
                <span class="badge-tag">{{ __('Klinik & Farmasi Terpercaya') }}</span>
                <h1 class="hero-title">
                    {!! str_replace('Presisi', '<span>Presisi</span>', str_replace('Penuh Kepedulian', '<span style="color: #2b5bc3">' . __('Penuh Kepedulian') . '</span>', e(__($heroHeadline)))) !!}
                </h1>
                <p class="hero-description">
                    {{ __($heroSubheadline) }}
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('doctors.index') }}" class="btn btn-primary">{{ __('Konsultasi Sekarang →') }}</a>
                    <a href="{{ route('services.show', 'general-checkup') }}" class="btn btn-outline">{{ __('Lihat Jadwal') }}</a>
                </div>
            </div>
            
            <div class="hero-image-wrapper">
                <!-- Premium High-Quality Medical Illustration/Image Mockup -->
                <div style="position: relative;">
                    <img class="hero-image" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=600" alt="MedikaCare Dokter">
                    
                    <!-- Floating Badge -->
                    <div class="floating-card">
                        <div class="floating-card-icon">
                            🛡️
                        </div>
                        <div>
                            <h4 style="font-size: 15px; font-weight: 700; color: var(--dark);">{{ __('WHO Certified') }}</h4>
                            <p style="font-size: 12px; color: var(--gray-500);">{{ __('Standar Internasional') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Unggulan -->
    <section class="container" style="padding: 100px 0;">
        <div class="section-header">
            <h2 class="section-title">{{ __('Layanan Unggulan Kami') }}</h2>
            <p class="section-subtitle">{{ __('Kami menyediakan ekosistem kesehatan lengkap mulai dari pencegahan hingga perawatan lanjutan.') }}</p>
        </div>
        
        <div class="services-grid">
            @foreach($services as $srv)
            <div class="service-card">
                <div class="service-icon">
                    @if($srv->slug === 'general-checkup')
                        🛡️
                    @elseif($srv->slug === 'pharmacy')
                        💊
                    @else
                        🔬
                    @endif
                </div>
                <h3 class="service-card-title">{{ __($srv->name) }}</h3>
                <p class="service-card-desc">{{ __($srv->description) }}</p>
                
                @if($srv->slug === 'general-checkup')
                    <a href="{{ route('services.show', $srv->slug) }}" class="service-link">{{ __('Pelajari Lebih Lanjut →') }}</a>
                @elseif($srv->slug === 'pharmacy')
                    <a href="#" class="service-link">{{ __('Cek Ketersediaan Obat →') }}</a>
                @else
                    <a href="#" class="service-link">{{ __('Lihat Paket Lab →') }}</a>
                @endif
            </div>
            @endforeach
        </div>
    </section>

    <!-- Fasilitas & Pencapaian -->
    <section style="background-color: #fafbfc; padding: 100px 0; border-top: 1px solid var(--gray-100);">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
                <div>
                    <h2 class="section-title" style="text-align: left; margin-bottom: 8px;">{{ __('Fasilitas & Pencapaian') }}</h2>
                    <p style="color: var(--gray-500); max-width: 500px;">{{ __('Dedikasi kami untuk memberikan kenyamanan dan standar medis terbaik terlihat dari setiap sudut klinik kami.') }}</p>
                </div>
                <div style="display: flex; gap: 40px;">
                    <div style="text-align: center;">
                        <h3 style="font-size: 32px; font-weight: 800; color: var(--primary);">15k+</h3>
                        <p style="font-size: 14px; color: var(--gray-500); font-weight: 600;">{{ __('Pasien Puas') }}</p>
                    </div>
                    <div style="text-align: center;">
                        <h3 style="font-size: 32px; font-weight: 800; color: var(--primary);">50+</h3>
                        <p style="font-size: 14px; color: var(--gray-500); font-weight: 600;">{{ __('Dokter Spesialis') }}</p>
                    </div>
                </div>
            </div>

            <!-- Facilities Interactive Photo Grid -->
            <div class="facilities-grid">
                <div class="facility-card col-6">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=600" alt="Executive Lounge">
                    <div class="facility-overlay">
                        <h4 class="facility-title">{{ __('Executive Lounge') }}</h4>
                        <p class="facility-desc">{{ __('Ruang tunggu premium dengan kenyamanan maksimal.') }}</p>
                    </div>
                </div>
                <div class="facility-card col-6">
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=600" alt="Lab Diagnostik">
                    <div class="facility-overlay">
                        <h4 class="facility-title">{{ __('Lab Diagnostik') }}</h4>
                        <p class="facility-desc">{{ __('Hasil analisis presisi tinggi dengan teknologi lab terdepan.') }}</p>
                    </div>
                </div>
                <div class="facility-card col-8">
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&q=80&w=800" alt="Ruang Konsultasi Privat">
                    <div class="facility-overlay">
                        <h4 class="facility-title">{{ __('Ruang Konsultasi Privat') }}</h4>
                        <p class="facility-desc">{{ __('Diskusi medis nyaman dan terjaga kerahasiaannya.') }}</p>
                    </div>
                </div>
                <div class="facility-card col-4">
                    <img src="https://images.unsplash.com/photo-1586015555751-63bb77f4322a?auto=format&fit=crop&q=80&w=400" alt="Automated Pharmacy">
                    <div class="facility-overlay">
                        <h4 class="facility-title">{{ __('Automated Pharmacy') }}</h4>
                        <p class="facility-desc">{{ __('Pengambilan obat cepat tanpa antre panjang.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Apa Kata Pasien Kami -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">{{ __('Apa Kata Pasien Kami') }}</h2>
            </div>
            
            <div class="testimonials-grid">
                @foreach($testimonials as $testi)
                <div class="testimonial-card">
                    <div class="stars">
                        @for($i = 0; $i < $testi->rating; $i++)
                            ★
                        @endfor
                    </div>
                    <p class="testimonial-content">"{{ $testi->content }}"</p>
                    
                    <div class="testimonial-author">
                        <img class="author-img" src="https://ui-avatars.com/api/?name={{ urlencode($testi->patient->name) }}&color=10439f&background=eef2f6" alt="Avatar">
                        <div>
                            <h4 class="author-name">{{ $testi->patient->name }}</h4>
                            <p class="author-role">{{ __('Pasien MedikaCare') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Butuh Konsultasi Mendesak -->
    <section class="container">
        <div class="cta-urgent">
            <div class="cta-urgent-content">
                <h2 class="cta-urgent-title">{{ __('Butuh Konsultasi Mendesak?') }}</h2>
                <p class="cta-urgent-desc">{{ __('Hubungi tim medis kami melalui chat atau kunjungi klinik kami segera untuk penanganan terbaik dan tercepat.') }}</p>
            </div>
            <div class="cta-urgent-buttons">
                <a href="https://wa.me/62811900MED" target="_blank" class="btn btn-cta-whatsapp">
                    {{ __('💬 Whatsapp Chat') }}
                </a>
                <a href="tel:+62811900MED" class="btn btn-cta-phone">
                    {{ __('📞 Telepon Sekarang') }}
                </a>
            </div>
        </div>
    </section>

@endsection
