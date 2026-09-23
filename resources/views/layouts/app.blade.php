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
        .alert-custom.warning {
            background: #fff3cd;
            color: #856404;
            border-left: 5px solid #ffc107;
        }
        .alert-custom.info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 5px solid #17a2b8;
        }
        .alert-custom i { font-size: 20px; }

        /* Real-time Notification Box */
        .realtime-box {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            max-width: 350px;
        }
        .realtime-notification {
            background: #1a1a2e;
            color: #f5c842;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            margin-bottom: 10px;
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>

    @yield('styles')
</head>
<body>

    <!-- HEADER -->
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

    <!-- NAV -->
    <nav class="main-nav">
        @auth
            @if(Auth::user()->user_type === 'admin')
                <a href="{{ route('students.index') }}"><i class="fas fa-user-graduate"></i> Students</a>
                <a href="{{ route('teachers.create') }}"><i class="fas fa-chalkboard-teacher"></i> Add Teacher</a>
                <a href="{{ route('stats.dashboard') }}"><i class="fas fa-chart-bar"></i> Stats</a>
                <a href="{{ route('system.dashboard') }}"><i class="fas fa-cogs"></i> System</a>
            @elseif(Auth::user()->user_type === 'teacher')
                <a href="{{ route('teacher.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                <a href="{{ route('teacher.students') }}"><i class="fas fa-users"></i> My Students</a>
            @elseif(Auth::user()->user_type === 'student')
                <a href="{{ route('student.dashboard') }}"><i class="fas fa-home"></i> My Dashboard</a>
            @endif
        @endauth
    </nav>

    <!-- REAL-TIME NOTIFICATION BOX -->
    <div class="realtime-box" id="realtimeBox"></div>

    <!-- CONTENT -->
    <main class="main-content">

        <div class="container">
            @if(session('success'))
                <div class="alert-custom success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-custom error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="alert-custom warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert-custom info">
                    <i class="fas fa-info-circle"></i>
                    {{ session('info') }}
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="main-footer">
        &copy; {{ date('Y') }} <strong>Student Management System</strong>. All Rights Reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ============================================ --}}
    {{-- Pusher JS + Laravel Echo (Real-time) --}}
    {{-- ============================================ --}}
    @auth
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>

    <script>
        // Initialize Pusher
        window.Pusher = Pusher;

        // Initialize Laravel Echo with Pusher
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env("PUSHER_APP_KEY") }}',
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            forceTLS: true,
            encrypted: true,
        });

        // Listen for StudentAdded event on 'students' channel
        window.Echo.channel('students')
            .listen('.StudentAdded', (e) => {
                console.log('Student Added Event:', e);

                // Show real-time notification
                const box = document.getElementById('realtimeBox');
                if (box) {
                    const notification = document.createElement('div');
                    notification.className = 'realtime-notification';
                    notification.innerHTML = `
                        <strong>New Student Added!</strong><br>
                        Name: ${e.name || 'N/A'}<br>
                        Email: ${e.email || 'N/A'}<br>
                        Time: ${e.time || new Date().toLocaleString()}
                    `;
                    box.appendChild(notification);

                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 5000);
                }
            });

        // Connection status
        window.Echo.connector.pusher.connection.bind('connected', () => {
            console.log('Pusher connected!');
        });

        window.Echo.connector.pusher.connection.bind('error', (err) => {
            console.error('Pusher error:', err);
        });
    </script>
    @endauth

    @yield('scripts')
</body>
</html>