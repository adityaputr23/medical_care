<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Medika Admin - Dashboard')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body x-data="{ sidebarOpen: false }">

    <!-- Mobile Header Bar -->
    <header class="admin-mobile-header">
        <button @click="sidebarOpen = true" class="admin-hamburger-btn" aria-label="Open Sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 24px; height: 24px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <span class="admin-mobile-brand">Medika Admin</span>
    </header>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" :class="{ 'show': sidebarOpen }" @click="sidebarOpen = false"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="admin-sidebar" :class="{ 'open': sidebarOpen }">
        <!-- Logo -->
        <div class="sidebar-logo">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:26px;height:26px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />
            </svg>
            <span>Medika<span class="brand-dot">Admin</span></span>
            
            <!-- Close button for mobile sidebar -->
            <button @click="sidebarOpen = false" class="admin-sidebar-close" aria-label="Close Sidebar">
                &times;
            </button>
        </div>

        <!-- Navigation -->
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="menu-icon">📊</span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">
                <a href="{{ route('admin.patients.index') }}">
                    <span class="menu-icon">👥</span>
                    <span>Patients</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                <a href="{{ route('admin.appointments.index') }}">
                    <span class="menu-icon">📅</span>
                    <span>Appointments</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">
                <a href="{{ route('admin.doctors.index') }}">
                    <span class="menu-icon">👨‍⚕️</span>
                    <span>Doctors</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
                <a href="{{ route('admin.inventory.index') }}">
                    <span class="menu-icon">📦</span>
                    <span>Inventory</span>
                </a>
            </li>

            <div class="sidebar-divider"></div>

            <li class="sidebar-menu-item">
                <a href="{{ route('home') }}" target="_blank">
                    <span class="menu-icon">🌐</span>
                    <span>Lihat Website</span>
                </a>
            </li>
        </ul>

        <!-- Footer: User Info + Logout -->
        <div class="sidebar-footer">
            <div class="admin-user-info">
                <img class="admin-avatar" 
                     src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=38bdf8&background=1e3a8a" 
                     alt="Avatar">
                <div class="admin-info">
                    <span class="admin-name">{{ auth()->user()->name }}</span>
                    <span class="admin-role">Administrator</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="admin-main">
        @if(session('success'))
            <div class="alert alert-success">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <span>⚠️</span> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
