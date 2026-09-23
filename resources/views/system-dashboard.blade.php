@extends('layouts.app')

@section('title', 'System Dashboard')

@section('styles')
<style>
    .system-container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }

    .section-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        border-left: 5px solid #f5c842;
    }
    .section-card h3 {
        color: #1a1a2e;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 3px solid #f5c842;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .info-box {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 15px;
        border-left: 4px solid #1a1a2e;
    }
    .info-box .label {
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .info-box .value {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
    }

    .log-entry {
        background: #f8f9fc;
        border-left: 4px solid #17a2b8;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 10px;
        font-size: 13px;
        word-break: break-all;
        color: #555;
    }

    .event-entry {
        background: #f0f9ff;
        border-left: 4px solid #f5c842;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 10px;
        font-size: 13px;
        word-break: break-all;
        color: #555;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 10px;
    }
    .status-badge.success { background: #d4edda; color: #155724; }
    .status-badge.warning { background: #fff3cd; color: #856404; }
    .status-badge.danger  { background: #f8d7da; color: #721c24; }
    .status-badge.info    { background: #d1ecf1; color: #0c5460; }

    .quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    .quick-link {
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        color: white;
        padding: 20px;
        border-radius: 12px;
        text-decoration: none;
        text-align: center;
        transition: 0.3s;
    }
    .quick-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(26,26,46,0.3);
        color: #f5c842;
    }
    .quick-link i {
        font-size: 32px;
        color: #f5c842;
        display: block;
        margin-bottom: 10px;
    }

    .back-btn {
        background: #1a1a2e;
        color: #f5c842;
        padding: 10px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }
    .back-btn:hover {
        background: #f5c842;
        color: #1a1a2e;
        transform: translateX(-5px);
    }
</style>
@endsection

@section('content')
<div class="system-container">

    {{-- Back Button --}}
    <div style="margin-bottom: 20px;">
        <a href="{{ route('students.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <h2 style="color: #1a1a2e; margin-bottom: 25px;">
        <i class="fas fa-cogs"></i> System Dashboard - All in One Place
    </h2>

    {{-- SECTION 1: STATS --}}
    <div class="section-card">
        <h3><i class="fas fa-chart-bar"></i> System Stats</h3>
        <div class="info-grid">
            <div class="info-box">
                <div class="label">Total Students</div>
                <div class="value">{{ $stats['totalStudents'] }}</div>
            </div>
            <div class="info-box">
                <div class="label">Total Teachers</div>
                <div class="value">{{ $stats['totalTeachers'] }}</div>
            </div>
            <div class="info-box">
                <div class="label">Total Classes</div>
                <div class="value">{{ $stats['totalClasses'] }}</div>
            </div>
            <div class="info-box">
                <div class="label">Total Subjects</div>
                <div class="value">{{ $stats['totalSubjects'] }}</div>
            </div>
            <div class="info-box">
                <div class="label">Verified Users</div>
                <div class="value" style="color: #1cc88a;">{{ $stats['verifiedUsers'] }}</div>
            </div>
            <div class="info-box">
                <div class="label">Unverified Users</div>
                <div class="value" style="color: #e74a3b;">{{ $stats['unverifiedUsers'] }}</div>
            </div>
        </div>
    </div>

    {{-- SECTION 2: EMAIL LOG --}}
    <div class="section-card">
        <h3>
            <i class="fas fa-envelope"></i> Latest Emails
            <span class="status-badge success">Mail Driver: {{ config('mail.default') }}</span>
        </h3>

        @if(count($emailLogs) > 0)
            @foreach($emailLogs as $log)
                <div class="log-entry">{{ $log }}</div>
            @endforeach
        @else
            <p style="color: #999;">No email logs found. Register a user to test.</p>
        @endif

        <a href="{{ route('email.test') }}" class="btn btn-primary btn-sm mt-3">
            <i class="fas fa-paper-plane"></i> Send Test Email
        </a>
    </div>

    {{-- SECTION 3: QUEUE STATUS --}}
    <div class="section-card">
        <h3>
            <i class="fas fa-tasks"></i> Queue Status
            <span class="status-badge {{ config('queue.default') === 'sync' ? 'warning' : 'success' }}">
                Driver: {{ config('queue.default') }}
            </span>
        </h3>
        <div class="info-grid">
            <div class="info-box">
                <div class="label">Pending Jobs</div>
                <div class="value" style="color: #f6c23e;">{{ $queueJobs['pending'] }}</div>
            </div>
            <div class="info-box">
                <div class="label">Failed Jobs</div>
                <div class="value" style="color: #e74a3b;">{{ $queueJobs['failed'] }}</div>
            </div>
        </div>

        <a href="{{ route('queue.test') }}" class="btn btn-primary btn-sm mt-3">
            <i class="fas fa-plus"></i> Dispatch Test Job
        </a>
    </div>

    {{-- SECTION 4: EVENTS LOG (NEW) --}}
    <div class="section-card">
        <h3>
            <i class="fas fa-bolt"></i> Events Log
            <span class="status-badge info">StudentAdded Event</span>
        </h3>

        @if(count($eventLogs) > 0)
            @foreach($eventLogs as $log)
                <div class="event-entry">{{ $log }}</div>
            @endforeach
        @else
            <p style="color: #999;">No events fired yet. Click below to test.</p>
        @endif

        <a href="{{ route('event.test') }}" class="btn btn-warning btn-sm mt-3">
            <i class="fas fa-bolt"></i> Fire Test Event
        </a>
    </div>

    {{-- SECTION 5: CACHE INFO --}}
    <div class="section-card">
        <h3>
            <i class="fas fa-database"></i> Cache Info
            <span class="status-badge success">Driver: {{ $cacheInfo['driver'] }}</span>
        </h3>
        <div class="info-grid">
            <div class="info-box">
                <div class="label">Demo Cache</div>
                <div class="value">{{ $cacheInfo['has_demo'] ? 'Active' : 'Empty' }}</div>
            </div>
            <div class="info-box">
                <div class="label">Dashboard Stats Cache</div>
                <div class="value">{{ $cacheInfo['has_stats'] ? 'Active' : 'Empty' }}</div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('cache.store') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Store Cache
            </a>
            <a href="{{ route('cache.show') }}" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> View Cache
            </a>
            <a href="{{ route('cache.clear') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> Clear Cache
            </a>
        </div>
    </div>

    {{-- SECTION 6: SESSION INFO --}}
    <div class="section-card">
        <h3><i class="fas fa-user-lock"></i> Session Info</h3>
        <div class="info-grid">
            <div class="info-box">
                <div class="label">User Name</div>
                <div class="value" style="font-size: 16px;">{{ $sessionInfo['user_name'] ?? 'Not set' }}</div>
            </div>
            <div class="info-box">
                <div class="label">User Role</div>
                <div class="value" style="font-size: 16px;">{{ $sessionInfo['user_role'] ?? 'Not set' }}</div>
            </div>
            <div class="info-box">
                <div class="label">Login Time</div>
                <div class="value" style="font-size: 14px;">{{ $sessionInfo['login_time'] ?? 'Not set' }}</div>
            </div>
            <div class="info-box">
                <div class="label">Student Viewed</div>
                <div class="value" style="font-size: 14px;">{{ $sessionInfo['student_viewed'] ?? 'Not set' }}</div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('session.set') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Set Session
            </a>
            <a href="{{ route('session.show') }}" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> View Session
            </a>
            <a href="{{ route('session.clear') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> Clear Session
            </a>
        </div>
    </div>

    {{-- SECTION 7: QUICK LINKS --}}
    <div class="section-card">
        <h3><i class="fas fa-link"></i> Quick Links</h3>
        <div class="quick-links">
            <a href="{{ route('students.index') }}" class="quick-link">
                <i class="fas fa-user-graduate"></i>
                Students
            </a>
            <a href="{{ route('students.create') }}" class="quick-link">
                <i class="fas fa-user-plus"></i>
                Add Student
            </a>
            <a href="{{ route('teachers.create') }}" class="quick-link">
                <i class="fas fa-chalkboard-teacher"></i>
                Add Teacher
            </a>
            <a href="{{ route('cache.show') }}" class="quick-link">
                <i class="fas fa-database"></i>
                Cache Demo
            </a>
            <a href="{{ route('session.show') }}" class="quick-link">
                <i class="fas fa-user-lock"></i>
                Session Demo
            </a>
            <a href="{{ route('email.test') }}" class="quick-link">
                <i class="fas fa-paper-plane"></i>
                Test Email
            </a>
        </div>
    </div>

</div>
@endsection