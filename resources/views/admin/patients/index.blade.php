@extends('layouts.admin')

@section('title', 'Patient Records - Medika Admin')

@section('content')

    <header class="admin-header">
        <div>
            <h1 class="admin-title">Patient Records</h1>
            <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Kelola riwayat rekam medis dasar dan informasi darurat pasien.</p>
        </div>
        <form action="{{ route('admin.patients.index') }}" method="GET" style="display: flex; gap: 12px;">
            <input type="text" name="search" class="admin-search-input" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">Cari</button>
        </form>
    </header>

    <div class="panel-card" x-data="{ patientModal: false, currentPatient: { id: '', name: '', phone: '', date_of_birth: '', blood_type: '', emergency_contact: '', address: '' } }">
        
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>No. Telp</th>
                        <th>Tgl Lahir</th>
                        <th>Gol. Darah</th>
                        <th>Emergency Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $pat)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($pat->user->name) }}&color=10439f&background=eff3fa" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" alt="Avatar">
                                    <div>
                                        <h4 style="font-weight: 700; color: #1e293b;">{{ $pat->user->name }}</h4>
                                        <span style="font-size: 12px; color: #64748b;">{{ $pat->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $pat->user->phone ?? '-' }}</td>
                            <td>{{ $pat->date_of_birth ? date('d M Y', strtotime($pat->date_of_birth)) : '-' }}</td>
                            <td>
                                @if($pat->blood_type)
                                    <span class="status-badge active" style="background-color: #fee2e2; color: #b91c1c;">{{ $pat->blood_type }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $pat->emergency_contact ?? '-' }}</td>
                            <td>
                                <button @click="patientModal = true; currentPatient = { id: '{{ $pat->id }}', name: '{{ $pat->user->name }}', phone: '{{ $pat->user->phone }}', date_of_birth: '{{ $pat->date_of_birth }}', blood_type: '{{ $pat->blood_type }}', emergency_contact: '{{ $pat->emergency_contact }}', address: '{{ addslashes($pat->address) }}' }" style="color: var(--admin-primary); font-weight: bold; background: none; border: none; cursor: pointer;">Edit Rekam Medis</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 16px;">
                {{ $patients->links() }}
            </div>
        </div>

        <!-- Edit Patient Medical Info Modal (AlpineJS) -->
        <div class="modal-overlay" :class="{ 'open': patientModal }">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-weight: 800; font-size: 20px; color: var(--dark);">Edit Informasi Medis Pasien</h3>
                    <button @click="patientModal = false" style="font-size: 24px; color: #64748b;">&times;</button>
                </div>

                <form :action="'{{ url('admin/patients') }}/' + currentPatient.id" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="admin-form-group">
                        <label>Nama Pasien</label>
                        <input type="text" name="name" class="admin-form-control" required x-model="currentPatient.name">
                    </div>

                    <div class="admin-form-group">
                        <label>No. Telepon / HP</label>
                        <input type="text" name="phone" class="admin-form-control" x-model="currentPatient.phone">
                    </div>

                    <div class="admin-form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" class="admin-form-control" x-model="currentPatient.date_of_birth">
                    </div>

                    <div class="admin-form-group">
                        <label>Golongan Darah</label>
                        <select name="blood_type" class="admin-form-control" x-model="currentPatient.blood_type">
                            <option value="">Pilih Golongan Darah</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label>Kontak Darurat (Emergency Contact)</label>
                        <input type="text" name="emergency_contact" class="admin-form-control" placeholder="Nama / Hubungan - No HP" x-model="currentPatient.emergency_contact">
                    </div>

                    <div class="admin-form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="address" class="admin-form-control" rows="3" x-model="currentPatient.address"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 16px;">Simpan Rekam Medis</button>
                </form>
            </div>
        </div>

    </div>

@endsection
