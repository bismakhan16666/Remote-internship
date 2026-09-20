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
        }
        .auth-container { width: 100%; max-width: 460px; }
        .auth-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.5);
            overflow: hidden;
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
        .card-header-custom h2 { color: white; font-weight: 700; font-size: 26px; margin: 0; }
        .card-header-custom h2 span { color: #f5c842; }
        .card-header-custom p { color: #aaa; font-size: 14px; margin-top: 8px; margin-bottom: 0; }
        .card-body-custom { padding: 40px 45px; }
        .form-label {
            font-weight: 600; color: #1a1a2e; font-size: 13px;
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 14px 15px;
            font-size: 14px;
            background: #f8f9fc;
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
            text-transform: uppercase;
        }
        .btn-auth:hover {
            background: linear-gradient(135deg, #f5c842 0%, #e6b800 100%);
            color: #1a1a2e;
        }
        .forgot-link {
            color: #1a1a2e;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: 0.3s;
        }
        .forgot-link:hover { color: #f5c842; text-decoration: underline; }
        .auth-footer { text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #e0e0e0; color: #666; font-size: 14px; }
        .auth-footer a { color: #1a1a2e; font-weight: 700; text-decoration: none; }
        .auth-footer a:hover { color: #f5c842; }
        .alert-danger { border-radius: 10px; font-size: 14px; background: #fdf2f2; border: none; border-left: 5px solid #e74a3b; color: #721c24; }
        .alert-success { border-radius: 10px; font-size: 14px; background: #d4edda; border: none; border-left: 5px solid #1cc88a; color: #155724; }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="card-header-custom">
                <div class="logo-circle"><i class="fas fa-graduation-cap"></i></div>
                <h2>Student <span>Management</span></h2>
                <p>Sign in to access your dashboard</p>
            </div>

            <div class="card-body-custom">
                @if(session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Role -->
                    <div class="mb-3">
                        <label for="user_type" class="form-label">Login As</label>
                        <select id="user_type" class="form-select" name="user_type" required>
                            <option value="">-- Select Role --</option>
                            <option value="student" {{ old('user_type') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="teacher" {{ old('user_type') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Enter your password" required>
                    </div>

                    <!--  Forgot Password Link -->
                    <div class="mb-3 text-end">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                <i class="fas fa-key"></i> Forgot Password?
                            </a>
                        @endif
                    </div>

                    <!-- Remember -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-auth">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <div class="auth-footer">
                    Don't have an account? <a href="{{ route('register') }}">Register here</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>