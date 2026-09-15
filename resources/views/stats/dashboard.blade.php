@extends('layouts.app')

@section('title', 'Statistics Dashboard')
@section('subtitle', 'System Statistics & Analytics')

@section('styles')
<style>
    .dashboard-container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }
    .page-header h2 {
        color: #1a1a2e;
        font-weight: 700;
        margin: 0;
    }
    .btn-back {
        background: #1a1a2e;
        color: white;
        padding: 10px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back:hover {
        background: #f5c842;
        color: #1a1a2e;
        transform: translateX(-3px);
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border-left: 5px solid;
        margin-bottom: 20px;
        transition: 0.3s;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
    .stat-card .stat-number { font-size: 32px; font-weight: 700; }
    .stat-card .stat-label { font-size: 14px; color: #666; margin-top: 5px; }
    .stat-card .stat-icon { float: right; font-size: 40px; opacity: 0.2; }
    .stat-card.blue { border-left-color: #4e73df; }
    .stat-card.green { border-left-color: #1cc88a; }
    .stat-card.yellow { border-left-color: #f6c23e; }
    .stat-card.red { border-left-color: #e74a3b; }
    .stat-card.purple { border-left-color: #6f42c1; }
    .stat-card.teal { border-left-color: #20c997; }

    .table-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }
    .table-card h4 {
        color: #1a1a2e;
        font-weight: 700;
        border-bottom: 3px solid #f5c842;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }
    .table-custom thead th {
        font-weight: 600;
        color: #4a4a4a;
        background: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
    }
    .table-custom tbody td { vertical-align: middle; padding: 12px; }

    .section-title {
        color: #1a1a2e;
        font-weight: 700;
        margin-bottom: 20px;
        margin-top: 30px;
        border-left: 5px solid #f5c842;
        padding-left: 15px;
    }

    .badge-custom {
        background: #1a1a2e;
        color: #f5c842;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    <!-- ✅ Back Button (Top) -->
    <div class="page-header">
        <a href="{{ route('students.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <h2><i class="fas fa-chart-bar"></i> Statistics Dashboard</h2>
    </div>

    <!-- Basic Counts -->
    <h5 class="section-title">Basic Counts</h5>
    <div class="row">
        <div class="col-md-2">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
                <div class="stat-label">Users</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card green">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-number">{{ $totalStudents ?? 0 }}</div>
                <div class="stat-label">Students</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card yellow">
                <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="stat-number">{{ $totalTeachers ?? 0 }}</div>
                <div class="stat-label">Teachers</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card red">
                <div class="stat-icon"><i class="fas fa-school"></i></div>
                <div class="stat-number">{{ $totalClasses ?? 0 }}</div>
                <div class="stat-label">Classes</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card purple">
                <div class="stat-icon"><i class="fas fa-book"></i></div>
                <div class="stat-number">{{ $totalSubjects ?? 0 }}</div>
                <div class="stat-label">Subjects</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card teal">
                <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
                <div class="stat-number">{{ $totalGrades ?? 0 }}</div>
                <div class="stat-label">Grades</div>
            </div>
        </div>
    </div>

    <!-- Score Aggregates -->
    <h5 class="section-title">Score Statistics</h5>
    <div class="row">
        <div class="col-md-3">
            <div class="stat-card blue">
                <div class="stat-number">{{ $totalScore ?? 0 }}</div>
                <div class="stat-label">Total Score</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card green">
                <div class="stat-number">{{ number_format($avgScore ?? 0, 2) }}%</div>
                <div class="stat-label">Average Score</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card yellow">
                <div class="stat-number">{{ $maxScore ?? 0 }}%</div>
                <div class="stat-label">Max Score</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card red">
                <div class="stat-number">{{ $minScore ?? 0 }}%</div>
                <div class="stat-label">Min Score</div>
            </div>
        </div>
    </div>

    <!-- Status Counts -->
    <h5 class="section-title">Student Status</h5>
    <div class="row">
        <div class="col-md-4">
            <div class="stat-card green">
                <div class="stat-number">{{ $activeStudents ?? 0 }}</div>
                <div class="stat-label">Active Students</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card yellow">
                <div class="stat-number">{{ $pendingStudents ?? 0 }}</div>
                <div class="stat-label">Pending Students</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card red">
                <div class="stat-number">{{ $inactiveStudents ?? 0 }}</div>
                <div class="stat-label">Inactive Students</div>
            </div>
        </div>
    </div>

    <!-- Teachers with Class Count -->
    <div class="table-card mt-4">
        <h4><i class="fas fa-chalkboard-teacher"></i> Teachers with Class Count</h4>
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Teacher</th>
                    <th>Total Classes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachersWithClassCount ?? [] as $teacher)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $teacher->name }}</strong></td>
                        <td><span class="badge-custom">{{ $teacher->classes_count }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-3">No data found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Classes with Student Count -->
    <div class="table-card">
        <h4><i class="fas fa-school"></i> Classes with Student Count</h4>
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Class</th>
                    <th>Total Students</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classesWithStudentCount ?? [] as $class)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $class->name }}</strong></td>
                        <td><span class="badge-custom">{{ $class->students_count }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-3">No data found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ✅ Back Button (Bottom) -->
    <div class="text-center mt-4 mb-5">
        <a href="{{ route('students.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

</div>
@endsection