@extends('layouts.app')

@section('title', 'Teacher Dashboard')
@section('subtitle', 'Welcome to your teacher dashboard')

@section('styles')
<style>
    .dashboard-container { max-width: 1300px; margin: 30px auto; padding: 0 20px; }

    .profile-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        border-left: 5px solid #1a1a2e;
    }
    .profile-card .avatar-placeholder {
        width: 100px; height: 100px;
        border-radius: 50%;
        background: #1a1a2e;
        color: #f5c842;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        border: 4px solid #f5c842;
    }
    .profile-card h3 { color: #1a1a2e; font-weight: 700; margin-bottom: 5px; }
    .role-badge {
        background: #f5c842;
        color: #1a1a2e;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .stat-box {
        text-align: center;
        padding: 25px;
        border-radius: 12px;
        color: white;
        margin-bottom: 20px;
    }
    .stat-box.blue   { background: linear-gradient(135deg, #4e73df, #224abe); }
    .stat-box.green  { background: linear-gradient(135deg, #1cc88a, #13855c); }
    .stat-box.yellow { background: linear-gradient(135deg, #f6c23e, #dda20a); }
    .stat-box .stat-number { font-size: 32px; font-weight: 700; }
    .stat-box .stat-label  { font-size: 14px; opacity: 0.9; margin-top: 5px; }

    .info-box {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .info-box label {
        font-weight: 600;
        color: #666;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 3px;
        display: block;
    }
    .info-box .value { font-weight: 600; color: #1a1a2e; font-size: 16px; }

    .card-custom {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }
    .card-custom h4 {
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
    .class-card {
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        color: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        border-left: 5px solid #f5c842;
        transition: 0.3s;
    }
    .class-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(26,26,46,0.3);
    }
    .class-card h5 { color: #f5c842; font-weight: 700; margin-bottom: 10px; }
    .class-card p { margin-bottom: 5px; font-size: 14px; opacity: 0.9; }
    .badge-success { background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-warning { background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-danger  { background: #f8d7da; color: #721c24; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    <!-- Profile -->
    <div class="profile-card">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <div class="avatar-placeholder">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <div class="col-md-6">
                <h3>{{ $teacher->name }}</h3>
                <span class="role-badge">Teacher</span>
                @if($teacher->phone)
                    <p style="color: #666; margin-top: 10px; margin-bottom: 0;">
                        <i class="fas fa-phone"></i> {{ $teacher->phone }}
                    </p>
                @endif
            </div>
            <div class="col-md-4 text-end">
                <div class="info-box">
                    <label>Total Classes</label>
                    <div class="value" style="font-size: 26px; color: #1cc88a;">{{ $totalClasses }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row">
        <div class="col-md-4">
            <div class="stat-box blue">
                <div class="stat-number">{{ $totalClasses }}</div>
                <div class="stat-label">My Classes</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-box green">
                <div class="stat-number">{{ $totalStudents }}</div>
                <div class="stat-label">My Students</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-box yellow">
                <div class="stat-number">{{ $totalSubjects }}</div>
                <div class="stat-label">Total Subjects</div>
            </div>
        </div>
    </div>

    <!-- My Classes -->
    <div class="card-custom">
        <h4><i class="fas fa-school"></i> My Classes</h4>
        @if($teacher->classes->count() > 0)
            <div class="row">
                @foreach($teacher->classes as $class)
                    <div class="col-md-4">
                        <div class="class-card">
                            <h5><i class="fas fa-book"></i> {{ $class->name }}</h5>
                            <p><i class="fas fa-info-circle"></i> {{ $class->description ?? 'No description' }}</p>
                            <p><i class="fas fa-users"></i> {{ $class->students->count() }} Students</p>
                            <p><i class="fas fa-book-open"></i> {{ $class->subjects->count() }} Subjects</p>
                            <a href="{{ route('teacher.class', $class->id) }}" class="btn btn-sm btn-light mt-2">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #999; text-align: center; padding: 30px;">No classes assigned yet</p>
        @endif
    </div>

    <!-- My Students -->
    <div class="card-custom">
        <h4><i class="fas fa-users"></i> My Students</h4>
        @if($students->count() > 0)
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Class</th>
                        <th>Score</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $student->name }}</strong></td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->classes->name ?? 'N/A' }}</td>
                            <td>
                                <span style="font-weight: 700; color: {{ $student->score >= 80 ? '#1cc88a' : ($student->score >= 50 ? '#f6c23e' : '#e74a3b') }};">
                                    {{ $student->score ?? 0 }}%
                                </span>
                            </td>
                            <td>
                                <span class="badge-{{ $student->status === 'active' ? 'success' : ($student->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($student->status ?? 'Active') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('teacher.student', $student->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $students->links() }}
            </div>
        @else
            <p style="color: #999; text-align: center; padding: 30px;">No students in your classes yet</p>
        @endif
    </div>

</div>
@endsection