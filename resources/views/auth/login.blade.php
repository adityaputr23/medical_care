<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="auth-form-group">
            <label for="email" class="auth-label">Email Medis / Pasien</label>
            <input id="email" class="auth-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: var(--danger); font-size: 12px; margin-top: 4px;" />
        </div>

        <!-- Password -->
        <div class="auth-form-group">
            <label for="password" class="auth-label">Kata Sandi</label>
            <input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: var(--danger); font-size: 12px; margin-top: 4px;" />
        </div>

        <!-- Remember Me -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <label for="remember_me" style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--gray-500); cursor: pointer;">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Ingat saya</span>
            </label>
            
            @if (Route::has('password.request'))
                <a style="font-size: 13px; color: var(--primary); font-weight: 600;" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
            Masuk Sekarang &rarr;
        </button>
        
        <div style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--gray-500);">
            Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 700;">Daftar di sini</a>
        </div>
    </form>
</x-guest-layout>
