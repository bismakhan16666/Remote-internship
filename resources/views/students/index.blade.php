@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('subtitle', 'Manage Students, Teachers & Settings')

@section('styles')
<style>
    .dashboard-container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border-left: 5px solid;
        margin-bottom: 20px;
        transition: 0.3s;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
    .stat-card .stat-number { font-size: 30px; font-weight: 700; }
    .stat-card .stat-label { font-size: 13px; color: #666; margin-top: 5px; }
    .stat-card .stat-icon { float: right; font-size: 38px; opacity: 0.2; }
    .stat-card.blue { border-left-color: #4e73df; }
    .stat-card.green { border-left-color: #1cc88a; }
    .stat-card.purple { border-left-color: #6f42c1; }
    .stat-card.teal { border-left-color: #20c997; }

    .nav-tabs-custom {
        border-bottom: 3px solid #f5c842;
        margin-bottom: 25px;
        background: white;
        padding: 10px 20px 0;
        border-radius: 15px 15px 0 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .nav-tabs-custom .nav-link {
        border: none;
        color: #1a1a2e;
        font-weight: 600;
        padding: 12px 25px;
        border-radius: 8px 8px 0 0;
        margin-right: 5px;
        transition: 0.3s;
        background: transparent;
    }
    .nav-tabs-custom .nav-link.active { background: #1a1a2e; color: #f5c842; }
    .nav-tabs-custom .nav-link:hover:not(.active) { background: #f5c842; color: #1a1a2e; }

    .table-card {
        background: white;
        border-radius: 0 15px 15px 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }
    .table-card .card-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f2f5;
        flex-wrap: wrap;
        gap: 10px;
    }
    .table-card .card-header-custom h4 { font-weight: 700; color: #1a1a2e; margin: 0; }
    .badge-custom { background: #1a1a2e; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; }

    .table-custom thead th {
        font-weight: 600;
        color: #4a4a4a;
        background: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
        padding: 15px 12px;
        white-space: nowrap;
    }
    .table-custom tbody td { padding: 12px; vertical-align: middle; }
    .table-custom tbody tr:hover { background: #f8f9fc; }

    .status-badge { padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .status-badge.active { background: #d4edda; color: #155724; }
    .status-badge.inactive { background: #f8d7da; color: #721c24; }

    .gender-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .gender-badge.male { background: #cce5ff; color: #004085; }
    .gender-badge.female { background: #fce4ec; color: #c62828; }

    .action-btn {
        border: none;
        background: none;
        padding: 6px 10px;
        border-radius: 5px;
        transition: 0.3s;
        font-size: 14px;
        cursor: pointer;
    }
    .action-btn.edit { color: #f6c23e; }
    .action-btn.edit:hover { background: #f6c23e; color: white; }
    .action-btn.delete { color: #e74a3b; }
    .action-btn.delete:hover { background: #e74a3b; color: white; }

    .btn-add-student {
        background: #f5c842;
        color: #1a1a2e;
        padding: 8px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-add-student:hover { background: #1a1a2e; color: #f5c842; transform: translateY(-2px); }

    .student-img { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd; }
    .student-img-placeholder {
        width: 40px; height: 40px;
        background: #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .settings-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    .settings-card h4 {
        color: #1a1a2e;
        font-weight: 700;
        border-bottom: 3px solid #f5c842;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }
    .settings-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f2f5;
    }
    .settings-item:last-child { border-bottom: none; }
    .settings-item .label { font-weight: 600; color: #1a1a2e; }
    .settings-item .value { color: #666; }
    .btn-setting {
        background: #1a1a2e;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
        font-size: 14px;
    }
    .btn-setting:hover { background: #f5c842; color: #1a1a2e; }

    .pagination-wrapper { margin-top: 25px; padding-top: 20px; border-top: 1px solid #e3e6f0; }
    .pagination-info { font-size: 14px; color: #6c757d; }
    .pagination-info strong { color: #1a1a2e; }

    .pagination {
        display: flex;
        justify-content: flex-end;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }
    .pagination .page-item { display: inline-block; }
    .pagination .page-link {
        display: block;
        padding: 8px 14px;
        font-size: 14px;
        font-weight: 500;
        color: #1a1a2e;
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .pagination .page-link:hover {
        background-color: #f5c842;
        color: #1a1a2e;
        border-color: #f5c842;
        transform: translateY(-2px);
    }
    .pagination .page-item.active .page-link {
        background-color: #1a1a2e;
        color: #ffffff;
        border-color: #1a1a2e;
    }
    .pagination .page-item.disabled .page-link {
        color: #bbb;
        background-color: #f5f5f5;
        border-color: #e8e8e8;
        cursor: not-allowed;
        pointer-events: none;
    }

    .alert-success { border-radius: 8px; border-left: 5px solid #1cc88a; }
    .alert-danger { border-radius: 8px; border-left: 5px solid #e74a3b; }
    .empty-state { text-align: center; padding: 50px 20px; }
    .empty-state i { font-size: 60px; color: #ccc; margin-bottom: 15px; }
    .empty-state h5 { color: #999; }

    .view-only-badge {
        background: #e9ecef;
        color: #6c757d;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .cache-badge {
        background: #d4edda;
        color: #155724;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        margin-left: 10px;
    }

    @media (max-width: 768px) {
        .pagination { justify-content: center; gap: 4px; }
        .pagination .page-link { padding: 6px 10px; font-size: 12px; }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    {{-- ============================================ --}}
    {{-- ALERTS — Reusable Component --}}
    {{-- ============================================ --}}
    <x-alert type="success" :message="session('success')" />
    <x-alert type="error" :message="session('error')" />

    {{-- ============================================ --}}
    {{-- STATS — Reusable Components (From Cache) --}}
    {{-- ============================================ --}}
    <div class="row">
        <div class="col-md-3">
            <x-stat-card 
                color="blue" 
                icon="fa-user-graduate" 
                :number="$stats['totalStudents'] ?? 0" 
                label="Total Students" 
            />
        </div>
        <div class="col-md-3">
            <x-stat-card 
                color="green" 
                icon="fa-user-check" 
                :number="$stats['activeStudents'] ?? 0" 
                label="Active Students" 
            />
        </div>
        <div class="col-md-3">
            <x-stat-card 
                color="purple" 
                icon="fa-chalkboard-teacher" 
                :number="$stats['totalTeachers'] ?? 0" 
                label="Total Teachers" 
            />
        </div>
        <div class="col-md-3">
            <x-stat-card 
                color="teal" 
                icon="fa-school" 
                :number="$stats['totalClasses'] ?? 0" 
                label="Total Classes" 
            />
        </div>
    </div>

    {{-- Cache Indicator --}}
    <div class="alert alert-info" style="border-radius: 10px; border-left: 5px solid #17a2b8;">
        <i class="fas fa-database"></i>
        <strong>Cache Active:</strong> Ye data 10 minutes tak cache me rahega.
        <a href="{{ route('cache.clear') }}" class="btn btn-sm btn-warning float-end">
            <i class="fas fa-sync"></i> Clear Cache
        </a>
    </div>

    <!-- TABS -->
    <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#students-tab" type="button">
                <i class="fas fa-user-graduate"></i> Students ({{ $stats['totalStudents'] }})
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#teachers-tab" type="button">
                <i class="fas fa-chalkboard-teacher"></i> Teachers ({{ $stats['totalTeachers'] }})
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#settings-tab" type="button">
                <i class="fas fa-cog"></i> Settings
            </button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- ============================================ -->
        <!-- TAB 1: STUDENTS -->
        <!-- ============================================ -->
        <div class="tab-pane fade show active" id="students-tab">
            <div class="table-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-user-graduate"></i> Students List</h4>
                    <div class="d-flex gap-2 align-items-center">
                        <span class="badge-custom">{{ $students->total() }} Students</span>

                        {{-- Add Student — Admin only (Policy) --}}
                        @can('create', App\Models\Student::class)
                            <a href="{{ route('students.create') }}" class="btn-add-student">
                                <i class="fas fa-plus"></i> Add Student
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Class</th>
                                <th>Score</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($student->image)
                                            <img src="{{ asset('storage/' . $student->image) }}" class="student-img">
                                        @else
                                            <div class="student-img-placeholder">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $student->name }}</strong></td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->age }}</td>
                                    <td>
                                        <span class="gender-badge {{ $student->gender == 'm' ? 'male' : 'female' }}">
                                            {{ $student->gender == 'm' ? 'Male' : 'Female' }}
                                        </span>
                                    </td>
                                    <td>{{ $student->classes->name ?? 'N/A' }}</td>
                                    <td>
                                        <strong style="color: {{ $student->score >= 80 ? '#1cc88a' : ($student->score >= 50 ? '#f6c23e' : '#e74a3b') }};">
                                            {{ $student->score ?? 0 }}%
                                        </strong>
                                    </td>
                                    <td>
                                        <x-status-badge :status="$student->status ?? 'active'" />
                                    </td>
                                    <td>
                                        @can('update', $student)
                                            <a href="{{ route('students.edit', $student->id) }}" class="action-btn edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete', $student)
                                            <form action="{{ route('students.delete', $student->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-btn delete" onclick="return confirm('Delete this student?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                        @cannot('update', $student)
                                            <span class="view-only-badge">View Only</span>
                                        @endcannot
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <x-empty-state icon="fa-user-graduate" message="No Students Found" />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($students->hasPages())
                <div class="pagination-wrapper">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="pagination-info mb-0">
                                <i class="fas fa-info-circle"></i>
                                Showing <strong>{{ $students->firstItem() ?? 0 }}</strong>
                                to <strong>{{ $students->lastItem() ?? 0 }}</strong>
                                of <strong>{{ $students->total() }}</strong> students
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav>
                                <ul class="pagination justify-content-end mb-0">
                                    @if($students->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">&laquo; Prev</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $students->previousPageUrl() }}">&laquo; Prev</a></li>
                                    @endif

                                    @for($i = 1; $i <= $students->lastPage(); $i++)
                                        @if($i == 1 || $i == $students->lastPage() || ($i >= $students->currentPage() - 2 && $i <= $students->currentPage() + 2))
                                            <li class="page-item {{ $students->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $students->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endif
                                    @endfor

                                    @if($students->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $students->nextPageUrl() }}">Next &raquo;</a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- ============================================ -->
        <!-- TAB 2: TEACHERS -->
        <!-- ============================================ -->
        <div class="tab-pane fade" id="teachers-tab">
            <div class="table-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-chalkboard-teacher"></i> Teachers List</h4>
                    <div class="d-flex gap-2 align-items-center">
                        <span class="badge-custom">{{ $teachers->total() }} Teachers</span>

                        @can('create', App\Models\Teachers::class)
                            <a href="{{ route('teachers.create') }}" class="btn-add-student">
                                <i class="fas fa-plus"></i> Add Teacher
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Qualification</th>
                                <th>Specialization</th>
                                <th>Experience</th>
                                <th>Classes</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($teacher->image)
                                            <img src="{{ asset('storage/' . $teacher->image) }}" class="student-img">
                                        @else
                                            <div class="student-img-placeholder">
                                                <i class="fas fa-chalkboard-teacher text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $teacher->name }}</strong></td>
                                    <td>{{ $teacher->email ?? 'N/A' }}</td>
                                    <td>{{ $teacher->phone ?? 'N/A' }}</td>
                                    <td>{{ $teacher->qualification ?? 'N/A' }}</td>
                                    <td>{{ $teacher->subject_specialization ?? 'N/A' }}</td>
                                    <td>{{ $teacher->experience ?? 'N/A' }}</td>
                                    <td>
                                        @if($teacher->classes->count() > 0)
                                            <span class="badge bg-primary">{{ $teacher->classes->count() }} Classes</span>
                                        @else
                                            <span class="text-muted">No Classes</span>
                                        @endif
                                    </td>
                                    <td>
                                        <x-status-badge :status="$teacher->status ?? 'active'" />
                                    </td>
                                    <td>
                                        @can('update', $teacher)
                                            <a href="{{ route('teachers.edit', $teacher->id) }}" class="action-btn edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete', $teacher)
                                            <form action="{{ route('teachers.delete', $teacher->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-btn delete" onclick="return confirm('Delete this teacher?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                        @cannot('update', $teacher)
                                            <span class="view-only-badge">View Only</span>
                                        @endcannot
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <x-empty-state icon="fa-chalkboard-teacher" message="No Teachers Found" />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($teachers->hasPages())
                <div class="pagination-wrapper">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="pagination-info mb-0">
                                <i class="fas fa-info-circle"></i>
                                Showing <strong>{{ $teachers->firstItem() ?? 0 }}</strong>
                                to <strong>{{ $teachers->lastItem() ?? 0 }}</strong>
                                of <strong>{{ $teachers->total() }}</strong> teachers
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav>
                                <ul class="pagination justify-content-end mb-0">
                                    @if($teachers->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">&laquo; Prev</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $teachers->previousPageUrl() }}">&laquo; Prev</a></li>
                                    @endif

                                    @for($i = 1; $i <= $teachers->lastPage(); $i++)
                                        @if($i == 1 || $i == $teachers->lastPage() || ($i >= $teachers->currentPage() - 2 && $i <= $teachers->currentPage() + 2))
                                            <li class="page-item {{ $teachers->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $teachers->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endif
                                    @endfor

                                    @if($teachers->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $teachers->nextPageUrl() }}">Next &raquo;</a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- ============================================ -->
        <!-- TAB 3: SETTINGS -->
        <!-- ============================================ -->
        <div class="tab-pane fade" id="settings-tab">
            <div class="row">
                <div class="col-md-6">
                    <div class="settings-card">
                        <h4><i class="fas fa-user-shield"></i> Account Settings</h4>
                        <div class="settings-item">
                            <div><div class="label">Admin Name</div><div class="value">{{ Auth::user()->name }}</div></div>
                            <a href="#" class="btn-setting">Edit</a>
                        </div>
                        <div class="settings-item">
                            <div><div class="label">Email Address</div><div class="value">{{ Auth::user()->email }}</div></div>
                            <a href="#" class="btn-setting">Edit</a>
                        </div>
                        <div class="settings-item">
                            <div><div class="label">Password</div><div class="value">••••••••</div></div>
                            <a href="#" class="btn-setting">Change</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="settings-card">
                        <h4><i class="fas fa-school"></i> System Stats</h4>
                        <div class="settings-item">
                            <div><div class="label">Total Students</div></div>
                            <div class="value"><strong>{{ $stats['totalStudents'] }}</strong></div>
                        </div>
                        <div class="settings-item">
                            <div><div class="label">Total Teachers</div></div>
                            <div class="value"><strong>{{ $stats['totalTeachers'] }}</strong></div>
                        </div>
                        <div class="settings-item">
                            <div><div class="label">Total Classes</div></div>
                            <div class="value"><strong>{{ $stats['totalClasses'] }}</strong></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="settings-card">
                        <h4><i class="fas fa-tools"></i> Quick Actions</h4>
                        <div class="row">
                            @can('create', App\Models\Student::class)
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('students.create') }}" class="btn btn-dark w-100 py-3">
                                    <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                                    Add Student
                                </a>
                            </div>
                            @endcan

                            @can('create', App\Models\Teachers::class)
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('teachers.create') }}" class="btn btn-dark w-100 py-3">
                                    <i class="fas fa-chalkboard-teacher fa-2x d-block mb-2"></i>
                                    Add Teacher
                                </a>
                            </div>
                            @endcan

                            <div class="col-md-3 mb-3">
                                <a href="{{ route('students.index') }}" class="btn btn-dark w-100 py-3">
                                    <i class="fas fa-users fa-2x d-block mb-2"></i>
                                    View Students
                                </a>
                            </div>

                            <div class="col-md-3 mb-3">
                                <a href="{{ route('logout') }}" class="btn btn-danger w-100 py-3"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-2x d-block mb-2"></i>
                                    Logout
                                </a>
                            </div>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection