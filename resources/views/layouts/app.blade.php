<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MedikaCare - Presisi & Penuh Kepedulian')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>

    <!-- Emergency Top Banner -->
    @if(App\Models\LandingContent::getValue('emergency_banner', 'true') === 'true')
    <div style="background-color: var(--danger); color: white; text-align: center; padding: 10px; font-weight: 700; font-size: 14px;">
        {{ __('⚠️ BUTUH KONSULTASI MENDESAK? HUBUNGI TIM MEDIS KAMI SEGERA DI +62 811-900-MED') }}
    </div>
    @endif

    <!-- Navbar -->
    <nav class="navbar" x-data="{ mobileMenuOpen: false }">
        <div class="container navbar-container">
            <a href="{{ route('home') }}" class="brand-logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 28px; height: 28px; flex-shrink: 0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />
                </svg>
                MedikaCare
            </a>
            
            <!-- Desktop Links -->
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('services.show', 'general-checkup') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">{{ __('Services') }}</a></li>
                <li><a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.*') ? 'active' : '' }}">{{ __('Doctors') }}</a></li>
                <li><a href="{{ route('chat.index') }}" class="{{ request()->routeIs('chat.*') ? 'active' : '' }}">{{ __('Chat') }}</a></li>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}">{{ __('Admin Panel') }}</a></li>
                    @endif
                @endauth
            </ul>
            
            <!-- Desktop Actions -->
            <div class="nav-actions">
                @auth
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline" style="padding: 8px 16px; font-size: 14px;">{{ __('Logout') }} ({{ auth()->user()->name }})</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">{{ __('Masuk / Daftar') }}</a>
                @endauth
                <a href="tel:+62811900MED" class="btn btn-emergency">{{ __('Emergency') }}</a>

                <!-- Language Switcher Icon Dropdown (Right Next to Emergency Button) -->
                <div class="lang-dropdown" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="lang-toggle-btn" title="{{ __('Pengaturan Bahasa') }}" aria-label="{{ __('Pengaturan Bahasa') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="lang-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a24.12 24.12 0 0112 0m-9 0a24.113 24.113 0 0012 0M3 5.621l1.5 12.379h7.5M3 5.621h18" />
                        </svg>
                        <span class="lang-code">{{ strtoupper(app()->getLocale()) }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px; transition: transform 0.2s;" :style="open ? 'transform: rotate(180deg);' : ''">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="lang-menu"
                         style="display: none;">
                        <a href="{{ route('lang.switch', 'id') }}" class="lang-option {{ app()->getLocale() === 'id' ? 'active' : '' }}">
                            <span class="flag-icon">🇮🇩</span>
                            <span class="lang-name">{{ __('Bahasa Indonesia') }}</span>
                            @if(app()->getLocale() === 'id')
                                <span class="check-mark">✓</span>
                            @endif
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}" class="lang-option {{ app()->getLocale() === 'en' ? 'active' : '' }}">
                            <span class="flag-icon">🇬🇧</span>
                            <span class="lang-name">{{ __('English') }}</span>
                            @if(app()->getLocale() === 'en')
                                <span class="check-mark">✓</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>

            <!-- Hamburger Button for Mobile -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="hamburger-btn" aria-label="Toggle Menu">
                <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 28px; height: 28px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 28px; height: 28px; display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Drawer Menu overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="mobile-menu-drawer"
             style="display: none;">
            <ul class="mobile-nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('services.show', 'general-checkup') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">{{ __('Services') }}</a></li>
                <li><a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.*') ? 'active' : '' }}">{{ __('Doctors') }}</a></li>
                <li><a href="{{ route('chat.index') }}" class="{{ request()->routeIs('chat.*') ? 'active' : '' }}">{{ __('Chat') }}</a></li>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" style="color: var(--primary); font-weight: 700;">{{ __('Admin Panel') }}</a></li>
                    @endif
                @endauth
            </ul>
            <div class="mobile-nav-actions">
                @auth
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-outline" style="width: 100%; justify-content: center;">{{ __('Logout') }} ({{ auth()->user()->name }})</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline" style="width: 100%; justify-content: center;">{{ __('Masuk / Daftar') }}</a>
                @endauth
                <a href="tel:+62811900MED" class="btn btn-emergency" style="width: 100%; justify-content: center;">{{ __('Emergency Call') }}</a>
                
                <div style="display: flex; gap: 12px; justify-content: center; margin-top: 12px; width: 100%;">
                    <a href="{{ route('lang.switch', 'id') }}" class="btn btn-outline {{ app()->getLocale() === 'id' ? 'btn-primary' : '' }}" style="flex: 1; padding: 8px; font-size: 13px;">
                        🇮🇩 Bahasa Indonesia
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" class="btn btn-outline {{ app()->getLocale() === 'en' ? 'btn-primary' : '' }}" style="flex: 1; padding: 8px; font-size: 13px;">
                        🇬🇧 English
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container" style="margin-top: 20px;">
                <div style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 14px 20px; border-radius: 8px; font-weight: 600;">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container" style="margin-top: 20px;">
                <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 14px 20px; border-radius: 8px; font-weight: 600;">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h3 class="brand-logo" style="margin-bottom: 20px;">MedikaCare</h3>
                    <p style="color: var(--gray-500); font-size: 15px;">{{ __('Layanan kesehatan masa depan yang menggabungkan empati dengan keunggulan medis dan teknologi digital termutakhir.') }}</p>
                </div>
                <div>
                    <h4 class="footer-col-title">{{ __('Services') }}</h4>
                    <ul class="footer-links">
                        <li><a href="#">General Practitioner</a></li>
                        <li><a href="#">Spesialis Penyakit Dalam</a></li>
                        <li><a href="#">Kardiovaskular</a></li>
                        <li><a href="#">Apotek 24 Jam</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-col-title">{{ __('Tautan Cepat') }}</h4>
                    <ul class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Emergency Protocol</a></li>
                        <li><a href="#">Contact Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-col-title">{{ __('Kontak Kami') }}</h4>
                    <div class="footer-contact">
                        <p>📍 Jl. Kesehatan No. 123, Jakarta</p>
                        <p>📞 +62 21 500-1234</p>
                        <p>✉️ info@medikacare.id</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} MedikaCare Health Systems. {{ __('All rights reserved.') }}</p>
                <div class="social-links">
                    <a href="#">🌐</a>
                    <a href="#">🔗</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
