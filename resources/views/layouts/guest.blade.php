<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - MedikaCare</title>

    <!-- Custom App CSS -->
    <link rel="stylesheet" href="/css/app.css">
    
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eef2f6 0%, #ffffff 100%);
            padding: 24px;
        }
        .auth-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .auth-form-group {
            margin-bottom: 20px;
        }
        .auth-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--dark);
        }
        .auth-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            outline: none;
            font-family: var(--font-outfit);
            font-size: 14px;
        }
        .auth-input:focus {
            border-color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <a href="/" class="brand-logo" style="justify-content: center; font-size: 28px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 32px; height: 32px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />
                    </svg>
                    MedikaCare
                </a>
                <p style="color: var(--gray-500); margin-top: 8px; font-size: 14px;">Silakan masuk ke akun Anda</p>
            </div>

            {{ $slot }}
        </div>
    </div>
</body>
</html>
