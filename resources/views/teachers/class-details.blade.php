@extends('layouts.app')

@section('title', 'Class Details')
@section('subtitle', $class->name)

@section('styles')
<style>
    .dashboard-container { max-width: 1300px; margin: 30px auto; padding: 0 20px; }
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
    .table-custom thead th {
        font-weight: 600;
        color: #4a4a4a;
        background: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
    }
    .badge-success { background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-warning { background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-danger  { background: #f8d7da; color: #721c24; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <!-- Class Info -->
    <div class="card-custom">
        <h4><i class="fas fa-school"></i> {{ $class->name }}</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <label>Description</label>
                    <div class="value">{{ $class->description ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <label>Teacher</label>
                    <div class="value">{{ $class->teacher->name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Subjects -->
    <div class="card-custom">
        <h4><i class="fas fa-book"></i> Subjects</h4>
        @if($class->subjects->count() > 0)
            <ul style="list-style: none; padding: 0;">
                @foreach($class->subjects as $subject)
                    <li style="padding: 10px; background: #f8f9fc; border-radius: 8px; margin-bottom: 8px;">
                        <i class="fas fa-book-open" style="color: #f5c842;"></i>
                        <strong>{{ $subject->name }}</strong>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color: #999;">No subjects assigned</p>
        @endif
    </div>

    <!-- Class Students -->
    <div class="card-custom">
        <h4><i class="fas fa-users"></i> Students ({{ $class->students->count() }})</h4>
        @if($class->students->count() > 0)
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Score</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($class->students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $student->name }}</strong></td>
                            <td>{{ $student->email }}</td>
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
        @else
            <p style="color: #999;">No students in this class</p>
        @endif
    </div>

</div>
@endsection