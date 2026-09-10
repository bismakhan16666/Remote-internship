<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle at 20% 50%, rgba(245, 200, 66, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(78, 115, 223, 0.08) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
        }
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .auth-container { width: 100%; max-width: 460px; position: relative; z-index: 1; }

        .auth-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(245, 200, 66, 0.1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-header-custom {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            padding: 40px 45px 30px;
            text-align: center;
            position: relative;
        }
        .card-header-custom::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, #f5c842, transparent);
        }
        .logo-circle {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #f5c842 0%, #e6b800 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(245, 200, 66, 0.4);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .logo-circle i { font-size: 36px; color: #1a1a2e; }
        .card-header-custom h2 {
            color: white;
            font-weight: 700;
            font-size: 26px;
            margin: 0;
            letter-spacing: 1px;
        }
        .card-header-custom h2 span { color: #f5c842; }
        .card-header-custom p {
            color: #aaa;
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 0;
        }

        .card-body-custom { padding: 40px 45px; }

        .form-label {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        /* ✅ Input Wrapper with Icon */
        .input-icon-wrapper {
            position: relative;
        }

        .input-icon-wrapper .icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #1a1a2e;
            font-size: 16px;
            z-index: 2;
            transition: 0.3s;
            pointer-events: none;
        }

        /* ✅ Text Inputs */
        .input-icon-wrapper .form-control {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 14px 15px 14px 45px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fc;
            width: 100%;
            height: auto;
        }

        /* ✅ Select - Icon ke saath, proper spacing */
        .input-icon-wrapper .form-select {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 14px 40px 14px 45px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fc;
            width: 100%;
            height: auto;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            /* ✅ Custom dropdown arrow */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%231a1a2e' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
        }

        .input-icon-wrapper .form-control:focus,
        .input-icon-wrapper .form-select:focus {
            border-color: #f5c842;
            background: white;
            box-shadow: 0 0 0 4px rgba(245, 200, 66, 0.15);
        }

        .input-icon-wrapper .form-control:focus ~ .icon,
        .input-icon-wrapper:focus-within .icon {
            color: #f5c842;
            transform: translateY(-50%) scale(1.1);
        }

        .btn-auth {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
        }
        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(245, 200, 66, 0.3), transparent);
            transition: 0.5s;
        }
        .btn-auth:hover::before { left: 100%; }
        .btn-auth:hover {
            background: linear-gradient(135deg, #f5c842 0%, #e6b800 100%);
            color: #1a1a2e;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(245, 200, 66, 0.4);
        }

        .auth-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 14px;
        }
        .auth-footer a {
            color: #1a1a2e;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
        }
        .auth-footer a:hover { color: #f5c842; text-decoration: underline; }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 2px solid #d0d0d0;
            cursor: pointer;
            border-radius: 4px;
            transition: 0.3s;
        }
        .form-check-input:checked {
            background-color: #f5c842;
            border-color: #f5c842;
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(245, 200, 66, 0.25);
            border-color: #f5c842;
        }
        .form-check-label {
            font-size: 14px;
            color: #555;
            cursor: pointer;
            padding-left: 5px;
        }

        .alert-danger {
            border-radius: 10px;
            font-size: 14px;
            background: #fdf2f2;
            border: none;
            border-left: 5px solid #e74a3b;
            color: #721c24;
        }

        .page-footer {
            text-align: center;
            color: rgba(255,255,255,0.5);
            margin-top: 25px;
            font-size: 13px;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 576px) {
            .card-header-custom { padding: 30px 25px 20px; }
            .card-body-custom { padding: 30px 25px; }
            .logo-circle { width: 65px; height: 65px; }
            .logo-circle i { font-size: 28px; }
            .card-header-custom h2 { font-size: 22px; }
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="card-header-custom">
                <div class="logo-circle">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2>Student <span>Management</span></h2>
                <p>Sign in to access your dashboard</p>
            </div>

            <div class="card-body-custom">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Error!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- ✅ Login As - With Icon -->
                    <div class="mb-3">
                        <label for="user_type" class="form-label">Login As</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-user-tag icon"></i>
                            <select id="user_type" class="form-select" name="user_type" required>
                                <option value="">-- Select Role --</option>
                                <option value="student" {{ old('user_type') == 'student' ? 'selected' : '' }}>Student</option>
                                <option value="teacher" {{ old('user_type') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    </div>

                    <!-- Email with Icon -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-envelope icon"></i>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                        </div>
                    </div>

                    <!-- Password with Icon -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-lock icon"></i>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Enter your password" required>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <button type="submit" class="btn-auth">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <div class="auth-footer">
                    Don't have an account? <a href="{{ route('register') }}">Register here</a>
                </div>
            </div>
        </div>

        <div class="page-footer">
            &copy; {{ date('Y') }} Student Management System
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>