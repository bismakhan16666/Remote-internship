<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; }
        .header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.3);
        }
        .header h1 { font-size: 28px; font-weight: 700; letter-spacing: 1px; }
        .header h1 span { color: #f5c842; }
        .header .subtitle { font-size: 14px; color: #aaa; margin-top: 5px; }
        .nav-bar {
            background: #16213e;
            padding: 12px 0;
            border-bottom: 3px solid #f5c842;
        }
        .nav-bar a {
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            font-weight: 500;
            transition: 0.3s;
            border-radius: 5px;
        }
        .nav-bar a:hover { background: #f5c842; color: #1a1a2e; }
        .nav-bar a.active { background: #f5c842; color: #1a1a2e; }
        .container-custom { max-width: 1300px; margin: 30px auto; padding: 0 20px; }
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: 0.3s;
            border-left: 5px solid;
            margin-bottom: 20px;
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        .stat-card .stat-number { font-size: 32px; font-weight: 700; }
        .stat-card .stat-label { font-size: 14px; color: #666; margin-top: 5px; }
        .stat-card .stat-icon { float: right; font-size: 40px; opacity: 0.2; }
        .stat-card.blue { border-left-color: #4e73df; }
        .stat-card.green { border-left-color: #1cc88a; }
        .stat-card.yellow { border-left-color: #f6c23e; }
        .stat-card.red { border-left-color: #e74a3b; }
        .table-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-top: 30px;
        }
        .table-card .card-header-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f2f5;
        }
        .table-card .card-header-custom h4 { font-weight: 700; color: #1a1a2e; }
        .table-card .card-header-custom .badge-custom {
            background: #1a1a2e;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
        }
        .filter-section {
            background: #f8f9fc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #e3e6f0;
        }
        .filter-section .form-control, .filter-section .form-select {
            border-radius: 8px;
            border: 1px solid #d1d3e2;
            font-size: 14px;
        }
        .filter-section .form-control:focus, .filter-section .form-select:focus {
            border-color: #f5c842;
            box-shadow: 0 0 0 3px rgba(245, 200, 66, 0.2);
        }
        .filter-section label { font-weight: 600; color: #1a1a2e; font-size: 13px; }
        .btn-filter {
            background: #1a1a2e;
            color: white;
            padding: 8px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
        }
        .btn-filter:hover { background: #f5c842; color: #1a1a2e; }
        .btn-reset {
            background: #e74a3b;
            color: white;
            padding: 8px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-reset:hover { background: #c0392b; color: white; }
        .sort-link { color: #1a1a2e; text-decoration: none; cursor: pointer; }
        .sort-link:hover { color: #f5c842; }
        .sort-link i { font-size: 12px; }
        .table-card table { margin-bottom: 0; }
        .table-card table thead { background: #f8f9fc; }
        .table-card table thead th {
            font-weight: 600;
            color: #4a4a4a;
            border-bottom: 2px solid #e3e6f0;
            padding: 15px 12px;
        }
        .table-card table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #e3e6f0;
        }
        .table-card table tbody tr:hover { background: #f8f9fc; }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-badge.active { background: #d4edda; color: #155724; }
        .status-badge.inactive { background: #f8d7da; color: #721c24; }
        .status-badge.pending { background: #fff3cd; color: #856404; }
        .gender-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .gender-badge.male { background: #cce5ff; color: #004085; }
        .gender-badge.female { background: #fce4ec; color: #c62828; }
        .action-btn {
            border: none;
            background: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: 0.3s;
            font-size: 14px;
        }
        .action-btn.view { color: #4e73df; }
        .action-btn.view:hover { background: #4e73df; color: white; }
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
        }
        .btn-add-student:hover {
            background: #1a1a2e;
            color: #f5c842;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 200, 66, 0.3);
        }
        .alert-success { border-radius: 8px; border-left: 5px solid #1cc88a; }
        .alert-danger { border-radius: 8px; border-left: 5px solid #e74a3b; }
        .footer {
            background: #1a1a2e;
            color: white;
            text-align: center;
            padding: 25px 0;
            margin-top: 40px;
        }
        .footer a { color: #f5c842; text-decoration: none; }
        .footer a:hover { text-decoration: underline; }
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 60px; color: #ccc; margin-bottom: 20px; }
        .empty-state h4 { color: #666; }
        .pagination-wrapper {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e3e6f0;
        }
        .pagination-wrapper .text-muted { font-size: 14px; color: #6c757d !important; }
        .pagination-wrapper .text-muted strong { color: #1a1a2e; }
        .pagination-wrapper .text-muted i { margin-right: 5px; color: #1a1a2e; }
        .pagination {
            display: flex;
            justify-content: flex-end;
            gap: 6px;
            margin: 0;
            flex-wrap: wrap;
        }
        .pagination .page-item { display: inline-block; }
        .pagination .page-link {
            color: #1a1a2e;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            line-height: 1.4;
        }
        .pagination .page-link:hover {
            background: #f5c842;
            color: #1a1a2e;
            border-color: #f5c842;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 200, 66, 0.35);
        }
        .pagination .page-item.active .page-link {
            background: #1a1a2e;
            color: #ffffff;
            border-color: #1a1a2e;
        }
        .pagination .page-item.active .page-link:hover {
            background: #1a1a2e;
            color: #ffffff;
            transform: none;
            box-shadow: none;
        }
        .pagination .page-item.disabled .page-link {
            color: #bbb;
            background: #f5f5f5;
            border-color: #e8e8e8;
            cursor: not-allowed;
        }
        .pagination .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: none;
            background: #f5f5f5;
        }
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            border-radius: 6px;
            padding: 8px 16px;
        }
        .student-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }
        .student-image-placeholder {
            width: 50px;
            height: 50px;
            background: #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ddd;
        }
        .student-image-placeholder i { font-size: 20px; color: #999; }
        @media (max-width: 768px) {
            .pagination-wrapper .row { flex-direction: column; text-align: center; }
            .pagination-wrapper .col-md-6 { width: 100%; text-align: center; }
            .pagination-wrapper .d-flex { justify-content: center !important; }
            .pagination { justify-content: center; gap: 4px; }
            .pagination .page-link { padding: 6px 10px; font-size: 12px; }
            .pagination .page-item:first-child .page-link,
            .pagination .page-item:last-child .page-link { padding: 6px 12px; font-size: 12px; }
        }
        @media (max-width: 576px) {
            .pagination { gap: 3px; }
            .pagination .page-link { padding: 4px 8px; font-size: 11px; }
            .pagination .page-item:first-child .page-link,
            .pagination .page-item:last-child .page-link { padding: 4px 10px; font-size: 11px; }
            .pagination-wrapper .text-muted { font-size: 12px; }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Student <span>Management</span> System</h1>
                    <div class="subtitle">Manage your students efficiently with ease</div>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-graduation-cap" style="font-size: 50px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-bar">
        <div class="container">
            <a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('students.create') }}"><i class="fas fa-user-plus"></i> Add Student</a>
            <a href="#"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>
            <a href="#"><i class="fas fa-cog"></i> Settings</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-custom">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card blue">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number">{{ $totalStudents ?? 0 }}</div>
                    <div class="stat-label">Total Students</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card green">
                    <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                    <div class="stat-number">{{ $activeStudents ?? 0 }}</div>
                    <div class="stat-label">Active Students</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card yellow">
                    <div class="stat-icon"><i class="fas fa-user-clock"></i></div>
                    <div class="stat-number">{{ $pendingStudents ?? 0 }}</div>
                    <div class="stat-label">Pending Students</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card red">
                    <div class="stat-icon"><i class="fas fa-user-times"></i></div>
                    <div class="stat-number">{{ $inactiveStudents ?? 0 }}</div>
                    <div class="stat-label">Inactive Students</div>
                </div>
            </div>
        </div>

        <!-- Student Table -->
        <div class="table-card">
            <div class="card-header-custom">
                <h4><i class="fas fa-list"></i> Student Records</h4>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge-custom">{{ $students->count() ?? 0 }} Students</span>
                    <a href="{{ route('students.create') }}" class="btn-add-student">
                        <i class="fas fa-plus"></i> Add Student
                    </a>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <form action="{{ route('students.search') }}" method="GET" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Search by name..." value="{{ request('name') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Search by email..." value="{{ request('email') }}">
                        </div>
                        <div class="col-md-2">
                            <label>Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">All</option>
                                <option value="m" {{ request('gender') == 'm' ? 'selected' : '' }}>Male</option>
                                <option value="f" {{ request('gender') == 'f' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="">All</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Filter</button>
                                <a href="{{ route('students.index') }}" class="btn-reset"><i class="fas fa-undo"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label>Min Score</label>
                            <input type="number" name="min_score" class="form-control" placeholder="Min Score" value="{{ request('min_score') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Max Score</label>
                            <input type="number" name="max_score" class="form-control" placeholder="Max Score" value="{{ request('max_score') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Min Age</label>
                            <input type="number" name="min_age" class="form-control" placeholder="Min Age" value="{{ request('min_age') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Max Age</label>
                            <input type="number" name="max_age" class="form-control" placeholder="Max Age" value="{{ request('max_age') }}">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($students->isEmpty())
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <i class="fas fa-user-graduate"></i>
                                        <h4>No Students Found</h4>
                                        <p class="text-muted">Start by adding your first student.</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach($students as $student)
                            <tr>
                                <td><strong>#{{ $student->id }}</strong></td>
                                <td>
                                    @if($student->image)
                                        <img src="{{ asset('storage/' . $student->image) }}" alt="Student" class="student-image">
                                    @else
                                        <div class="student-image-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $student->name }}</strong></td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->age }}</td>
                                <td>
                                    <span class="gender-badge {{ $student->gender == 'm' ? 'male' : 'female' }}">
                                        <i class="fas {{ $student->gender == 'm' ? 'fa-mars' : 'fa-venus' }}"></i>
                                        {{ $student->gender == 'm' ? 'Male' : 'Female' }}
                                    </span>
                                </td>
                                <td>
                                    @if($student->score >= 80)
                                        <span style="color: #1cc88a; font-weight: 700;">{{ $student->score }}%</span>
                                    @elseif($student->score >= 50)
                                        <span style="color: #f6c23e; font-weight: 700;">{{ $student->score }}%</span>
                                    @else
                                        <span style="color: #e74a3b; font-weight: 700;">{{ $student->score }}%</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge {{ $student->status ?? 'active' }}">
                                        {{ ucfirst($student->status ?? 'Active') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('students.delete', $student->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination Section -->
            <div class="pagination-wrapper">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle"></i>
                            Showing 
                            <strong>{{ $students->firstItem() }}</strong> 
                            to 
                            <strong>{{ $students->lastItem() }}</strong> 
                            of 
                            <strong>{{ $students->total() }}</strong> 
                            entries
                        </p>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                @if($students->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo; Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $students->previousPageUrl() }}">&laquo; Previous</a>
                                    </li>
                                @endif

                                @for($i = 1; $i <= $students->lastPage(); $i++)
                                    <li class="page-item {{ $students->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $students->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if($students->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $students->nextPageUrl() }}">Next &raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next &raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <p>&copy; 2026 Student Management System. All Rights Reserved.</p>
            <p>
                <a href="#">About Us</a> |
                <a href="#">Contact Us</a> |
                <a href="#">Privacy Policy</a>
            </p>
        </div>
    </div>

    <script>
        document.querySelectorAll('#filterForm select, #filterForm input').forEach(function(element) {
            element.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>