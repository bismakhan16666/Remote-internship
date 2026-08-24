<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Student Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            color: #333;
        }
        .header {
            background: #1a1a2e;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .header h1 {
            font-size: 32px;
        }
        .header h1 span {
            color: #f5c842;
        }
        .nav {
            background: #16213e;
            padding: 12px 0;
            text-align: center;
            border-bottom: 3px solid #f5c842;
        }
        .nav a {
            color: white;
            padding: 10px 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: 0.3s;
            border-radius: 5px;
        }
        .nav a:hover {
            background: #f5c842;
            color: #1a1a2e;
        }
        .nav a.active {
            background: #f5c842;
            color: #1a1a2e;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
        }
        .container h2 {
            color: #1a1a2e;
            font-size: 32px;
            margin-bottom: 15px;
            border-bottom: 4px solid #f5c842;
            padding-bottom: 15px;
        }
        .container > p {
            line-height: 1.8;
            color: #555;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid #28a745;
            font-weight: 500;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #1a1a2e;
            font-size: 15px;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: 0.3s;
            background: #fafafa;
        }
        .form-control:focus {
            outline: none;
            border-color: #f5c842;
            background: white;
            box-shadow: 0 0 0 3px rgba(245, 200, 66, 0.2);
        }
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }
        .text-muted {
            color: #6c757d;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        .btn-submit {
            background: #1a1a2e;
            color: white;
            padding: 14px 40px;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 600;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.3s;
            letter-spacing: 1px;
        }
        .btn-submit:hover {
            background: #f5c842;
            color: #1a1a2e;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(245, 200, 66, 0.4);
        }
        .contact-info {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #eee;
        }
        .contact-info h3 {
            color: #1a1a2e;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .contact-info p {
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }
        .contact-info strong {
            color: #1a1a2e;
            display: inline-block;
            width: 130px;
        }
        .footer {
            background: #1a1a2e;
            color: white;
            text-align: center;
            padding: 25px 0;
            margin-top: 50px;
        }
        .footer p {
            margin-bottom: 8px;
        }
        .footer a {
            color: #f5c842;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Student <span>Management</span> System</h1>
    </div>

    <div class="nav">
        <a href="{{ url('about-us') }}">About Us</a>
        <a href="{{ url('contact-us') }}" class="active">Contact Us</a>
    </div>

    <div class="container">
        <h2>Contact Us</h2>
        <p>If you have any questions or need assistance, please feel free to contact us using the form below.</p>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('contact-us') }}" method="POST">
            @csrf

            <!-- Yeh subview use kar rahe hain - Folder name SubView -->
            @include('SubView.input', [
                'name' => 'name',
                'label' => 'Full Name',
                'type' => 'text',
                'placeholder' => 'Enter your full name',
                'required' => 'required'
            ])

            @include('SubView.input', [
                'name' => 'email',
                'label' => 'Email Address',
                'type' => 'email',
                'placeholder' => 'Enter your email address',
                'required' => 'required'
            ])

            @include('SubView.input', [
                'name' => 'subject',
                'label' => 'Subject',
                'type' => 'text',
                'placeholder' => 'Enter subject'
            ])

            @include('SubView.input', [
                'name' => 'message',
                'label' => 'Message',
                'type' => 'textarea',
                'placeholder' => 'Write your message here...',
                'rows' => 5,
                'required' => 'required',
                'help' => 'Please write a detailed message'
            ])

            <button type="submit" class="btn-submit">Send Message</button>
        </form>

        <div class="contact-info">
            <h3>Get in Touch</h3>
            <p><strong>Address:</strong> 123 Education Street, City, State 12345</p>
            <p><strong>Phone:</strong> +1 234 567 8900</p>
            <p><strong>Email:</strong> info@studentms.com</p>
            <p><strong>Office Hours:</strong> Monday - Friday, 9:00 AM - 6:00 PM</p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2026 Student Management System. All Rights Reserved.</p>
        <p>
            <a href="{{ url('about-us') }}">About Us</a> | 
            <a href="{{ url('contact-us') }}">Contact Us</a>
        </p>
    </div>

</body>
</html>