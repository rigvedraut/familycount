<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function cities(Request $request)
    {
        $request->validate([
            'state_id' => ['required', 'exists:states,id'],
        ]);

        return City::where('state_id', $request->state_id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
