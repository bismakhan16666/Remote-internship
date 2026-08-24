<!-- Lec12 Creating Layouts with Blade for Reusable Templates-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Student Management</title>
    
    @yield('styles')
</head>
<body>

    <div class="header">
        <h1>Student <span>Management</span> System</h1>
    </div>

    <div class="nav">
        <a href="{{ url('about-us') }}" class="active">About Us</a>
        <a href="{{ url('contact-us') }}">Contact Us</a>
    </div>

    <div class="container">
        @yield('container')
    </div>

    <div class="footer">
        <p>&copy; 2026 Student Management System. All Rights Reserved.</p>
        <p>
            <a href="{{ url('about-us') }}">About Us</a> | 
            <a href="{{ url('contact-us') }}">Contact Us</a>
        </p>
    </div>
</body>

@yield('scripts')

</html>