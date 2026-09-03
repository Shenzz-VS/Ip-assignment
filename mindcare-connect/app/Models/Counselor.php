<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'specialty',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'userID');
    }
}
