<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLocation;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function updateLocation(Request $request)
    {
        $user = $request->user();
        if (! $user->isTechnician()) {
            return response()->json([
                'message' => "The authenticated user is {$user->role->value}, and {$user->role->value} is not included in the location tracing feature",
            ]);
        }
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);
        UserLocation::create([
            'user_id' => $user->id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return response()->json([
            'message' => 'Location updated successfully.',
        ]);
    }
}
