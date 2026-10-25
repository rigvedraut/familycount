<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFamilyRequest;
use App\Models\FamilyHead;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FamilyController extends Controller
{
    public function index()
    {
        $families = FamilyHead::with(['state', 'city'])
            ->withCount('members')
            ->latest()
            ->paginate(10);

        return view('families.index', compact('families'));
    }

    public function create()
    {
        $states = State::orderBy('name')->get();

        return view('families.create', compact('states'));
    }

    public function store(StoreFamilyRequest $request)
    {
        $data = $request->validated();
        $uploadedFiles = [];

        try {
            DB::transaction(function () use ($request, $data, &$uploadedFiles) {
                $headData = collect($data)->only([
                    'name',
                    'surname',
                    'birthdate',
                    'mobile_no',
                    'address',
                    'state_id',
                    'city_id',
                    'pincode',
                    'marital_status',
                    'wedding_date',
                ])->all();

                if ($request->hasFile('photo')) {
                    $headData['photo'] = $request->file('photo')->store('family-photos', 'public');
                    $uploadedFiles[] = $headData['photo'];
                }

                $head = FamilyHead::create($headData);

                foreach ($data['hobbies'] ?? [] as $hobby) {
                    $head->hobbies()->create(['hobby' => $hobby]);
                }

                foreach ($data['members'] ?? [] as $index => $member) {
                    if ($request->hasFile("members.$index.photo")) {
                        $member['photo'] = $request->file("members.$index.photo")->store('family-photos', 'public');
                        $uploadedFiles[] = $member['photo'];
                    }

                    $head->members()->create([
                        'name' => $member['name'],
                        'birthdate' => $member['birthdate'],
                        'marital_status' => $member['marital_status'],
                        'wedding_date' => $member['wedding_date'] ?? null,
                        'education' => $member['education'] ?? null,
                        'photo' => $member['photo'] ?? null,
                    ]);
                }
            });
        } catch (\Throwable $e) {
            foreach ($uploadedFiles as $path) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            throw $e;
        }

        return redirect('/families')
            ->with('success', 'Family details saved successfully.');
    }

    public function show(FamilyHead $familyHead)
    {
        $familyHead->load(['state', 'city', 'members', 'hobbies']);

        return view('families.show', compact('familyHead'));
    }
}
