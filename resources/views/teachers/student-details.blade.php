@extends('layouts.app')

@section('title', 'Student Details')
@section('subtitle', $student->name)

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
    .comment-card {
        background: #f8f9fc;
        border-left: 4px solid #f5c842;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
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

    <!-- Student Info -->
    <div class="card-custom">
        <h4><i class="fas fa-user"></i> Student Information</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <label>Name</label>
                    <div class="value">{{ $student->name }}</div>
                </div>
                <div class="info-box">
                    <label>Email</label>
                    <div class="value">{{ $student->email }}</div>
                </div>
                <div class="info-box">
                    <label>Age</label>
                    <div class="value">{{ $student->age }} years</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <label>Class</label>
                    <div class="value">{{ $student->classes->name ?? 'N/A' }}</div>
                </div>
                <div class="info-box">
                    <label>Score</label>
                    <div class="value" style="font-size: 24px; color: {{ $student->score >= 80 ? '#1cc88a' : ($student->score >= 50 ? '#f6c23e' : '#e74a3b') }};">
                        {{ $student->score ?? 0 }}%
                    </div>
                </div>
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

    <!-- Subjects & Grades -->
    <div class="card-custom">
        <h4><i class="fas fa-clipboard-list"></i> Subjects & Grades</h4>
        @if($student->subjects->count() > 0)
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $subject->name }}</strong></td>
                            <td>
                                <span style="font-weight: 700; color: {{ $subject->pivot->grade >= 80 ? '#1cc88a' : ($subject->pivot->grade >= 50 ? '#f6c23e' : '#e74a3b') }};">
                                    {{ $subject->pivot->grade }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #999;">No grades available</p>
        @endif
    </div>

    <!-- Add Remark -->
    <div class="card-custom">
        <h4><i class="fas fa-comment-plus"></i> Add Remark</h4>
        <form action="{{ route('teacher.comment', $student->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="comment" class="form-control" rows="3" placeholder="Write your remark about this student..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Add Remark
            </button>
        </form>
    </div>

    <!-- Existing Remarks -->
    <div class="card-custom">
        <h4><i class="fas fa-comments"></i> All Remarks</h4>
        @if($student->comments->count() > 0)
            @foreach($student->comments as $comment)
                <div class="comment-card">
                    <p>{{ $comment->comment }}</p>
                    <small><i class="fas fa-clock"></i> {{ $comment->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        @else
            <p style="color: #999;">No remarks yet</p>
        @endif
    </div>

</div>
@endsection