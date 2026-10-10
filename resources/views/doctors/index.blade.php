@extends('layouts.app')

@section('title', __('Temukan Dokter Spesialis Terbaik') . ' - MedikaCare')

@section('content')

    <!-- Header & Search bar -->
    <section style="background-color: var(--primary-light); padding: 80px 0 60px 0;">
        <div class="container" style="text-align: center;">
            <h1 style="font-size: 40px; font-weight: 800; margin-bottom: 16px;">{{ __('Temukan Dokter Spesialis Terbaik') }}</h1>
            <p style="color: var(--gray-500); margin-bottom: 40px; font-size: 16px;">{{ __('Pesan janji temu dengan profesional medis kelas dunia yang disesuaikan dengan kebutuhan Anda.') }}</p>
            
            <form action="{{ route('doctors.index') }}" method="GET" class="search-bar-container" style="max-width: 900px; margin: 0 auto;">
                <div class="search-input-group">
                    <span>🔍</span>
                    <input type="text" name="search" placeholder="{{ __('Cari nama dokter atau spesialisasi...') }}" value="{{ request('search') }}">
                </div>
                <div class="search-input-group">
                    <span>📍</span>
                    <input type="text" name="location" placeholder="{{ __('Lokasi (misal: New York, NY)') }}" value="{{ request('location') }}">
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">{{ __('Cari Dokter') }}</button>
            </form>
        </div>
    </section>

    <!-- Main Listing Grid -->
    <section class="container" style="padding: 60px 0;" x-data="{ bookingModal: false, selectedDoctor: null, selectedDoctorName: '' }">
        <div style="display: grid; grid-template-columns: 280px 1fr; gap: 40px;">
            
            <!-- Sidebar Filter -->
            <form action="{{ route('doctors.index') }}" method="GET">
                <div style="background: white; border: 1px solid var(--gray-200); padding: 24px; border-radius: 16px; position: sticky; top: 100px;">
                    <h3 style="font-size: 16px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 24px;">{{ __('Filter Pencarian') }}</h3>
                    
                    <!-- Specialties Filter -->
                    <div style="margin-bottom: 32px;">
                        <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 16px; color: var(--dark);">{{ __('Spesialisasi') }}</h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach($allSpecialties as $spec)
                                <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--gray-500); cursor: pointer;">
                                    <input type="checkbox" name="specialties[]" value="{{ $spec }}" 
                                        {{ is_array(request('specialties')) && in_array($spec, request('specialties')) ? 'checked' : '' }}>
                                    {{ __($spec) }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Experience Filter -->
                    <div style="margin-bottom: 32px;">
                        <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 16px; color: var(--dark);">{{ __('Pengalaman') }}</h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--gray-500); cursor: pointer;">
                                <input type="radio" name="experience" value="" {{ request('experience') == '' ? 'checked' : '' }}> {{ __('Semua') }}
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--gray-500); cursor: pointer;">
                                <input type="radio" name="experience" value="5" {{ request('experience') == '5' ? 'checked' : '' }}> 5+ {{ __('Tahun') }}
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--gray-500); cursor: pointer;">
                                <input type="radio" name="experience" value="10" {{ request('experience') == '10' ? 'checked' : '' }}> 10+ {{ __('Tahun') }}
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--gray-500); cursor: pointer;">
                                <input type="radio" name="experience" value="20" {{ request('experience') == '20' ? 'checked' : '' }}> 20+ {{ __('Tahun') }}
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">{{ __('Terapkan Filter') }}</button>
                    <a href="{{ route('doctors.index') }}" class="btn btn-outline" style="width: 100%; margin-top: 10px;">{{ __('Reset Filter') }}</a>
                </div>
            </form>

            <!-- Listing Cards Grid -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <p style="color: var(--gray-500); font-weight: 600;">{{ __('Menampilkan') }} {{ $doctors->count() }} {{ __('dari') }} {{ $doctors->total() }} {{ __('dokter spesialis') }}</p>
                </div>
                
                @if($doctors->isEmpty())
                    <div style="text-align: center; padding: 80px 0; background: white; border-radius: 16px; border: 1px solid var(--gray-200);">
                        <span style="font-size: 48px;">🔍</span>
                        <h3 style="margin-top: 16px; font-weight: 700;">{{ __('Dokter Tidak Ditemukan') }}</h3>
                        <p style="color: var(--gray-500); margin-top: 8px;">{{ __('Coba gunakan kata kunci pencarian atau filter spesialisasi yang berbeda.') }}</p>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                        @foreach($doctors as $doc)
                            <div class="doctor-card">
                                <img class="doctor-card-img" src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=300" alt="{{ $doc->user->name }}">
                                <div class="doctor-card-body">
                                    <span class="doctor-specialty">{{ __($doc->specialty) }}</span>
                                    <h3 class="doctor-name">{{ $doc->user->name }}</h3>
                                    
                                    <div class="doctor-meta">
                                        <div class="doctor-meta-item">
                                            <span>💼</span> {{ $doc->experience_years }} {{ __('Tahun Pengalaman') }}
                                        </div>
                                        <div class="doctor-meta-item">
                                            <span>⭐</span> {{ $doc->rating }} ({{ $doc->reviews_count }} {{ __('Ulasan') }})
                                        </div>
                                        <div class="doctor-meta-item">
                                            <span>📍</span> {{ $doc->location ?? 'Klinik MedikaCare' }}
                                        </div>
                                    </div>
                                    
                                    <button @click="bookingModal = true; selectedDoctor = {{ $doc->id }}; selectedDoctorName = '{{ $doc->user->name }}'" class="btn btn-primary" style="width: 100%;">{{ __('Pesan Janji Temu') }}</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div style="margin-top: 40px;">
                        {{ $doctors->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Appointment Booking Modal (AlpineJS) -->
        <div class="modal-overlay" :class="{ 'open': bookingModal }">
            <div class="modal-content" @click.away="bookingModal = false">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-weight: 800; font-size: 20px; color: var(--dark);">{{ __('Pesan Janji Temu') }}</h3>
                    <button @click="bookingModal = false" style="font-size: 24px; color: var(--gray-500);">&times;</button>
                </div>
                
                <p style="margin-bottom: 20px; font-weight: 600; color: var(--gray-500);">{{ __('Dokter Pendamping:') }} <span style="color: var(--primary);" x-text="selectedDoctorName"></span></p>
                
                <form action="{{ route('doctors.book') }}" method="POST">
                    @csrf
                    <input type="hidden" name="doctor_id" :value="selectedDoctor">
                    
                    <div class="admin-form-group">
                        <label>{{ __('Pilih Tanggal') }}</label>
                        <input type="date" name="appointment_date" class="admin-form-control" required min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="admin-form-group">
                        <label>{{ __('Pilih Waktu') }}</label>
                        <input type="time" name="appointment_time" class="admin-form-control" required>
                    </div>

                    <div class="admin-form-group">
                        <label>{{ __('Tipe Konsultasi') }}</label>
                        <select name="type" class="admin-form-control" required>
                            <option value="online">{{ __('Tatap Muka Online (Chat/Video)') }}</option>
                            <option value="offline">{{ __('Datang Langsung ke Klinik') }}</option>
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label>{{ __('Catatan Keluhan / Kebutuhan') }}</label>
                        <textarea name="notes" class="admin-form-control" rows="3" placeholder="{{ __('Deskripsikan secara singkat gejala atau kebutuhan Anda...') }}"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 16px;">{{ __('Konfirmasi Pemesanan') }}</button>
                </form>
            </div>
        </div>

    </section>

@endsection
