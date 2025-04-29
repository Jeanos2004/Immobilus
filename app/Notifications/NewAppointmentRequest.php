<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class NewAppointmentRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     * 
     * @param App\Models\Appointment $appointment Le nouveau rendez-vous demandé
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $property = $this->appointment->property;
        $user = $this->appointment->user;
        $dateFormatted = Carbon::parse($this->appointment->appointment_date)->format('d/m/Y à H:i');
        
        return (new MailMessage)
            ->subject("Nouvelle demande de rendez-vous - Immobilus")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Vous avez reçu une nouvelle demande de rendez-vous pour la propriété <strong>{$property->property_name}</strong>.")
            ->line("Détails du rendez-vous :")
            ->line("Client : <strong>{$user->name}</strong>")
            ->line("Email du client : <strong>{$user->email}</strong>")
            ->line("Date demandée : <strong>{$dateFormatted}</strong>")
            ->line("Adresse de la propriété : <strong>{$property->property_address}</strong>")
            ->line("Message du client : <strong>{$this->appointment->message}</strong>")
            ->action('Gérer mes rendez-vous', url('/agent/appointments'))
            ->line('Veuillez confirmer ou annuler ce rendez-vous dès que possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $property = $this->appointment->property;
        $user = $this->appointment->user;
        
        return [
            'appointment_id' => $this->appointment->id,
            'property_id' => $property->id,
            'property_name' => $property->property_name,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'appointment_date' => $this->appointment->appointment_date,
            'message' => "Nouvelle demande de rendez-vous de {$user->name} pour la propriété {$property->property_name}."
        ];
    }
}
