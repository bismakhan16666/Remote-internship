<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Student Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        .auth-container { width: 100%; max-width: 500px; position: relative; z-index: 1; }

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
        }
        .logo-circle i { font-size: 36px; color: #1a1a2e; }
        .card-header-custom h2 { color: white; font-weight: 700; font-size: 26px; margin: 0; letter-spacing: 1px; }
        .card-header-custom h2 span { color: #f5c842; }
        .card-header-custom p { color: #aaa; font-size: 14px; margin-top: 8px; margin-bottom: 0; }

        .card-body-custom { padding: 40px 45px; }

        .form-label {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 14px 15px;
            font-size: 14px;
            background: #f8f9fc;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #f5c842;
            background: white;
            box-shadow: 0 0 0 4px rgba(245, 200, 66, 0.15);
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
            margin-top: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
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
        .auth-footer a { color: #1a1a2e; font-weight: 700; text-decoration: none; }
        .auth-footer a:hover { color: #f5c842; text-decoration: underline; }

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
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="card-header-custom">
                <div class="logo-circle">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2>Student <span>Management</span></h2>
                <p>Create your account</p>
            </div>

            <div class="card-body-custom">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Enter password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
                    </div>

                    <div class="mb-3">
                        <label for="user_type" class="form-label">Register As</label>
                        <select id="user_type" class="form-select" name="user_type" required>
                            <option value="">-- Select Role --</option>
                            <option value="student" {{ old('user_type') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="teacher" {{ old('user_type') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-auth">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </form>

                <div class="auth-footer">
                    Already have an account? <a href="{{ route('login') }}">Login here</a>
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