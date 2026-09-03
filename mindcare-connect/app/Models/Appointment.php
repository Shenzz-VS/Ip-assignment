<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable =[
        'patient_id',
        'counselor_id',
        'schedule_id',
        'appointment_date',
        'start_time',
        'end_time',
        'appointment_time',
        'status',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'userID');
    }

    public function service()
    {
        return $this->belongsTo(CounselingService::class, 'service_id');
    }

    public function schedule()
    {
        return $this->belongsTo(CounselorSchedule::class, 'schedule_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id','userID');
    }
}
