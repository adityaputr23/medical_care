@extends('layouts.app')

@section('title', __('Ruang Chat Medis') . ' - MedikaCare')

@section('content')

    <div class="chat-container">
        
        <!-- Sidebar Room Chat -->
        <aside class="chat-sidebar">
            <div class="chat-sidebar-header">
                <h3 style="font-size: 18px; font-weight: 800; color: var(--dark); margin-bottom: 12px;">{{ __('Konsultasi Aktif') }}</h3>
                <input type="text" class="chat-search-input" placeholder="{{ __('Cari percakapan...') }}">
            </div>
            
            <div class="chat-rooms-list">
                @if($consultations->isEmpty())
                    <p style="text-align: center; color: var(--gray-500); padding: 40px 20px; font-size: 14px;">{{ __('Belum ada ruang konsultasi aktif.') }}</p>
                @else
                    @foreach($consultations as $room)
                        @php
                            $targetUser = auth()->user()->role === 'doctor' ? $room->patient : $room->doctor->user;
                        @endphp
                        <a href="{{ route('chat.index', ['room' => $room->id]) }}" class="chat-room-item {{ $activeConsultation && $activeConsultation->id === $room->id ? 'active' : '' }}">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($targetUser->name) }}&color=10439f&background=eef2f6" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;" alt="Avatar">
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                    <h4 style="font-weight: 700; font-size: 15px; color: var(--dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $targetUser->name }}</h4>
                                    <span style="font-size: 11px; color: var(--gray-500);">{{ $room->latestMessage ? $room->latestMessage->created_at->format('H:i') : '' }}</span>
                                </div>
                                <p style="font-size: 13px; color: var(--gray-500); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 4px;">
                                    {{ $room->latestMessage ? $room->latestMessage->body : __('Belum ada pesan.') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </aside>

        <!-- Area Percakapan -->
        <main class="chat-main">
            @if($activeConsultation)
                @php
                    $targetUser = auth()->user()->role === 'doctor' ? $activeConsultation->patient : $activeConsultation->doctor->user;
                @endphp
                
                <!-- Chat Header -->
                <div class="chat-main-header">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($targetUser->name) }}&color=10439f&background=eef2f6" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;" alt="Avatar">
                        <div>
                            <h3 style="font-size: 16px; font-weight: 800; color: var(--dark);">{{ $targetUser->name }}</h3>
                            <p style="font-size: 12px; color: var(--success); font-weight: 600;">🟢 {{ __('Online / Aktif') }}</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 16px;">
                        <!-- Doctor Specific Actions -->
                        @if(auth()->user()->role === 'doctor')
                            <button id="btn-prescription" class="btn btn-outline" style="padding: 8px 16px; font-size: 13px;">{{ __('📝 Berikan Resep') }}</button>
                        @endif
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="chat-messages-area" id="messages-container">
                    @foreach($messages as $msg)
                        <div class="chat-message-bubble {{ $msg->sender_id === auth()->id() ? 'outgoing' : 'incoming' }}">
                            
                            @if($msg->type === 'prescription')
                                <div style="background-color: {{ $msg->sender_id === auth()->id() ? 'rgba(255,255,255,0.1)' : '#f8fafc' }}; border: 1px solid var(--gray-200); padding: 16px; border-radius: 12px; margin-bottom: 8px; color: var(--dark);">
                                    <h4 style="font-weight: 800; font-size: 14px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">{{ __('📝 RESEP OBAT DIGITAL') }}</h4>
                                    <p style="font-size: 13px; white-space: pre-line;">{{ $msg->body }}</p>
                                    @if($msg->prescription)
                                        <a href="{{ route('prescription.download', $msg->prescription->id) }}" target="_blank" class="btn btn-primary" style="margin-top: 12px; padding: 6px 12px; font-size: 12px; width: 100%;">{{ __('🖨️ Cetak / Unduh Resep PDF') }}</a>
                                    @endif
                                </div>
                            @else
                                <p style="font-size: 14px; line-height: 1.5; white-space: pre-line;">{{ $msg->body }}</p>
                            @endif

                            <span style="font-size: 10px; display: block; text-align: right; margin-top: 6px; opacity: 0.7;">
                                {{ $msg->created_at->setTimezone('Asia/Jakarta')->format('H:i') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Input Area -->
                <div class="chat-input-area">
                    <form id="chat-form" style="width: 100%; display: flex; gap: 16px;" action="{{ route('chat.send', $activeConsultation->id) }}" method="POST">
                        @csrf
                        <input type="text" id="message-input" name="body" class="chat-input-field" placeholder="{{ __('Ketik pesan Anda di sini...') }}" required autocomplete="off">
                        <button type="submit" class="btn btn-primary" style="padding: 12px 28px;">{{ __('Kirim 🚀') }}</button>
                    </form>
                </div>

            @else
                <div style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: #f1f5f9; padding: 40px; text-align: center;">
                    <span style="font-size: 64px;">💬</span>
                    <h2 style="font-weight: 800; margin-top: 20px; color: var(--dark);">{{ __('Selamat Datang di Ruang Konsultasi') }}</h2>
                    <p style="color: var(--gray-500); max-width: 450px; margin-top: 10px;">{{ __('Silakan pilih salah satu percakapan di bilah kiri untuk memulai konsultasi medis Anda.') }}</p>
                </div>
            @endif
        </main>
    </div>

    <!-- Doctor's Recipe/Prescription Modal -->
    @if($activeConsultation && auth()->user()->role === 'doctor')
        <div class="modal-overlay" id="prescription-modal">
            <div class="modal-content" style="max-width: 600px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-weight: 800; font-size: 20px; color: var(--dark);">{{ __('Buat Resep Obat Baru') }}</h3>
                    <button id="close-prescription-modal" style="font-size: 24px; color: var(--gray-500);">&times;</button>
                </div>
                
                <form id="prescription-form" action="{{ route('chat.prescription', $activeConsultation->id) }}" method="POST">
                    @csrf
                    
                    <div id="medication-list">
                        <div class="admin-form-group medication-row" style="display: flex; gap: 12px; margin-bottom: 12px;">
                            <div style="flex: 2;">
                                <label style="font-size: 12px;">{{ __('Nama Obat') }}</label>
                                <input type="text" name="medications[0][name]" class="admin-form-control" placeholder="Paracetamol 500mg" required>
                            </div>
                            <div style="flex: 1;">
                                <label style="font-size: 12px;">{{ __('Dosis') }}</label>
                                <input type="text" name="medications[0][dosage]" class="admin-form-control" placeholder="1 Tablet" required>
                            </div>
                            <div style="flex: 1;">
                                <label style="font-size: 12px;">{{ __('Frekuensi') }}</label>
                                <input type="text" name="medications[0][frequency]" class="admin-form-control" placeholder="3x Sehari" required>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" id="add-more-meds" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px; margin-bottom: 24px;">{{ __('+ Tambah Obat Lain') }}</button>

                    <div class="admin-form-group">
                        <label>{{ __('Catatan Dokter / Aturan Tambahan') }}</label>
                        <textarea name="notes" class="admin-form-control" rows="3" placeholder="Diminum sesudah makan, habiskan obat antibiotik..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 16px;">{{ __('Kirim Resep ke Pasien') }}</button>
                </form>
            </div>
        </div>
    @endif

    <!-- WebSocket Event Broadcasting Integration Script -->
    @if($activeConsultation)
        <script>
            // Scroll to bottom helper
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }

            // AJAX Chat Send Form Submission
            const form = document.getElementById('chat-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const input = document.getElementById('message-input');
                    const body = input.value;
                    if (!body.trim()) return;

                    input.value = '';

                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            appendMessage(data.message, true);
                        }
                    });
                });
            }

            // Recipe form modal handler (Doctor only)
            const btnPrescription = document.getElementById('btn-prescription');
            const prescriptionModal = document.getElementById('prescription-modal');
            const closePrescription = document.getElementById('close-prescription-modal');
            
            if (btnPrescription && prescriptionModal) {
                btnPrescription.addEventListener('click', () => prescriptionModal.classList.add('open'));
                closePrescription.addEventListener('click', () => prescriptionModal.classList.remove('open'));
            }

            // Add dynamic medicine row
            let medIndex = 1;
            const btnAddMeds = document.getElementById('add-more-meds');
            if (btnAddMeds) {
                btnAddMeds.addEventListener('click', () => {
                    const container = document.getElementById('medication-list');
                    const newRow = document.createElement('div');
                    newRow.className = 'admin-form-group medication-row';
                    newRow.style.display = 'flex';
                    newRow.style.gap = '12px';
                    newRow.style.marginBottom = '12px';
                    newRow.innerHTML = `
                        <div style="flex: 2;">
                            <input type="text" name="medications[${medIndex}][name]" class="admin-form-control" placeholder="Nama Obat" required>
                        </div>
                        <div style="flex: 1;">
                            <input type="text" name="medications[${medIndex}][dosage]" class="admin-form-control" placeholder="Dosis" required>
                        </div>
                        <div style="flex: 1;">
                            <input type="text" name="medications[${medIndex}][frequency]" class="admin-form-control" placeholder="Frekuensi" required>
                        </div>
                    `;
                    container.appendChild(newRow);
                    medIndex++;
                });
            }

            // Recipe form submit
            const recipeForm = document.getElementById('prescription-form');
            if (recipeForm) {
                recipeForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(recipeForm);
                    
                    // Convert medications to JSON structure for sending
                    fetch(recipeForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            prescriptionModal.classList.remove('open');
                            appendMessage(data.message, true);
                            location.reload(); // Quick refresh to render download buttons properly
                        }
                    });
                });
            }

            function appendMessage(message, isOutgoing) {
                const container = document.getElementById('messages-container');
                const bubble = document.createElement('div');
                bubble.className = `chat-message-bubble ${isOutgoing ? 'outgoing' : 'incoming'}`;
                
                bubble.innerHTML = `
                    <p style="font-size: 14px; line-height: 1.5; white-space: pre-line;">${message.body}</p>
                    <span style="font-size: 10px; display: block; text-align: right; margin-top: 6px; opacity: 0.7;">
                        ${message.created_at}
                    </span>
                `;
                
                container.appendChild(bubble);
                container.scrollTop = container.scrollHeight;
            }
        </script>
    @endif

@endsection
