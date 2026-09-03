<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\AppointmentApproved;

class CounselorAppointmentController extends Controller
{
    public function index()
{
    $appointments = Appointment::with('patient', 'schedule')
        ->where('counselor_id', auth()->user()->userID)
        ->get();

    $nextPatientMood = 'Unknown';
    
    if ($appointments->isNotEmpty()) {
        $nextPatientId = $appointments->first()->patient_id;

        $nextPatient = User::find($nextPatientId);
        $nextPatientMood = $nextPatient ? 'Neutral' : 'Mood data unavailable';
    }

    return view('counselor.appointments.index', compact('appointments', 'nextPatientMood'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected'
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $request->status]);

        $schedule = Schedule::find($appointment->schedule_id);

        // Smart Logic: If the counselor rejects the appointment, free up the time slot again!
        if ($request->status === 'Rejected') {
            if ($schedule) {
                $schedule->update(['is_booked' => false]);
            }
        }
        else if ($request->status === 'Approved'){
            $patient = User::find($appointment->patient_id);
            if($patient && $schedule){
                $patient->notify(new AppointmentApproved($appointment, $schedule));
            }
        }

        return back()->with('status', 'Appointment successfully marked as ' . $request->status . '.');
    }
}