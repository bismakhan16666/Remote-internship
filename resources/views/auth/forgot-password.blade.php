<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - Student Management System</title>
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
        .form-control {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 14px 15px;
            font-size: 14px;
            background: #f8f9fc;
        }
        .form-control:focus {
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
        .auth-footer { text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #e0e0e0; color: #666; font-size: 14px; }
        .auth-footer a { color: #1a1a2e; font-weight: 700; text-decoration: none; }
        .auth-footer a:hover { color: #f5c842; }
        .alert-success { border-radius: 10px; font-size: 14px; background: #d4edda; border: none; border-left: 5px solid #1cc88a; color: #155724; }
        .info-text {
            background: #f8f9fc;
            border-left: 4px solid #f5c842;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="card-header-custom">
                <div class="logo-circle"><i class="fas fa-key"></i></div>
                <h2>Forgot <span>Password?</span></h2>
                <p>We'll send you a reset link</p>
            </div>

            <div class="card-body-custom">

                <div class="info-text">
                    <i class="fas fa-info-circle" style="color: #f5c842;"></i>
                    Enter your email address and we'll send you a link to reset your password.
                </div>

                @if(session('status'))
                    <div class="alert alert-success mb-4">
                        <i class="fas fa-check-circle"></i> {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-4" style="border-radius: 10px; font-size: 14px; background: #fdf2f2; border: none; border-left: 5px solid #e74a3b; color: #721c24;">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your registered email" required autofocus>
                    </div>

                    <button type="submit" class="btn-auth">
                        <i class="fas fa-paper-plane"></i> Send Reset Link
                    </button>
                </form>

                <div class="auth-footer">
                    Remember your password? <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>