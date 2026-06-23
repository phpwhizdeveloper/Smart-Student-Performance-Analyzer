<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Performance Report</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-screen py-5"> 
    <div class="container" style="max-width: 900px;">
        <!-- Header & Profile Summary Card -->
        <div class="card shadow-sm p-4 mb-4 border-0">
            <div class="d-flex flex-column md:flex-row justify-content-between align-items-md-center border-b pb-3 mb-4 flex-md-row">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">{{ $studentReport->name }}</h1>
                    <p class="text-muted mb-0">Student ID Reference: #{{ $studentReport->id }}</p>
                </div>
                <div class="mt-3 mt-md-0 bg-primary-subtle border border-primary-subtitle px-4 py-2 rounded">
                    <span class="text-primary fw-semibold small d-block">Class Rank</span>
                    <span class="h3 fw-black text-primary-emphasis mb-0">#{{ $studentReport->rank }}</span>
                </div>
            </div>

            <!-- Core Performance Metrics Grid -->
            <div class="row g-2 text-center">
              
                <div class="col-12 col-sm-4">
                    <div class="p-3 bg-light rounded border">
                        <span class="small text-muted fw-medium text-uppercase tracking-wider d-block mb-1">Overall Grade</span>
                        <span class="h4 fw-bold d-block mb-0 {{ $studentReport->grade === 'F' ? 'text-danger' : 'text-success' }}">
                            {{ $studentReport->grade }}
                        </span>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="p-3 bg-light rounded border">
                        <span class="small text-muted fw-medium text-uppercase tracking-wider d-block mb-1">Scholarship Status</span>
                        <div class="mt-1">
                            @if($studentReport->scholarship === 'Full Scholarship')
                                <span class="badge bg-success-subtle text-success text-uppercase rounded-pill px-3 py-2 small fw-bold">{{ $studentReport->scholarship }}</span>
                            @elseif($studentReport->scholarship === 'Partial Scholarship')
                                <span class="badge bg-warning-subtle text-warning-emphasis text-uppercase rounded-pill px-3 py-2 small fw-bold">{{ $studentReport->scholarship }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary text-uppercase rounded-pill px-3 py-2 small fw-bold">None</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Narrative Summary Section -->
        <div class="card shadow-sm p-4 mb-4 border-0">
            <h2 class="h5 fw-bold text-dark mb-3">Performance Overview</h2>
            <div class="p-3 bg-body-tertiary border-start border-primary border-4 rounded-end">
                <p class="text-secondary fst-italic mb-0">
                    "{{ $englishSummary }}"
                </p>
            </div>
        </div>

<div class="card shadow-sm p-4 border-0">
    <h2 class="h5 fw-bold text-dark mb-4">Student's Average Marks</h2>
                <div class="text-black rounded-pill px-3 py-2">
                    {{ $studentAverage !== null ? round($studentAverage, 2) : 'N/A' }}
                </div>   
    </div>
</div>



    <!-- Optional Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
