<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\CounselingServiceController;
use App\Http\Controllers\CounselorScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientAssessmentController; 
use App\Http\Controllers\WellnessResourceController; 
use App\Http\Controllers\JournalController; 
use App\Http\Controllers\MessageController; 
use App\Http\Controllers\Api\UserApiController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes Group
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Dashboard "Traffic Cop"
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'counselor') {
            return redirect()->route('counselor.dashboard');
        } else {
            return redirect()->route('patient.dashboard');
        }
    })->name('dashboard');

    // ==========================================
    // ADMIN ROUTES
    // ==========================================
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function() {
        
        Route::get('/dashboard', function () {
            $totalUsers = \App\Models\User::count();
            $totalPatients = \App\Models\User::where('role', 'patient')->count();
            $totalCounselors = \App\Models\User::where('role', 'counselor')->count();
            $totalAppointments = \App\Models\Appointment::count();
            $totalResources = \App\Models\WellnessResource::count();

            $patients = \App\Models\User::where('role', 'patient')->get();
            $counselors = \App\Models\User::where('role', 'counselor')->get();

            return view('admin.dashboard', compact('totalUsers', 'totalPatients', 'totalCounselors', 'totalAppointments', 'totalResources', 'patients', 'counselors'));
        })->name('dashboard');

        Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
        Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
        Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

        Route::get('/counselors/{id}/edit', [CounselorController::class, 'edit'])->name('counselors.edit');
        Route::put('/counselors/{id}', [CounselorController::class, 'update'])->name('counselors.update');
        Route::delete('/counselors/{id}', [CounselorController::class, 'destroy'])->name('counselors.destroy');

        Route::get('/audit-logs', function () {
            $logs = \App\Models\AuditLog::with('user')->latest()->get();
            return view('admin.audit_logs', compact('logs'));
        })->name('audit_logs');
    });

    // ==========================================
    // COUNSELOR ROUTES
    // ==========================================
    // Added 'role:counselor' middleware to properly secure these routes
    Route::prefix('counselor')->name('counselor.')->middleware(['role:counselor'])->group(function () {
        
        Route::get('/dashboard', function () {
            return view('counselor.dashboard');
        })->name('dashboard');

        Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
        Route::get('/assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');
        Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');
        Route::get('/assessments/{id}', [AssessmentController::class, 'show'])->name('assessments.show');
        Route::post('/assessments/{id}/questions', [AssessmentController::class, 'storeQuestion'])->name('assessments.questions.store');

        Route::get('/wellness', [WellnessResourceController::class, 'index'])->name('wellness.index');
        Route::get('/wellness/create', [WellnessResourceController::class, 'create'])->name('wellness.create');
        Route::post('/wellness', [WellnessResourceController::class, 'store'])->name('wellness.store');
        Route::delete('/wellness/{id}', [WellnessResourceController::class, 'destroy'])->name(('wellness.destroy'));

        Route::get('/services', [CounselingServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [CounselingServiceController::class, 'store'])->name('services.store');
        Route::delete('/services/{id}', [CounselingServiceController::class, 'destroy'])->name('services.destroy');
        Route::put('/services/{id}', [CounselingServiceController::class, 'update'])->name('services.update');
        
        Route::get('/schedules', [App\Http\Controllers\CounselorScheduleController::class, 'index'])->name('schedules.index');
        Route::post('/schedules', [App\Http\Controllers\CounselorScheduleController::class, 'store'])->name('schedules.store');
        Route::delete('/schedules/{id}', [App\Http\Controllers\CounselorScheduleController::class, 'destroy'])->name('schedules.destroy');
        // Counselor Assessment Feedback Routes
       Route::get('/patient-assessments', [App\Http\Controllers\CounselorAssessmentController::class, 'index'])->name('assessments.results');
    Route::get('/patient-assessments/{id}', [App\Http\Controllers\CounselorAssessmentController::class, 'show'])->name('assessments.show_result');
    Route::post('/patient-assessments/{id}/feedback', [App\Http\Controllers\CounselorAssessmentController::class, 'store'])->name('assessments.store_feedback');
        // Counselor Appointment Management
        Route::get('/appointments', [App\Http\Controllers\CounselorAppointmentController::class, 'index'])->name('appointments.index');
        Route::patch('/appointments/{id}', [App\Http\Controllers\CounselorAppointmentController::class, 'update'])->name('appointments.update');
    });

    // ==========================================
    // PATIENT ROUTES
    // ==========================================
    Route::prefix('patient')->name('patient.')->middleware(['role:patient'])->group(function () {
        
       Route::get('/dashboard', function () {
            $patientId = auth()->user()->userID;
             
             $latestJournal = \App\Models\Journal::where('patient_id', $patientId)->latest()->first();
             $currentMood = $latestJournal ? $latestJournal->mood : null;

             if ($currentMood) {
                 $recommendedResources = \App\Models\WellnessResource::where('tags', $currentMood)->latest()->get();
                 $generalResources = \App\Models\WellnessResource::where('tags', null)->orWhere('tags', '!=', $currentMood)->latest()->get();
             } else {
                 $recommendedResources = collect();
                 $generalResources = \App\Models\WellnessResource::latest()->get();
             } 
             
             $completedAssessmentIds = \DB::table('assessment_results')
                                         ->where('user_id', $patientId)
                                         ->pluck('assessment_id');
             
             $availableAssessments = \App\Models\Assessment::whereNotIn('id', $completedAssessmentIds)->count();
             
             // NEW: Fetch the patient's custom requested appointments
             $myAppointments = \App\Models\Appointment::join('users', 'appointments.counselor_id', '=', 'users.userID')
                 ->select('appointments.*', 'users.name as counselor_name')
                 ->where('appointments.patient_id', $patientId)
                 ->orderBy('appointments.appointment_date', 'asc')
                 ->orderBy('appointments.start_time', 'asc')
                 ->get();
             
             // Make sure to add 'myAppointments' to this list!
             return view('patient.dashboard', compact('recommendedResources', 'generalResources', 'currentMood', 'availableAssessments', 'myAppointments'));
        })->name('dashboard');

        Route::get('/assessments', [PatientAssessmentController::class, 'index'])->name('assessments.index');
        Route::get('/assessments/{id}', [PatientAssessmentController::class, 'show'])->name('assessments.show');
        Route::get('/assessment-results/{id}', [PatientAssessmentController::class, 'result'])->name('assessments.result');
        Route::post('/assessments/{id}/submit', [PatientAssessmentController::class, 'store'])->name('assessments.store');
        
        // Progress Route
        Route::get('/my-progress', [\App\Http\Controllers\PatientAssessmentController::class, 'history'])->name('progress');

        // Patient Appointment Booking (Old duplicates removed!)
        Route::get('/book-appointment', [App\Http\Controllers\PatientAppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/book-appointment', [App\Http\Controllers\PatientAppointmentController::class, 'store'])->name('appointments.store');
    });
    // ==========================================
    // SHARED & UNPREFIXED ROUTES
    // ==========================================
    // Extracted from prefixes so they maintain their exact names (e.g. 'journals.index')
    
    Route::middleware(['role:patient'])->group(function () {
        Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
        Route::post('/journals', [JournalController::class, 'store'])->name('journals.store');
    });

    // Both Counselors and Patients can access messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    // ==========================================
    // PROFILE ROUTES
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';