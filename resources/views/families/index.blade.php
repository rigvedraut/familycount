
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Information System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eef5ff 0%, #f7f9ff 45%, #eef3ff 100%);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        .page-header {
            border-radius: 20px;
            background: rgba(255,255,255,0.7);
            padding: 1.25rem 1.5rem;
            box-shadow: 0 14px 32px rgba(13, 110, 253, 0.08);
            backdrop-filter: blur(8px);
        }

        .btn-primary {
            border-radius: 12px;
            padding: 0.8rem 1.2rem;
            font-weight: 600;
            box-shadow: 0 12px 24px rgba(13, 110, 253, 0.22);
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f7faff 100%);
            border: 1px solid rgba(13,110,253,0.08);
            border-radius: 18px;
            box-shadow: 0 12px 28px rgba(15,76,129,0.08);
        }

        .stat-card .card-body {
            padding: 1.2rem 1.2rem 1rem;
        }

        .stat-card p {
            margin-bottom: 0.35rem;
            font-size: 0.8rem;
            letter-spacing: 0.03em;
        }

        .stat-card h4 {
            font-weight: 700;
            color: #0f172a;
        }

        .table-card {
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow: 0 18px 34px rgba(15,76,129,0.08);
        }

        .table thead th {
            background: #f8fafc;
            color: #475569;
            border: none;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 700;
            padding: 0.9rem 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            background: rgba(255,255,255,0.9);
            color: #334155;
            font-weight: 500;
        }

        .table tbody tr:hover td {
            background: rgba(234, 244, 255, 0.8);
        }

        .family-name {
            font-weight: 600;
            color: #0f172a;
        }

        .badge {
            border-radius: 999px;
            padding: 0.5rem 0.8rem;
            font-weight: 600;
        }

        .btn-outline-primary {
            border-radius: 10px;
            font-weight: 600;
        }

        .pagination .page-link {
            border-radius: 10px;
            margin: 0 0.2rem;
        }
    </style>
</head>
<body class="bg-body-tertiary">
<div class="container py-4">
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <p class="text-primary fw-semibold mb-1">Dashboard</p>
            <h3 class="mb-0">Family Information System</h3>
        </div>
        <a href="{{ route('families.create') }}" class="btn btn-primary btn-lg shadow-sm">
            + Add Family
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card card border-0 h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Total Families</p>
                    <h4 class="mb-0">{{ $families->total() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card card border-0 h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Current Page</p>
                    <h4 class="mb-0">{{ $families->currentPage() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card card border-0 h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Records</p>
                    <h4 class="mb-0">{{ $families->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Family Head</th>
                        <th>Mobile</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Members</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($families as $family)
                        <tr>
                            <td>{{ $families->firstItem() + $loop->index }}</td>
                            <td class="family-name">{{ $family->name }} {{ $family->surname }}</td>
                            <td>{{ $family->mobile_no }}</td>
                            <td>{{ $family->state->name ?? '-' }}</td>
                            <td>{{ $family->city->name ?? '-' }}</td>
                            <td>
                                <span class="badge text-bg-light border">{{ $family->members_count }} members</span>
                            </td>
                            <td>
                                <a href="{{ route('families.show', $family) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                No family records found. Click "Add Family" to begin.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $families->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
