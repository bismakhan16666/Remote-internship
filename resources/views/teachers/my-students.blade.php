@extends('layouts.app')

@section('title', 'My Students')
@section('subtitle', 'Students in your classes')

@section('styles')
<style>
    .dashboard-container { max-width: 1300px; margin: 30px auto; padding: 0 20px; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }
    .page-header h3 {
        color: #1a1a2e;
        font-weight: 700;
        margin: 0;
    }
    .btn-back {
        background: #1a1a2e;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-back:hover {
        background: #f5c842;
        color: #1a1a2e;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border-left: 5px solid;
        margin-bottom: 20px;
    }
    .stat-card .stat-number { font-size: 30px; font-weight: 700; }
    .stat-card .stat-label { font-size: 13px; color: #666; margin-top: 5px; }
    .stat-card .stat-icon { float: right; font-size: 38px; opacity: 0.2; }
    .stat-card.blue { border-left-color: #4e73df; }
    .stat-card.green { border-left-color: #1cc88a; }

    .table-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
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
        padding: 15px 12px;
    }
    .table-custom tbody td { padding: 12px; vertical-align: middle; }
    .table-custom tbody tr:hover { background: #f8f9fc; }

    .badge-success { background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-warning { background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-danger  { background: #f8d7da; color: #721c24; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }

    .pagination-wrapper {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e3e6f0;
    }
    .pagination { justify-content: flex-end; }
    .pagination .page-link {
        color: #1a1a2e;
        border: 1px solid #e0e0e0;
        padding: 8px 14px;
        margin: 0 3px;
        border-radius: 6px;
    }
    .pagination .page-link:hover { background: #f5c842; color: #1a1a2e; }
    .pagination .active .page-link { background: #1a1a2e; color: white; }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    <!-- Page Header -->
    <div class="page-header">
        <h3><i class="fas fa-users"></i> My Students</h3>
        <a href="{{ route('teacher.dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Stats -->
    <div class="row">
        <div class="col-md-6">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-number">{{ $totalStudents }}</div>
                <div class="stat-label">Total Students in My Classes</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card green">
                <div class="stat-icon"><i class="fas fa-school"></i></div>
                <div class="stat-number">{{ $totalClasses }}</div>
                <div class="stat-label">Total Classes</div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="table-card">
        <h4><i class="fas fa-user-graduate"></i> Students List</h4>

        @if($students->count() > 0)
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Class</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                <td><strong>{{ $student->name }}</strong></td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->age }}</td>
                                <td>{{ $student->gender == 'm' ? 'Male' : 'Female' }}</td>
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
            </div>

            <div class="pagination-wrapper">
                {{ $students->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-graduate" style="font-size: 60px; color: #ccc;"></i>
                <h5 class="text-muted mt-3">No Students in Your Classes</h5>
            </div>
        @endif
    </div>

</div>
@endsection