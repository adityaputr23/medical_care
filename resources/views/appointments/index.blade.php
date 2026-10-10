@extends('layouts.app')

@section('title', __('Riwayat Janji Temu Saya') . ' - MedikaCare')

@section('content')

    <section style="background-color: var(--primary-light); padding: 60px 0 40px 0;">
        <div class="container">
            <h1 style="font-size: 32px; font-weight: 800; margin-bottom: 8px;">{{ __('Riwayat Janji Temu Saya') }}</h1>
            <p style="color: var(--gray-500); font-size: 15px;">{{ __('Pantau status pemesanan layanan kesehatan Anda.') }}</p>
        </div>
    </section>

    <section class="container" style="padding: 60px 0;">
        <div style="background: white; border: 1px solid var(--gray-200); border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-sm);">
            @if($appointments->isEmpty())
                <div style="text-align: center; padding: 60px 24px;">
                    <span style="font-size: 48px;">📅</span>
                    <h3 style="margin-top: 16px; font-weight: 700;">{{ __('Belum Ada Janji Temu') }}</h3>
                    <p style="color: var(--gray-500); margin-top: 8px; margin-bottom: 24px;">{{ __('Anda belum melakukan pemesanan jadwal dengan dokter kami.') }}</p>
                    <a href="{{ route('doctors.index') }}" class="btn btn-primary">{{ __('Pesan Jadwal Dokter') }}</a>
                </div>
            @else
                <table class="admin-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="padding: 16px 24px;">{{ __('Dokter Spesialis') }}</th>
                            <th>{{ __('Tanggal & Waktu') }}</th>
                            <th>{{ __('Tipe Konsultasi') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="text-align: right; padding-right: 24px;">{{ __('Aksi / Aksi Chat') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $app)
                            <tr>
                                <td style="padding: 20px 24px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($app->doctor->user->name) }}&color=10439f&background=eef2f6" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" alt="Dokter">
                                        <div>
                                            <h4 style="font-weight: 700; font-size: 15px; color: var(--dark);">{{ $app->doctor->user->name }}</h4>
                                            <p style="font-size: 12px; color: var(--gray-500);">{{ __($app->doctor->specialty) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p style="font-weight: 600; font-size: 14px; color: var(--dark);">{{ $app->appointment_date->format('d M Y') }}</p>
                                    <p style="font-size: 12px; color: var(--gray-500);">{{ __('Pukul') }} {{ date('H:i', strtotime($app->appointment_time)) }}</p>
                                </td>
                                <td>
                                    <span style="text-transform: uppercase; font-size: 12px; font-weight: 700; color: {{ $app->type === 'online' ? 'var(--primary)' : 'var(--secondary)' }};">
                                        {{ $app->type }}
                                    </span>
                                </td>
                                <td>
                                    @if($app->status === 'pending')
                                        <span class="status-badge" style="background-color: #fef3c7; color: #d97706;">{{ __('Menunggu Konfirmasi') }}</span>
                                    @elseif($app->status === 'confirmed')
                                        <span class="status-badge" style="background-color: #d1fae5; color: #065f46;">{{ __('Disetujui') }}</span>
                                    @elseif($app->status === 'completed')
                                        <span class="status-badge" style="background-color: #e0f2fe; color: #0369a1;">{{ __('Selesai') }}</span>
                                    @else
                                        <span class="status-badge" style="background-color: #fee2e2; color: #991b1b;">{{ __('Dibatalkan') }}</span>
                                    @endif
                                </td>
                                <td style="text-align: right; padding-right: 24px;">
                                    @if($app->status === 'confirmed' && $app->type === 'online')
                                        @php
                                            $consultation = App\Models\Consultation::where('appointment_id', $app->id)->first();
                                        @endphp
                                        @if($consultation)
                                            <a href="{{ route('chat.index', ['room' => $consultation->id]) }}" class="btn btn-primary" style="padding: 6px 16px; font-size: 13px;">{{ __('Mulai Chat Konsultasi') }}</a>
                                        @endif
                                    @endif

                                    @if($app->status === 'pending')
                                        <form action="{{ route('appointments.cancel', $app->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-outline" style="border-color: var(--danger); color: var(--danger); padding: 6px 16px; font-size: 13px;">{{ __('Batalkan') }}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding: 20px 24px;">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection
