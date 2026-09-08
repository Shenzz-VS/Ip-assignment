<?php
namespace App\Factories;

use App\Models\User;
use App\Models\Patient;
use App\Models\Counselor;
use App\Models\Administrator;
use InvalidArgumentException;

class UserProfileFactory{

    public static function createProfile(User $user, string $role, array $extraAttributes=[])
    {
        return match ($role){
            'patient'=> Patient::create([
                'user_id' => $user->getKey(),
                'moodLevel' => $extraAttributes['moodLevel'] ?? 'Not Specified',
            ]),

            'counselor' => Counselor::create([
                'user_id' => $user->getKey(),
                'specialty' => $extraAttributes['specialty'] ?? 'General',
            ]),

            'admin' => Administrator::create([
                'user_id'=> $user->getKey(),
                'accessLvl'=> $extraAttributes['accessLvl'] ?? 'Standard admin',
            ]),

            default => throw new InvalidArgumentException("Invalid user role: {$role}")
        };
    } 
}