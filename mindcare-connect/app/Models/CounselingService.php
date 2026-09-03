<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingService extends Model
{

    protected $fillable = [
      'counselor_id',
      'name',
      'description',
      'duration_minutes', 
      'price',
    ];
}
