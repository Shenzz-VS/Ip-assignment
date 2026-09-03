<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    protected $fillable = ['assessment_id', 'question_text', 'question_type'];

    public function assessment(){
        return $this->belongsTo(Assessment::class);
    }
}
