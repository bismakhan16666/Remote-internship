<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 { margin: 0; color: #f5c842; }
        .body { padding: 30px; }
        .body h2 { color: #1a1a2e; }
        .body p { color: #555; line-height: 1.6; }
        .footer {
            background: #1a1a2e;
            color: #aaa;
            padding: 20px;
            text-align: center;
            font-size: 13px;
        }
        .btn {
            display: inline-block;
            background: #f5c842;
            color: #1a1a2e;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>🎓 Student Management System</h1>
        </div>

        <div class="body">
            <h2>Welcome, {{ $user->name }}!</h2>
            <p>
                Thank you for registering with Student Management System.
                Your account has been created successfully.
            </p>
            <p>
                <strong>Email:</strong> {{ $user->email }}<br>
                <strong>Role:</strong> {{ ucfirst($user->user_type) }}
            </p>
            <p>
                You can now login to access your dashboard.
            </p>
            <a href="{{ url('/login') }}" class="btn">Login Now</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Student Management System. All Rights Reserved.
        </div>
    </div>

</body>
</html>