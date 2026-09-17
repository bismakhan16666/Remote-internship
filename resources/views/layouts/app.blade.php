<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }
        .header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.3);
        }
        .header h1 { font-size: 28px; font-weight: 700; letter-spacing: 1px; }
        .header h1 span { color: #f5c842; }
        .header .subtitle { font-size: 14px; color: #aaa; margin-top: 5px; }
        .nav-bar {
            background: #16213e;
            padding: 12px 0;
            border-bottom: 3px solid #f5c842;
        }
        .nav-bar a {
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            font-weight: 500;
            transition: 0.3s;
            border-radius: 5px;
            display: inline-block;
        }
        .nav-bar a:hover { background: #f5c842; color: #1a1a2e; }
        .nav-bar a.active { background: #f5c842; color: #1a1a2e; }
        .footer {
            background: #1a1a2e;
            color: white;
            text-align: center;
            padding: 25px 0;
            margin-top: 40px;
        }
        .footer a { color: #f5c842; text-decoration: none; }
    </style>
    @yield('styles')
</head>
<body>

    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Student <span>Management</span> System</h1>
                    <div class="subtitle">@yield('subtitle', 'Welcome')</div>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-graduation-cap" style="font-size: 50px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    @auth
    <div class="nav-bar">
        <div class="container">
            @if(Auth::user()->user_type === 'admin')
                <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.index') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Students
                </a>
                <a href="{{ route('students.create') }}">
                    <i class="fas fa-user-plus"></i> Add Student
                </a>
                <a href="{{ route('teachers.create') }}">
                    <i class="fas fa-chalkboard-teacher"></i> Add Teacher
                </a>
                <a href="{{ route('stats.dashboard') }}" class="{{ request()->routeIs('stats.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Stats
                </a>
            @elseif(Auth::user()->user_type === 'teacher')
                <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> My Dashboard
                </a>
                <a href="{{ route('teacher.students') }}" class="{{ request()->routeIs('teacher.students') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> My Students
                </a>
            @elseif(Auth::user()->user_type === 'student')
                <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> My Dashboard
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}" style="display: inline; float: right;">
                @csrf
                <button type="submit" style="background: transparent; border: none; color: white; padding: 8px 20px; font-weight: 500; cursor: pointer; border-radius: 5px; transition: 0.3s;"
                        onmouseover="this.style.background='#f5c842'; this.style.color='#1a1a2e';"
                        onmouseout="this.style.background='transparent'; this.style.color='white';">
                    <i class="fas fa-sign-out-alt"></i> Logout ({{ Auth::user()->name }})
                </button>
            </form>
        </div>
    </div>
    @endauth

    <main>
        @yield('content')
    </main>

    <div class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Student Management System. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>