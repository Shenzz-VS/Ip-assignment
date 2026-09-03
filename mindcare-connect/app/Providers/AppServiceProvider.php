<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use App\Models\AuditLog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Automatically log every successful login
        Event::listen(function (Login $event) {
            AuditLog::create([
                'user_id' => $event->user->userID, // Uses your custom primary key
                'action'  => 'USER_LOGIN',
                'details' => $event->user->name . ' logged into the system as a ' . $event->user->role . '.',
            ]);
        });
    }
}