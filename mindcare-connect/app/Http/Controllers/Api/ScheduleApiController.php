<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleApiController extends Controller
{
    public function getAvailableSchedules(Request $request)
    {
        // Validate the strict IFA tracking requirements
        $request->validate([
            'counselorId' => 'required|integer',
            'requestID' => 'required|string',
            'timeStamp' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Retrieve schedule data via Object-Relational Mapping
        $schedules = Schedule::where('counselor_id', $request->counselorId)
            ->get(['available_date', 'start_window', 'end_window']);

        // Return standardized JSON structure
        return response()->json([
            'status' => 'S',
            'availableSchedules' => $schedules,
            'timeStamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], 200);
    }
}