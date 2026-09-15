<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Logout - Student Management System</title>
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

        .logout-container {
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 1;
        }

        .logout-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(245, 200, 66, 0.1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
            text-align: center;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logout-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            padding: 40px 45px 30px;
            position: relative;
        }

        .logout-header::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, #f5c842, transparent);
        }

        .logout-icon {
            width: 90px; height: 90px;
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

        .logout-icon i { font-size: 40px; color: #1a1a2e; }

        .logout-header h2 {
            color: white;
            font-weight: 700;
            font-size: 24px;
            margin: 0;
            letter-spacing: 1px;
        }

        .logout-header h2 span { color: #f5c842; }

        .logout-body { padding: 40px 45px; }

        .logout-body p {
            color: #666;
            font-size: 15px;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .user-info {
            background: #f8f9fc;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-left: 4px solid #f5c842;
            text-align: left;
        }

        .user-info label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            font-weight: 600;
            display: block;
            margin-bottom: 3px;
        }

        .user-info .value {
            color: #1a1a2e;
            font-weight: 600;
            font-size: 15px;
        }

        .btn-logout {
            background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
            color: white;
            padding: 14px 40px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(231, 74, 59, 0.4);
        }

        .btn-cancel {
            background: transparent;
            color: #1a1a2e;
            padding: 14px 40px;
            border: 2px solid #1a1a2e;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cancel:hover {
            background: #1a1a2e;
            color: white;
            transform: translateY(-2px);
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
            .logout-header { padding: 30px 25px 20px; }
            .logout-body { padding: 30px 25px; }
            .logout-icon { width: 70px; height: 70px; }
            .logout-icon i { font-size: 30px; }
            .logout-header h2 { font-size: 20px; }
        }
    </style>
</head>
<body>

    <div class="logout-container">
        <div class="logout-card">
            <div class="logout-header">
                <div class="logout-icon">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <h2>Student <span>Management</span></h2>
            </div>

            <div class="logout-body">
                <p>Are you sure you want to logout from your account?</p>

                <div class="user-info">
                    <label>Logged in as</label>
                    <div class="value">
                        <i class="fas fa-user" style="color: #f5c842;"></i>
                        {{ Auth::user()->name }}
                    </div>
                </div>

                <!--  Logout Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Yes, Logout
                    </button>
                </form>

                <!-- Cancel -->
                <a href="{{ url()->previous() }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
            </div>
        </div>

        <div class="page-footer">
            &copy; {{ date('Y') }} Student Management System
        </div>
    </div>

</body>
</html>