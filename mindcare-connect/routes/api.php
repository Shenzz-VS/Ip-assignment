<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ScheduleApiController;
use App\Http\Controllers\Api\WellnessApiController;

// 1. EXACT ROUTE FIRST (This will now trigger correctly!)
Route::get('/v1/users/profile', [UserApiController::class, 'getUserProfile']);
Route::get('/v1/schedules/available', [ScheduleApiController::class, 'getAvailableSchedules']);
Route::get('/v1/wellness/summary', [WellnessApiController::class, 'getPatientWellnessSummary']);
// 2. WILDCARD ROUTE SECOND (Catches everything else, like /v1/users/patient)
Route::get('/v1/users/{role}', function ($role) {
    $users = User::where('role', strtolower($role))
                 ->orWhere('role', ucfirst($role))
                 ->get();

    return response()->json([
        'status' => 'success',
        'data'   => $users,
    ], 200);
});