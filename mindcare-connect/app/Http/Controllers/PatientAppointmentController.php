<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Appointment;
use Carbon\Carbon;

class PatientAppointmentController extends Controller
{
    public function create()
    {
        // Show all unbooked counselor windows
        $schedules = Schedule::where('is_booked', false)
            ->where('available_date', '>=', date('Y-m-d'))
            ->get()
            ->groupBy('counselor_id');
            
        $counselors = \App\Models\User::whereIn('userID', $schedules->keys())->get()->keyBy('userID');

        return view('patient.appointments.create', compact('schedules', 'counselors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'notes' => 'nullable|string|max:500',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        // 1. Check if slot is already taken
        if ($schedule->is_booked) {
            return back()->withErrors(['error' => 'This window has already been booked.']);
        }

        // 2. Parse times using Carbon for validation
        $windowStart = Carbon::parse($schedule->start_window);
        $windowEnd = Carbon::parse($schedule->end_window);
        
        $patientStart = Carbon::parse($request->start_time);
        $patientEnd = Carbon::parse($request->end_time);

        // 3. Validate: Must fit inside Counselor's window
        if ($patientStart->lt($windowStart) || $patientEnd->gt($windowEnd)) {
            return back()->withErrors(['error' => 'Your chosen time must fall within the counselor\'s available window (' . $windowStart->format('g:i A') . ' - ' . $windowEnd->format('g:i A') . ').']);
        }

        // 4. Validate: Maximum range limit of 2 Hours
        $durationInMinutes = $patientStart->diffInMinutes($patientEnd);
        if ($durationInMinutes > 120) {
            return back()->withErrors(['error' => 'Maximum session range cannot exceed 2 hours (120 minutes).']);
        }

        // Create the Appointment request
        Appointment::create([
            'patient_id' => auth()->user()->userID,
            'counselor_id' => $schedule->counselor_id,
            'schedule_id' => $schedule->id,
            'appointment_date' => $schedule->available_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'Pending',
            'notes' => $request->notes,
        ]);

        // Lock the counselor's schedule window
        $schedule->update(['is_booked' => true]);

        return redirect()->route('patient.dashboard')->with('status', 'Appointment requested successfully! Awaiting approval.');
    }
}