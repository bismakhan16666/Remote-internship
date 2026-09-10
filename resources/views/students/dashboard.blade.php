@extends('layouts.app')

@section('title', 'My Dashboard')
@section('subtitle', 'Welcome to your student dashboard')

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
    .profile-card .avatar {
        width: 100px; height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #f5c842;
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
    .info-box .value {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 16px;
    }
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
    .table-custom tbody td { vertical-align: middle; padding: 12px; }
    .badge-success { background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-warning { background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-danger  { background: #f8d7da; color: #721c24; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .course-card {
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        color: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        border-left: 5px solid #f5c842;
        transition: 0.3s;
    }
    .course-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(26,26,46,0.3);
    }
    .course-card h5 { color: #f5c842; font-weight: 700; margin-bottom: 10px; }
    .course-card p { margin-bottom: 5px; font-size: 14px; opacity: 0.9; }
    .comment-card {
        background: #f8f9fc;
        border-left: 4px solid #f5c842;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .comment-card p { margin: 0 0 5px; color: #1a1a2e; }
    .comment-card small { color: #999; }
    .stat-box {
        text-align: center;
        padding: 20px;
        border-radius: 12px;
        color: white;
    }
    .stat-box.blue   { background: linear-gradient(135deg, #4e73df, #224abe); }
    .stat-box.green  { background: linear-gradient(135deg, #1cc88a, #13855c); }
    .stat-box.yellow { background: linear-gradient(135deg, #f6c23e, #dda20a); }
    .stat-box.red    { background: linear-gradient(135deg, #e74a3b, #be2617); }
    .stat-box .stat-number { font-size: 28px; font-weight: 700; }
    .stat-box .stat-label  { font-size: 13px; opacity: 0.9; margin-top: 5px; }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                @if($student->image)
                    <img src="{{ asset('storage/' . $student->image) }}" alt="Student" class="avatar">
                @else
                    <div class="avatar-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <h3>{{ $student->name }}</h3>
                <span class="role-badge">Student</span>
                <p style="color: #666; margin-top: 10px; margin-bottom: 0;">
                    <i class="fas fa-envelope"></i> {{ $student->email }}
                </p>
            </div>
            <div class="col-md-4 text-end">
                <div class="info-box">
                    <label>Overall Score</label>
                    <div class="value" style="font-size: 26px; color: {{ $student->score >= 80 ? '#1cc88a' : ($student->score >= 50 ? '#f6c23e' : '#e74a3b') }};">
                        {{ $student->score ?? 0 }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-box blue">
                <div class="stat-number">{{ $student->subjects->count() }}</div>
                <div class="stat-label">Total Subjects</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box green">
                <div class="stat-number">{{ number_format($student->subjects->avg('pivot.grade') ?? 0, 1) }}%</div>
                <div class="stat-label">Average Grade</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box yellow">
                <div class="stat-number">{{ $student->subjects->max('pivot.grade') ?? 0 }}%</div>
                <div class="stat-label">Highest Grade</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box red">
                <div class="stat-number">{{ $student->comments->count() }}</div>
                <div class="stat-label">Teacher Remarks</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Personal Info -->
        <div class="col-md-6">
            <div class="card-custom">
                <h4><i class="fas fa-user"></i> Personal Information</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box">
                            <label>Full Name</label>
                            <div class="value">{{ $student->name }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label>Email</label>
                            <div class="value" style="font-size: 13px;">{{ $student->email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label>Age</label>
                            <div class="value">{{ $student->age }} years</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label>Gender</label>
                            <div class="value">{{ $student->gender == 'm' ? 'Male' : 'Female' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label>Date of Birth</label>
                            <div class="value">{{ $student->date_of_birth }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label>Status</label>
                            <div class="value">
                                <span class="badge-{{ $student->status === 'active' ? 'success' : ($student->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($student->status ?? 'Active') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class & Teacher -->
        <div class="col-md-6">
            <div class="card-custom">
                <h4><i class="fas fa-school"></i> My Class & Teacher</h4>
                @if($student->classes)
                    <div class="info-box">
                        <label>Class Name</label>
                        <div class="value">{{ $student->classes->name }}</div>
                    </div>
                    <div class="info-box">
                        <label>Description</label>
                        <div class="value" style="font-size: 14px;">{{ $student->classes->description ?? 'N/A' }}</div>
                    </div>
                    @if($student->classes->teacher)
                        <div class="info-box">
                            <label>Class Teacher</label>
                            <div class="value">
                                <i class="fas fa-chalkboard-teacher" style="color: #f5c842;"></i>
                                {{ $student->classes->teacher->name ?? 'N/A' }}
                            </div>
                        </div>
                    @endif
                @else
                    <p style="color: #999; text-align: center; padding: 20px;">No class assigned</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Enrolled Courses -->
    @if($student->classes && $student->classes->subjects && $student->classes->subjects->count() > 0)
    <div class="card-custom">
        <h4><i class="fas fa-graduation-cap"></i> Enrolled Courses</h4>
        <div class="row">
            @foreach($student->classes->subjects as $subject)
                <div class="col-md-4">
                    <div class="course-card">
                        <h5><i class="fas fa-book"></i> {{ $subject->name }}</h5>
                        <p><i class="fas fa-layer-group"></i> {{ $student->classes->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Subjects & Grades -->
    <div class="card-custom">
        <h4><i class="fas fa-clipboard-list"></i> My Subjects & Grades</h4>
        @if($student->subjects && $student->subjects->count() > 0)
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th>Performance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $subject->name }}</strong></td>
                            <td>
                                <span style="font-weight: 700; font-size: 16px; color: {{ $subject->pivot->grade >= 80 ? '#1cc88a' : ($subject->pivot->grade >= 50 ? '#f6c23e' : '#e74a3b') }};">
                                    {{ $subject->pivot->grade }}%
                                </span>
                            </td>
                            <td>
                                @if($subject->pivot->grade >= 80)
                                    <span class="badge-success">Excellent</span>
                                @elseif($subject->pivot->grade >= 60)
                                    <span class="badge-success">Good</span>
                                @elseif($subject->pivot->grade >= 40)
                                    <span class="badge-warning">Average</span>
                                @else
                                    <span class="badge-danger">Needs Improvement</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #999; text-align: center; padding: 30px;">No grades available yet</p>
        @endif
    </div>

    <!-- Teacher's Remarks -->
    <div class="card-custom">
        <h4><i class="fas fa-comments"></i> Teacher's Remarks</h4>
        @if($student->comments && $student->comments->count() > 0)
            @foreach($student->comments as $comment)
                <div class="comment-card">
                    <p>{{ $comment->comment }}</p>
                    <small><i class="fas fa-clock"></i> {{ $comment->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        @else
            <p style="color: #999; text-align: center; padding: 30px;">No remarks yet</p>
        @endif
    </div>

</div>
@endsection