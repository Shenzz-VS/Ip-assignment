<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Carbon\Carbon;

class CounselorScheduleController extends Controller
{
    public function index()
    {
        // Get all schedules for this specific counselor, ordered by date and time
        $schedules = Schedule::where('counselor_id', auth()->user()->userID)
            ->orderBy('available_date', 'asc')
            ->orderBy('start_window', 'asc')
            ->get();

        return view('counselor.schedules.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'available_date' => 'required|date|after_or_equal:today',
            'start_window' => 'required',
            'end_window' => 'required|after:start_window', // Prevents impossible time blocks!
        ]);

        \App\Models\Schedule::create([
            'counselor_id' => auth()->user()->userID,
            'available_date' => $request->available_date,
            'start_window' => $request->start_window,
            'end_window' => $request->end_window,
            'is_booked' => false,
        ]);

        return back()->with('status', 'Time slot successfully added to your schedule.');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        
        // Security check: Only delete if it hasn't been booked by a patient yet!
        if (!$schedule->is_booked) {
            $schedule->delete();
            return back()->with('status', 'Time slot removed.');
        }

        return back()->withErrors(['error' => 'Cannot delete a slot that a patient has already booked.']);
    }
}