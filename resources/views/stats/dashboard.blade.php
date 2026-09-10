<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
        }
        .header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.3);
        }
        .header h1 { font-size: 28px; font-weight: 700; }
        .header h1 span { color: #f5c842; }
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
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
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
            margin-top: 30px;
        }
        .table-card h4 {
            font-weight: 700;
            color: #1a1a2e;
            border-bottom: 3px solid #f5c842;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
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
        .badge-custom {
            background: #1a1a2e;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
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
                    <div>Dashboard Statistics</div>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-chart-bar" style="font-size: 50px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom">

        <!-- Basic Counts -->
        <h3 class="mb-3">Basic Counts</h3>
        <div class="row">
            <div class="col-md-2">
                <div class="stat-card blue">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number">{{ $totalUsers }}</div>
                    <div class="stat-label">Users</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card green">
                    <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="stat-number">{{ $totalStudents }}</div>
                    <div class="stat-label">Students</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card yellow">
                    <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="stat-number">{{ $totalTeachers }}</div>
                    <div class="stat-label">Teachers</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card red">
                    <div class="stat-icon"><i class="fas fa-school"></i></div>
                    <div class="stat-number">{{ $totalClasses }}</div>
                    <div class="stat-label">Classes</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card purple">
                    <div class="stat-icon"><i class="fas fa-book"></i></div>
                    <div class="stat-number">{{ $totalSubjects }}</div>
                    <div class="stat-label">Subjects</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card teal">
                    <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
                    <div class="stat-number">{{ $totalGrades }}</div>
                    <div class="stat-label">Grades</div>
                </div>
            </div>
        </div>

        <!-- Score Aggregates -->
        <h3 class="mb-3 mt-4">Score Aggregates</h3>
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card blue">
                    <div class="stat-number">{{ $totalScore }}</div>
                    <div class="stat-label">Total Score</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card green">
                    <div class="stat-number">{{ number_format($avgScore, 2) }}</div>
                    <div class="stat-label">Average Score</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card yellow">
                    <div class="stat-number">{{ $maxScore }}</div>
                    <div class="stat-label">Max Score</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card red">
                    <div class="stat-number">{{ $minScore }}</div>
                    <div class="stat-label">Min Score</div>
                </div>
            </div>
        </div>

        <!-- Status Counts -->
        <h3 class="mb-3 mt-4">Status Counts</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card green">
                    <div class="stat-number">{{ $activeStudents }}</div>
                    <div class="stat-label">Active Students</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card red">
                    <div class="stat-number">{{ $inactiveStudents }}</div>
                    <div class="stat-label">Inactive Students</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card yellow">
                    <div class="stat-number">{{ $pendingStudents }}</div>
                    <div class="stat-label">Pending Students</div>
                </div>
            </div>
        </div>

        <!-- Teachers with Class Count -->
        <div class="table-card">
            <h4><i class="fas fa-chalkboard-teacher"></i> Teachers with Class Count</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Teacher</th>
                        <th>Total Classes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachersWithClassCount as $teacher)
                        <tr>
                            <td>{{ $teacher->id }}</td>
                            <td>{{ $teacher->name }}</td>
                            <td><span class="badge-custom">{{ $teacher->classes_count }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No data found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Classes with Student Count -->
        <div class="table-card">
            <h4><i class="fas fa-school"></i> Classes with Student Count</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Total Students</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classesWithStudentCount as $class)
                        <tr>
                            <td>{{ $class->id }}</td>
                            <td>{{ $class->name }}</td>
                            <td><span class="badge-custom">{{ $class->students_count }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No data found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Students with Subject Count -->
        <div class="table-card">
            <h4><i class="fas fa-user-graduate"></i> Students with Subject Count</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Total Subjects</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studentsWithSubjectCount as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td><span class="badge-custom">{{ $student->subjects_count }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No data found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Students with Grade Stats -->
        <div class="table-card">
            <h4><i class="fas fa-chart-line"></i> Students with Grade Statistics</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Sum</th>
                        <th>Avg</th>
                        <th>Max</th>
                        <th>Min</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studentsWithGradeStats as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->grades_sum_grade ?? 0 }}</td>
                            <td>{{ number_format($student->grades_avg_grade ?? 0, 2) }}</td>
                            <td>{{ $student->grades_max_grade ?? 0 }}</td>
                            <td>{{ $student->grades_min_grade ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No data found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>