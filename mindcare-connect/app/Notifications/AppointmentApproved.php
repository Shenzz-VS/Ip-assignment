<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AppointmentApproved extends Notification
{
    use Queueable;

    public $appointment;
    public $schedule;

    public function __construct($appointment, $schedule)
    {
        $this->appointment = $appointment;
        $this->schedule = $schedule;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $date = Carbon::parse($this->schedule->available_date)->format('l, F j, Y');
        $time = Carbon::parse($this->schedule->start_time)->format('g:i A');

        return (new MailMessage)
                    ->subject('Confirmed: Your Counseling Session')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('Good news! Your counselor has approved your upcoming appointment.')
                    ->line('**Date:** ' . $date)
                    ->line('**Time:** ' . $time)
                    ->line('Please ensure you log in a few minutes before your session begins.')
                    ->action('View My Dashboard', url('/patient/dashboard'))
                    ->line('Thank you for trusting MindCare Connect with your wellness journey.');
    }
}