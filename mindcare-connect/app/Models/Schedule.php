<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'counselor_id',
        'available_date',
        'start_window',
        'end_window',
        'is_booked'
    ];
}
