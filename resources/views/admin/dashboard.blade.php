@extends('layouts.admin')

@section('title', 'Overview - Medika Admin')

@section('content')

    <!-- Admin Header -->
    <header class="admin-header">
        <div>
            <h1 class="admin-title">Systems Overview</h1>
            <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Real-time clinical metrics and resource management.</p>
        </div>
        <div class="system-status">
            <span class="status-dot"></span>
            System Status: Operational
        </div>
    </header>

    <!-- Overview Cards Grid -->
    <section class="overview-grid">
        <!-- Total Patients -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">👤</div>
                <span class="stat-badge">+12%</span>
            </div>
            <div class="stat-value">{{ number_format($totalPatients) }}</div>
            <div class="stat-label">Total Patients</div>
        </div>

        <!-- Appointments Today -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon daily">📅</div>
                <span class="stat-badge blue">Daily</span>
            </div>
            <div class="stat-value">{{ $appointmentsToday }}</div>
            <div class="stat-label">Appointments Today</div>
        </div>

        <!-- Premium Inventory Health -->
        <div class="stat-card stat-card-premium">
            <div class="stat-header">
                <div>
                    <p style="font-size: 12px; font-weight: 700; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.5px;">Inventory Health</p>
                    <h3 style="font-size: 26px; font-weight: 800; margin-top: 4px;">{{ $inventoryStability }}% Stability</h3>
                </div>
                <span class="stat-badge" style="background-color: #fee2e2; color: #b91c1c; font-size: 11px;">Critical Items: {{ $criticalInventory }}</span>
            </div>
            
            <div class="inventory-progress-wrapper">
                <div class="inventory-progress-bar">
                    <div class="inventory-progress-fill" style="width: {{ $inventoryStability }}%;"></div>
                </div>
            </div>
            
            <a href="{{ route('admin.inventory.index') }}" class="btn" style="background: rgba(255,255,255,0.15); color: white; width: 100%; margin-top: 16px; font-size: 13px; font-weight: 700;">View Supply Chain &rarr;</a>
        </div>
    </section>

    <!-- Main Dashboard Row: Doctor Management & Content Manager -->
    <div class="dashboard-grid" x-data="{ doctorModal: false, editMode: false, currentDoctor: { id: '', name: '', email: '', medical_id: '', specialty: '', experience_years: '', location: '', status: 'active', bio: '' } }">
        
        <!-- Doctor Management Panel -->
        <div class="panel-card">
            <div class="panel-header">
                <h3 class="panel-title">Doctor Management</h3>
                <div class="admin-search-wrapper">
                    <button @click="doctorModal = true; editMode = false; currentDoctor = { id: '', name: '', email: '', medical_id: '', specialty: '', experience_years: '', location: '', status: 'active', bio: '' }" class="btn btn-primary" style="padding: 8px 16px; font-size: 13px;">+ Add Doctor</button>
                </div>
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Practitioner</th>
                            <th>Specialty</th>
                            <th>Status</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doc)
                            <tr>
                                <td>
                                    <div class="row-doctor">
                                        <img class="row-doctor-img" src="https://ui-avatars.com/api/?name={{ urlencode($doc->user->name) }}&color=10439f&background=eff3fa" alt="Avatar">
                                        <div>
                                            <h4 style="font-weight: 700; color: #1e293b;">{{ $doc->user->name }}</h4>
                                            <span class="doctor-id">ID: {{ $doc->medical_id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $doc->specialty }}</td>
                                <td>
                                    <span class="status-badge {{ $doc->status }}">
                                        {{ $doc->status_badge }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px;">
                                        <button @click="doctorModal = true; editMode = true; currentDoctor = { id: '{{ $doc->id }}', name: '{{ $doc->user->name }}', email: '{{ $doc->user->email }}', medical_id: '{{ $doc->medical_id }}', specialty: '{{ $doc->specialty }}', experience_years: '{{ $doc->experience_years }}', location: '{{ $doc->location }}', status: '{{ $doc->status }}', bio: '{{ addslashes($doc->bio) }}' }" style="color: var(--admin-primary); font-size: 13px; font-weight: 700;">Edit</button>
                                        <form action="{{ route('admin.doctors.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokter ini? Akun user juga akan terhapus.');" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: var(--danger); font-size: 13px; font-weight: 700;">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 16px;">
                    {{ $doctors->links() }}
                </div>
            </div>
        </div>

        <!-- Landing Content Manager Panel -->
        <div class="panel-card">
            <div class="panel-header">
                <h3 class="panel-title">Landing Content Manager</h3>
            </div>

            <form action="{{ route('admin.landing-content.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="admin-form-group">
                    <label>Hero Headline</label>
                    <input type="text" name="hero_headline" class="admin-form-control" value="{{ $heroHeadline }}">
                </div>

                <div class="admin-form-group">
                    <label>Hero Subheadline</label>
                    <textarea name="hero_subheadline" class="admin-form-control" rows="3">{{ $heroSubheadline }}</textarea>
                </div>

                <div class="admin-form-group" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0;">
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700;">Emergency Banner</h4>
                        <p style="font-size: 12px; color: #64748b;">Tampilkan bar info darurat merah di bagian paling atas.</p>
                    </div>
                    <label class="switch" style="position: relative; display: inline-block; width: 50px; height: 26px;">
                        <input type="checkbox" name="emergency_banner" value="true" {{ $emergencyBanner === 'true' ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                        <span class="slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px;"></span>
                    </label>
                </div>

                <div class="admin-form-group" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0;">
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700;">Show Doctor Ratings</h4>
                        <p style="font-size: 12px; color: #64748b;">Tampilkan ulasan & bintang dokter di halaman pencarian.</p>
                    </div>
                    <label class="switch" style="position: relative; display: inline-block; width: 50px; height: 26px;">
                        <input type="checkbox" name="show_doctor_ratings" value="true" {{ $showDoctorRatings === 'true' ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                        <span class="slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px;"></span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 16px;">Save Settings</button>
            </form>
        </div>

        <!-- Add/Edit Doctor Modal (AlpineJS) -->
        <div class="modal-overlay" :class="{ 'open': doctorModal }">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-weight: 800; font-size: 20px;" x-text="editMode ? 'Edit Dokter' : 'Add New Doctor'"></h3>
                    <button @click="doctorModal = false" style="font-size: 24px; color: #64748b;">&times;</button>
                </div>

                <form :action="editMode ? '{{ url('admin/doctors') }}/' + currentDoctor.id : '{{ route('admin.doctors.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="admin-form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="admin-form-control" required x-model="currentDoctor.name">
                    </div>

                    <div class="admin-form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="admin-form-control" required x-model="currentDoctor.email">
                    </div>

                    <template x-if="!editMode">
                        <div class="admin-form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="admin-form-control" required placeholder="Minimal 8 karakter">
                        </div>
                    </template>

                    <div class="admin-form-group">
                        <label>Medical ID / No. Izin</label>
                        <input type="text" name="medical_id" class="admin-form-control" required placeholder="MED-XXXX" x-model="currentDoctor.medical_id">
                    </div>

                    <div class="admin-form-group">
                        <label>Spesialisasi</label>
                        <input type="text" name="specialty" class="admin-form-control" required placeholder="Cardiologist, Neurologist, etc." x-model="currentDoctor.specialty">
                    </div>

                    <div class="admin-form-group">
                        <label>Pengalaman (Tahun)</label>
                        <input type="number" name="experience_years" class="admin-form-control" required min="0" x-model="currentDoctor.experience_years">
                    </div>

                    <div class="admin-form-group">
                        <label>Lokasi Praktik</label>
                        <input type="text" name="location" class="admin-form-control" placeholder="Central Plaza, NY" x-model="currentDoctor.location">
                    </div>

                    <div class="admin-form-group">
                        <label>Status Praktik</label>
                        <select name="status" class="admin-form-control" x-model="currentDoctor.status">
                            <option value="active">Active</option>
                            <option value="on_leave">On Leave / Cuti</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label>Bio Ringkas</label>
                        <textarea name="bio" class="admin-form-control" rows="3" x-model="currentDoctor.bio"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 16px;" x-text="editMode ? 'Save Changes' : 'Create Account'"></button>
                </form>
            </div>
        </div>

    </div>

    <!-- Toggle Slider Styling Helper -->
    <style>
        .switch input:checked + .slider {
            background-color: var(--admin-primary);
        }
        .switch input:checked + .slider:before {
            transform: translateX(24px);
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
    </style>

@endsection
