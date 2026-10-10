@extends('layouts.admin')

@section('title', 'Doctor Management - Medika Admin')

@section('content')

    <header class="admin-header">
        <div>
            <h1 class="admin-title">Doctor Registry</h1>
            <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Kelola dan daftarkan dokter spesialis klinik MedikaCare.</p>
        </div>
        <form action="{{ route('admin.doctors.index') }}" method="GET" style="display: flex; gap: 12px;">
            <input type="text" name="search" class="admin-search-input" placeholder="Cari nama atau spesialis..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">Cari</button>
        </form>
    </header>

    <div class="panel-card" x-data="{ doctorModal: false, editMode: false, currentDoctor: { id: '', name: '', email: '', medical_id: '', specialty: '', experience_years: '', location: '', status: 'active', bio: '' } }">
        <div class="panel-header">
            <h3 class="panel-title">Semua Practitioner</h3>
            <button @click="doctorModal = true; editMode = false; currentDoctor = { id: '', name: '', email: '', medical_id: '', specialty: '', experience_years: '', location: '', status: 'active', bio: '' }" class="btn btn-primary">+ Add New Doctor</button>
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Practitioner</th>
                        <th>Medical ID</th>
                        <th>Specialty</th>
                        <th>Experience</th>
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
                                        <h4 style="font-weight: 700;">{{ $doc->user->name }}</h4>
                                        <span style="font-size: 12px; color: #64748b;">{{ $doc->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $doc->medical_id }}</td>
                            <td>{{ $doc->specialty }}</td>
                            <td>{{ $doc->experience_years }} Tahun</td>
                            <td>
                                <span class="status-badge {{ $doc->status }}">
                                    {{ $doc->status_badge }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button @click="doctorModal = true; editMode = true; currentDoctor = { id: '{{ $doc->id }}', name: '{{ $doc->user->name }}', email: '{{ $doc->user->email }}', medical_id: '{{ $doc->medical_id }}', specialty: '{{ $doc->specialty }}', experience_years: '{{ $doc->experience_years }}', location: '{{ $doc->location }}', status: '{{ $doc->status }}', bio: '{{ addslashes($doc->bio) }}' }" style="color: var(--admin-primary); font-weight: bold; background: none; border: none; cursor: pointer;">Edit</button>
                                    <form action="{{ route('admin.doctors.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokter ini?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: var(--danger); font-weight: bold; background: none; border: none; cursor: pointer;">Delete</button>
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

        <!-- Doctor Form Modal -->
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

@endsection
