
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #edf5ff 0%, #f8fbff 50%, #eef4ff 100%);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        .profile-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 16px 36px rgba(15,76,129,0.08);
        }

        .profile-card .card-header,
        .sub-card .card-header {
            background: #f8fafc;
            color: #334155;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
        }

        .profile-card .card-body {
            background: rgba(255,255,255,0.9);
            padding: 1.5rem;
        }

        .detail-wrapper {
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        .detail-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.2rem 2rem;
            align-items: start;
        }

        .detail-item,
        .single-row {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            min-height: 60px;
            font-size: 1.05rem;
            color: #1f2937;
            padding: 0.2rem 0;
        }

        .detail-item strong,
        .single-row strong {
            color: #475569;
            font-weight: 600;
            font-size: 0.92rem;
            letter-spacing: 0.02em;
            margin-bottom: 0.35rem;
        }

        .detail-item span,
        .single-row span {
            font-size: 1.08rem;
            color: #0f172a;
            line-height: 1.5;
        }

        .photo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.55rem;
            border-radius: 16px;
            background: #f8fbff;
            border: 1px solid rgba(13,110,253,0.09);
            margin-top: 0.2rem;
        }

        .back-btn {
            border: 1px solid rgba(148, 163, 184, 0.8);
            color: #334155;
            background: #fff;
            border-radius: 10px;
            padding: 0.65rem 1rem;
        }

        .back-btn:hover {
            background: #f8fafc;
            border-color: rgba(100, 116, 139, 0.9);
        }

        .hobby-badge {
            background: #e2e8f0;
            color: #334155;
            border: 1px solid #cbd5e1;
            border-radius: 999px;
            padding: 0.5rem 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        @media (max-width: 991px) {
            .detail-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .detail-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="bg-body-tertiary">
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-primary fw-semibold mb-1">Family Profile</p>
            <h3 class="mb-0">Family Details</h3>
        </div>
        <a href="{{ route('families.index') }}" class="btn back-btn">
            <span aria-hidden="true">←</span> Back to List
        </a>
    </div>

    <div class="profile-card card border-0 shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Family Head Information</h5>
        </div>
        <div class="card-body">
            <div class="detail-wrapper">
                <div class="detail-row">
                    <div class="detail-item"><strong>Name:</strong> <span>{{ $familyHead->name }} {{ $familyHead->surname }}</span></div>
                    <div class="detail-item"><strong>Date of Birth:</strong> <span>{{ \Illuminate\Support\Facades\Date::parse($familyHead->birthdate)->format('d-m-Y') }}</span></div>
                    <div class="detail-item"><strong>Mobile:</strong> <span>{{ $familyHead->mobile_no }}</span></div>
                    <div class="detail-item"><strong>Address:</strong> <span>{{ $familyHead->address }}</span></div>
                    <div class="detail-item"><strong>State:</strong> <span>{{ $familyHead->state->name ?? '-' }}</span></div>
                    <div class="detail-item"><strong>City:</strong> <span>{{ $familyHead->city->name ?? '-' }}</span></div>
                    <div class="detail-item"><strong>Pincode:</strong> <span>{{ $familyHead->pincode }}</span></div>
                    <div class="detail-item"><strong>Marital Status:</strong> <span>{{ ucfirst($familyHead->marital_status) }}</span></div>
                </div>

                @if($familyHead->wedding_date)
                    <div class="single-row mt-3">
                        <strong>Wedding Date:</strong>
                        <span>{{ $familyHead->wedding_date }}</span>
                    </div>
                @endif

                @if($familyHead->photo)
                    <div class="single-row mt-3">
                        <strong>Photo:</strong>
                        <span class="photo-box">
                            <img src="{{ asset('storage/' . $familyHead->photo) }}" alt="Family Head" class="rounded border shadow-sm" style="width:120px;height:120px;object-fit:cover">
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="sub-card card border-0 shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Hobbies</h5>
        </div>
        <div class="card-body">
            @forelse($familyHead->hobbies as $hobby)
                <span class="hobby-badge me-2 mb-2 d-inline-block">
                    {{ ucfirst($hobby->hobby) }}
                </span>
            @empty
                <p class="text-muted mb-0">No hobbies added.</p>
            @endforelse
        </div>
    </div>

    <div class="sub-card card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                Family Members ({{ $familyHead->members->count() }})
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Marital Status</th>
                        <th>Wedding Date</th>
                        <th>Education</th>
                        <th>Photo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($familyHead->members as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->birthdate }}</td>
                            <td>{{ ucfirst($member->marital_status) }}</td>
                            <td>{{ $member->wedding_date ?? '-' }}</td>
                            <td>{{ $member->education ?? '-' }}</td>
                            <td>
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}"
                                         alt="Member photo"
                                         style="width:60px;height:60px;object-fit:cover"
                                         class="rounded border shadow-sm">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No family members added.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>
