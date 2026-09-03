<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $primaryKey = 'adminID';

    protected $fillable = [
        'user_id',
        'accessLvl',    
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'userID');
    }
}
