<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assessment_id',
        'score',
        'severityLevel', 
        'counselor_feedback',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    // Returning Object Reference to Patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Returning Object Reference to Assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }
}
