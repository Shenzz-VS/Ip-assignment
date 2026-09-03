<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserApiController extends Controller
{
    public function getUserProfile(Request $request)
    {
        // Require the mandatory IFA tracking fields
        $request->validate([
            'userId' => 'required|integer',
            'requestID' => 'required|string',
            'timeStamp' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $user = User::find($request->userId);

        if (!$user) {
            return response()->json([
                'status' => 'E',
                'message' => 'User profile not found in system.',
                'timeStamp' => Carbon::now()->format('Y-m-d H:i:s')
            ], 404);
        }

        // Build the obvious nested 'userDetails' object
        $userDetails = [
            'role' => $user->role,
            'avatarUrl' => $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null,
            'accountCreated' => $user->created_at->format('Y-m-d'),
        ];

        // Dynamically append clinical data based on the user's role
        if ($user->role === 'patient') {
            $userDetails['moodLevel'] = 'Neutral';
        } elseif ($user->role === 'counselor') {
            $userDetails['specialty'] = 'Mental Health Counseling';
        }

        // Return the highly detailed JSON response matching the IFA
        return response()->json([
            'status' => 'S',
            'userName' => $user->name,
            'userEmail' => $user->email,
            'userDetails' => $userDetails,
            'timeStamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], 200);
    }
}

