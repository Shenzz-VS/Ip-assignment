<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['patient_id', 'mood', 'notes'];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'userID');
    }
}
