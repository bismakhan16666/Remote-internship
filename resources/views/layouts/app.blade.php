<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Management System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        /* Header */
        .main-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .main-header .logo {
            font-size: 22px;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }
        .main-header .logo span { color: #f5c842; }

        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-info {
            text-align: right;
            line-height: 1.2;
        }
        .user-info .name {
            font-weight: 600;
            font-size: 14px;
            color: #f5c842;
        }
        .user-info .role {
            font-size: 11px;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Logout Button */
        .logout-btn {
            background: transparent;
            border: 2px solid #f5c842;
            color: #f5c842;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .logout-btn:hover {
            background: #f5c842;
            color: #1a1a2e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 200, 66, 0.4);
        }
        .logout-btn i { font-size: 14px; }

        /* Nav */
        .main-nav {
            background: #16213e;
            padding: 0 30px;
            display: flex;
            gap: 5px;
            border-bottom: 2px solid #f5c842;
            flex-wrap: wrap;
        }
        .main-nav a {
            color: #ddd;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .main-nav a:hover, .main-nav a.active {
            background: #f5c842;
            color: #1a1a2e;
        }
        .main-nav a i { font-size: 14px; }

        /* Content */
        .main-content { padding: 20px; min-height: 70vh; }

        /* Footer */
        .main-footer {
            background: #1a1a2e;
            color: #aaa;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            border-top: 2px solid #f5c842;
        }
        .main-footer strong { color: #f5c842; }

        /* Alert */
        .alert-custom {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }
        .alert-custom.success {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }
        .alert-custom.error {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }
        .alert-custom i { font-size: 20px; }
    </style>

    @yield('styles')
</head>
<body>

    <!-- ============ HEADER ============ -->
    <header class="main-header">
        <a href="{{ url('/') }}" class="logo">
            <i class="fas fa-graduation-cap"></i> Student <span>Management</span>
        </a>

        <div class="user-menu">
            @auth
                <div class="user-info">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">{{ Auth::user()->user_type }}</div>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </header>

    <!-- ============ NAV ============ -->
    <nav class="main-nav">
        @auth
            @if(Auth::user()->user_type === 'admin')
                <a href="{{ route('students.index') }}"><i class="fas fa-user-graduate"></i> Students</a>
                <a href="{{ route('teachers.create') }}"><i class="fas fa-chalkboard-teacher"></i> Add Teacher</a>
                <a href="{{ route('stats.dashboard') }}"><i class="fas fa-chart-bar"></i> Stats</a>
            @elseif(Auth::user()->user_type === 'teacher')
                <a href="{{ route('teacher.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                <a href="{{ route('teacher.students') }}"><i class="fas fa-users"></i> My Students</a>
            @elseif(Auth::user()->user_type === 'student')
                <a href="{{ route('student.dashboard') }}"><i class="fas fa-home"></i> My Dashboard</a>
            @endif
        @endauth
    </nav>

    <!-- ============ CONTENT ============ -->
    <main class="main-content">
        @if(session('success'))
            <div class="container">
                <div class="alert-custom success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert-custom error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- ============ FOOTER ============ -->
    <footer class="main-footer">
        &copy; {{ date('Y') }} <strong>Student Management System</strong>. All Rights Reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>