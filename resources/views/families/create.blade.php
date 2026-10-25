<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eef6ff 0%, #f8fbff 45%, #eef3ff 100%);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        .card {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 18px 45px rgba(15, 76, 129, 0.12);
        }

        .card-header {
            background: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 1.1rem 1.5rem;
        }

        .card-header h4 {
            color: #0f172a;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .ghost-link {
            background: transparent;
            color: #475569;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 0.5rem 0.8rem;
            font-weight: 500;
            text-decoration: none;
        }

        .ghost-link:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .card-body {
            padding: 1.8rem;
            background: rgba(255, 255, 255, 0.72);
        }

        .form-label {
            font-weight: 600;
            color: #1f2a37;
            margin-bottom: 0.6rem;
        }

        .form-control,
        .form-select {
            border: 1.5px solid #CBD5E1;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            color: #1f2a37;
            min-height: 52px;
            padding: 0.8rem 0.95rem;
            box-shadow: inset 0 1px 2px rgba(15, 76, 129, 0.04);
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #71b7ff;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.12);
            background: #fff;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%233b4d68' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M2 5l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 12px;
            padding-right: 2.8rem;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 1.2rem;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            box-shadow: 0 10px 22px rgba(13, 110, 253, 0.22);
        }

        .btn-secondary,
        .btn-outline-secondary,
        .btn-outline-danger {
            box-shadow: none;
        }

        .btn-secondary {
            background: #fff;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .remove-link {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
            padding: 0;
            border: none;
            background: transparent;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .remove-link:hover {
            color: #991b1b;
            text-decoration: none;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            margin-top: 0.45rem;
        }

        hr {
            border-color: rgba(148, 163, 184, 0.28);
            opacity: 1;
        }

        .section-header {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.65rem;
            margin-bottom: 1rem;
        }

        h5 {
            color: #0f172a;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .border.rounded {
            border-color: rgba(13, 110, 253, 0.12) !important;
        }
    </style>
</head>
<body class="bg-body-tertiary">
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Family Registration</h4>
            <a href="{{ route('families.index') }}" class="btn btn-sm ghost-link"><span aria-hidden="true">←</span> Back to Dashboard</a>
        </div>

        <div class="card-body">
            <form action="{{ route('families.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="section-header">
                    <h5 class="mb-0">Family Head Details</h5>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Name *</label>
                        <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Surname *</label>
                        <input name="surname" class="form-control @error('surname') is-invalid @enderror" value="{{ old('surname') }}" required>
                        @error('surname')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Birthdate *</label>
                        <input type="date" name="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate') }}" max="{{ now()->toDateString() }}" required>
                        @error('birthdate')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mobile No *</label>
                        <input name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" value="{{ old('mobile_no') }}" maxlength="10" pattern="[6-9][0-9]{9}" required>
                        @error('mobile_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address *</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address') }}</textarea>
                        @error('address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">State *</label>
                        <select name="state_id" id="state_id" class="form-select @error('state_id') is-invalid @enderror" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" @selected(old('state_id') == $state->id)>{{ $state->name }}</option>
                            @endforeach
                        </select>
                        @error('state_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City *</label>
                        <select name="city_id" id="city_id" class="form-select @error('city_id') is-invalid @enderror" required>
                            <option value="">Select City</option>
                        </select>
                        @error('city_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pincode *</label>
                        <input name="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode') }}" maxlength="6" pattern="[0-9]{6}" required>
                        @error('pincode')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Marital Status *</label>
                        <select name="marital_status" id="marital_status" class="form-select @error('marital_status') is-invalid @enderror" required>
                            <option value="">Select status</option>
                            <option value="unmarried" @selected(old('marital_status') === 'unmarried')>Unmarried</option>
                            <option value="married" @selected(old('marital_status') === 'married')>Married</option>
                        </select>
                        @error('marital_status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6" id="wedding_box" hidden>
                        <label class="form-label">Wedding Date *</label>
                        <input type="date" name="wedding_date" id="wedding_date" class="form-control @error('wedding_date') is-invalid @enderror" value="{{ old('wedding_date') }}">
                        @error('wedding_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/jpeg,image/png" data-preview-target="#head-photo-preview">
                        @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <img id="head-photo-preview" class="img-thumbnail mt-2 d-none" style="max-width:120px;max-height:120px;" alt="Head preview">
                    </div>
                </div>

                <hr>
                <div class="section-header">
                    <h5 class="mb-0">Hobbies</h5>
                </div>
                <div id="hobbies">
                    <div class="hobby-row d-flex gap-2 mb-2">
                        <input type="text" name="hobbies[]" class="form-control @error('hobbies.*') is-invalid @enderror" placeholder="Enter a hobby" value="{{ old('hobbies.0') }}">
                        <button type="button" class="btn btn-link remove-link remove-hobby"><span aria-hidden="true">×</span> Remove</button>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="add_hobby">+ Add Hobby</button>
                @error('hobbies')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                @error('hobbies.*')<div class="text-danger small mt-2">{{ $message }}</div>@enderror

                <hr>
                <div class="section-header">
                    <h5 class="mb-0">Family Members</h5>
                </div>
                <div id="members"></div>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="add_member">+ Add Family Member</button>

                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Save Family</button>
                    <a href="{{ route('families.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const stateSelect = document.getElementById('state_id');
const citySelect = document.getElementById('city_id');
const oldCity = @json(old('city_id'));

async function loadCities(stateId, selectedCity = '') {
    citySelect.innerHTML = '<option value="">Select City</option>';
    if (!stateId) return;

    try {
        const response = await fetch(`{{ route('locations.cities') }}?state_id=${encodeURIComponent(stateId)}`);
        if (!response.ok) throw new Error('City load failed');
        const cities = await response.json();
        citySelect.innerHTML = '<option value="">Select City</option>';

        cities.forEach(city => {
            const option = new Option(city.name, city.id);
            if (String(city.id) === String(selectedCity)) option.selected = true;
            citySelect.add(option);
        });
    } catch (error) {
        citySelect.innerHTML = '<option value="">Unable to load cities</option>';
    }
}

stateSelect.addEventListener('change', function () {
    loadCities(this.value, '');
});

if (stateSelect.value) {
    loadCities(stateSelect.value, oldCity);
}

const statusSelect = document.getElementById('marital_status');
const weddingBox = document.getElementById('wedding_box');
const weddingDate = document.getElementById('wedding_date');

function toggleWeddingDate() {
    const married = statusSelect.value === 'married';
    weddingBox.hidden = !married;
    weddingDate.required = married;
    weddingDate.disabled = !married;
    if (!married) weddingDate.value = '';
}

statusSelect.addEventListener('change', toggleWeddingDate);
toggleWeddingDate();

function addHobbyRow(value = '') {
    const row = document.createElement('div');
    row.className = 'hobby-row d-flex gap-2 mb-2';
    row.innerHTML = `
        <input type="text" name="hobbies[]" class="form-control" placeholder="Enter a hobby" value="${value}">
        <button type="button" class="btn btn-link remove-link remove-hobby"><span aria-hidden="true">×</span> Remove</button>
    `;
    row.querySelector('.remove-hobby').addEventListener('click', () => row.remove());
    document.getElementById('hobbies').appendChild(row);
}

document.getElementById('add_hobby').addEventListener('click', () => addHobbyRow(''));
document.querySelectorAll('.remove-hobby').forEach(button => {
    button.addEventListener('click', () => button.closest('.hobby-row').remove());
});

function addMemberRow() {
    const index = document.querySelectorAll('.member-row').length;
    const row = document.createElement('div');
    row.className = 'member-row border rounded p-3 mb-3';
    row.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Family Member ${index + 1}</h6>
            <button type="button" class="btn btn-link remove-link remove-member"><span aria-hidden="true">×</span> Remove</button>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name *</label>
                <input type="text" name="members[${index}][name]" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Birthdate *</label>
                <input type="date" name="members[${index}][birthdate]" class="form-control" max="{{ now()->toDateString() }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Marital Status *</label>
                <select name="members[${index}][marital_status]" class="form-select member-status" required>
                    <option value="unmarried">Unmarried</option>
                    <option value="married">Married</option>
                </select>
            </div>
            <div class="col-md-6 member-wedding-box" hidden>
                <label class="form-label">Wedding Date *</label>
                <input type="date" name="members[${index}][wedding_date]" class="form-control member-wedding">
            </div>
            <div class="col-md-6">
                <label class="form-label">Education</label>
                <input type="text" name="members[${index}][education]" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Photo</label>
                <input type="file" name="members[${index}][photo]" class="form-control" accept="image/jpeg,image/png" data-preview-target="#member-photo-${index}">
                <img id="member-photo-${index}" class="img-thumbnail mt-2 d-none" style="max-width:120px;max-height:120px;" alt="Member preview">
            </div>
        </div>
    `;

    const status = row.querySelector('.member-status');
    const weddingBox = row.querySelector('.member-wedding-box');
    const weddingInput = row.querySelector('.member-wedding');

    function toggleMemberWedding() {
        const married = status.value === 'married';
        weddingBox.hidden = !married;
        weddingInput.required = married;
        weddingInput.disabled = !married;
        if (!married) weddingInput.value = '';
    }

    status.addEventListener('change', toggleMemberWedding);
    toggleMemberWedding();
    row.querySelector('.remove-member').addEventListener('click', () => row.remove());
    document.getElementById('members').appendChild(row);
}

document.getElementById('add_member').addEventListener('click', addMemberRow);

function attachSingleImagePreview(input) {
    if (!input || !input.dataset.previewTarget) return;
    const previewTarget = document.querySelector(input.dataset.previewTarget);
    if (!previewTarget) return;

    input.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) {
            previewTarget.classList.add('d-none');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            previewTarget.src = event.target.result;
            previewTarget.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
}

attachSingleImagePreview(document.getElementById('photo'));
document.addEventListener('change', function (event) {
    if (event.target.matches('[data-preview-target]')) {
        attachSingleImagePreview(event.target);
    }
});
</script>
</body>
</html>
