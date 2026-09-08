<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

class PatientController extends Controller
{
    public function showPatientDashboard()
    {
        // Securely fetch the active patient's ID from the session (Mitigating IDOR)
        $patientId = auth()->id(); 

        // Consume the external Counseling & Appointment Module API
        $response = Http::get('http://127.0.0.1:8000/api/v1/counselor/assigned', [
            'patientId' => $patientId, 
            'timeStamp' => now()->format('Y-m-d H:i:s') 
        ]);

        // Verify the response is successful and the status flag is 'S'
        if ($response->successful() && $response->json('status') === 'S') {
            
            $counselorName = $response->json('counselorName');
            $counselorEmail = $response->json('counselorEmail');
            $counselorDetails = $response->json('counselorDetails'); 

            // Pass the consumed counselor data into your patient dashboard view
            return view('patient.dashboard', compact('counselorName', 'counselorEmail', 'counselorDetails'));
        }
        
        // Fallback if the counseling API fails
        return view('patient.dashboard')->with('error', 'Unable to retrieve assigned counselor details.');
    }   }