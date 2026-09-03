<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = ['title', 'description'];

    public function questions(){
        return $this->hasMany(AssessmentQuestion::class);
    }

    public function results()
    {
        return $this->hasMany(AssessmentResult::class);
    }
}
