@extends('layouts.admin')

@section('title', 'Appointments Management - Medika Admin')

@section('content')

    <header class="admin-header">
        <div>
            <h1 class="admin-title">Appointments Management</h1>
            <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Kelola, jadwalkan, dan konfirmasi janji temu pasien dengan dokter.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline" style="font-size: 13px; padding: 6px 12px;">Semua</a>
            <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="btn btn-outline" style="font-size: 13px; padding: 6px 12px; border-color: #d97706; color: #d97706;">Pending</a>
            <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}" class="btn btn-outline" style="font-size: 13px; padding: 6px 12px; border-color: #065f46; color: #065f46;">Confirmed</a>
        </div>
    </header>

    <div class="panel-card">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Dokter Spesialis</th>
                        <th>Jadwal Konsultasi</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $app)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($app->patient->name) }}&color=10439f&background=eff3fa" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" alt="Pasien">
                                    <div>
                                        <h4 style="font-weight: 700; color: #1e293b;">{{ $app->patient->name }}</h4>
                                        <span style="font-size: 11px; color: #64748b;">Pasien</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($app->doctor->user->name) }}&color=10439f&background=eff3fa" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;" alt="Dokter">
                                    <div>
                                        <h4 style="font-weight: 600; color: #1e293b; font-size: 13px;">{{ $app->doctor->user->name }}</h4>
                                        <span style="font-size: 11px; color: #64748b;">{{ $app->doctor->specialty }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p style="font-weight: 700; font-size: 14px;">{{ $app->appointment_date->format('d M Y') }}</p>
                                <p style="font-size: 12px; color: #64748b;">Pukul {{ date('H:i', strtotime($app->appointment_time)) }}</p>
                            </td>
                            <td>
                                <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: {{ $app->type === 'online' ? 'var(--admin-primary)' : '#008080' }}">
                                    {{ $app->type }}
                                </span>
                            </td>
                            <td>
                                @if($app->status === 'pending')
                                    <span class="status-badge" style="background-color: #fef3c7; color: #d97706;">Pending</span>
                                @elseif($app->status === 'confirmed')
                                    <span class="status-badge" style="background-color: #d1fae5; color: #065f46;">Confirmed</span>
                                @elseif($app->status === 'completed')
                                    <span class="status-badge" style="background-color: #e0f2fe; color: #0369a1;">Completed</span>
                                @else
                                    <span class="status-badge" style="background-color: #fee2e2; color: #991b1b;">Cancelled</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if($app->status === 'pending')
                                    <form action="{{ route('admin.appointments.status', $app->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">Approve</button>
                                    </form>

                                    <form action="{{ route('admin.appointments.status', $app->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px; border-color: var(--danger); color: var(--danger);">Decline</button>
                                    </form>
                                @elseif($app->status === 'confirmed')
                                    <form action="{{ route('admin.appointments.status', $app->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px; border-color: var(--success); color: var(--success);">Mark Completed</button>
                                    </form>
                                @else
                                    <span style="font-size: 12px; color: #94a3b8; font-weight: bold;">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 16px;">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>

@endsection
