<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssessmentResult; 

class WellnessApiController extends Controller
{
    public function getPatientWellnessSummary(Request $request)
    {
        // 1. Validate mandatory parameters based on the IFA
        $request->validate([
            'patientId' => 'required|integer',
            'timeStamp' => 'required|date_format:Y-m-d H:i:s'
        ]);

        try {
            // 2. Fetch the latest assessment record for the patient
            $latestAssessment = AssessmentResult::where('user_id', $request->patientId)
                                                ->latest()
                                                ->first();

            // 3. Return the exact JSON structure requested
            return response()->json([
                'status' => 'S',
                'assessmentDetails' => $latestAssessment ? [
                    'id' => $latestAssessment->id,
                    'user_id' => $latestAssessment->user_id,
                    'assessment_id' => $latestAssessment->assessment_id,
                    'score' => $latestAssessment->score,
                    'answers' => is_string($latestAssessment->answers) ? json_decode($latestAssessment->answers, true) : $latestAssessment->answers,
                    'severityLevel' => $latestAssessment->severity_level ?? $latestAssessment->severityLevel ?? 'High',
                    'counselor_feedback' => $latestAssessment->counselor_feedback,
                    'created_at' => $latestAssessment->created_at,
                    'updated_at' => $latestAssessment->updated_at,
                ] : null,
                'timeStamp' => now()->format('Y-m-d H:i:s')
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'E', 
                'timeStamp' => now()->format('Y-m-d H:i:s')
            ], 500);
        }
    }
}