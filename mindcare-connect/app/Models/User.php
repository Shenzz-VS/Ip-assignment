<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'userID';

     protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
    ];

    public function patient(){
        return $this->hasOne(Patient::class, 'user_id');
    }

    public function counselor()
    {
        return $this->hasOne(Counselor::class, 'user_id');
    }
    
    public function appointmentsAsPatient(){
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function appointmentsAsCounselor()
    {
        return $this->hasMany(Appointment::class, 'counselor_id');
    }

    public function assessmentResults(){
        return $this->hasMany(AssessmentResult::class. 'patient_id', 'userID');
    }
    
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
