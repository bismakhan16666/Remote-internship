<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
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
        .btn {
            display: inline-block;
            background: #f5c842;
            color: #1a1a2e;
            padding: 15px 40px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
        }
        .btn:hover { background: #e6b800; }
        .footer {
            background: #1a1a2e;
            color: #aaa;
            padding: 20px;
            text-align: center;
            font-size: 13px;
        }
        .link-box {
            background: #f8f9fc;
            border-left: 4px solid #f5c842;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            word-break: break-all;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>🎓 Student Management System</h1>
        </div>

        <div class="body">
            <h2>Hello {{ $user->name }}!</h2>

            <p>
                Thank you for registering with Student Management System.
                Please verify your email address by clicking the button below.
            </p>

            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="btn">
                    ✅ Verify Email Address
                </a>
            </div>

            <p>
                If the button doesn't work, copy and paste this link into your browser:
            </p>

            <div class="link-box">
                {{ $verificationUrl }}
            </div>

            <p style="font-size: 13px; color: #999;">
                This link will expire in 60 minutes.
            </p>

            <p>
                If you did not create an account, no further action is required.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Student Management System. All Rights Reserved.
        </div>
    </div>

</body>
</html>