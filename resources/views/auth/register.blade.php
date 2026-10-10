<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="auth-form-group">
            <label for="name" class="auth-label">Nama Lengkap</label>
            <input id="name" class="auth-input" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" style="color: var(--danger); font-size: 12px;" />
        </div>

        <!-- Email Address -->
        <div class="auth-form-group">
            <label for="email" class="auth-label">Email Pasien</label>
            <input id="email" class="auth-input" type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: var(--danger); font-size: 12px;" />
        </div>

        <!-- Password -->
        <div class="auth-form-group">
            <label for="password" class="auth-label">Kata Sandi</label>
            <input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: var(--danger); font-size: 12px;" />
        </div>

        <!-- Confirm Password -->
        <div class="auth-form-group">
            <label for="password_confirmation" class="auth-label">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: var(--danger); font-size: 12px;" />
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; margin-top: 10px;">
            Daftar Sekarang &rarr;
        </button>

        <div style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--gray-500);">
            Sudah memiliki akun? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700;">Masuk di sini</a>
        </div>
    </form>
</x-guest-layout>
