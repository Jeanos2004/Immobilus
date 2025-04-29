<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AppointmentStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;
    protected $oldStatus;

    /**
     * Create a new notification instance.
     * 
     * @param App\Models\Appointment $appointment Le rendez-vous dont le statut a changé
     * @param string $oldStatus L'ancien statut du rendez-vous
     */
    public function __construct(Appointment $appointment, $oldStatus = null)
    {
        $this->appointment = $appointment;
        $this->oldStatus = $oldStatus;
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
        $statusFrench = $this->getStatusInFrench($this->appointment->status);
        $dateFormatted = Carbon::parse($this->appointment->appointment_date)->format('d/m/Y à H:i');
        
        $mailMessage = (new MailMessage)
            ->subject("Mise à jour de votre rendez-vous - Immobilus")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Le statut de votre rendez-vous pour la propriété <strong>{$property->property_name}</strong> a été mis à jour.");
            
        if ($this->oldStatus) {
            $oldStatusFrench = $this->getStatusInFrench($this->oldStatus);
            $mailMessage->line("Statut précédent : <strong>{$oldStatusFrench}</strong>");
        }
        
        $mailMessage->line("Nouveau statut : <strong>{$statusFrench}</strong>")
            ->line("Date du rendez-vous : <strong>{$dateFormatted}</strong>")
            ->line("Adresse : <strong>{$property->property_address}</strong>");
            
        // Ajouter des instructions spécifiques en fonction du statut
        if ($this->appointment->status == 'confirmed') {
            $mailMessage->line("Votre rendez-vous a été confirmé. Veuillez vous présenter à l'adresse indiquée à l'heure prévue.")
                ->line("En cas d'empêchment, merci de nous prévenir au plus tôt.");
        } elseif ($this->appointment->status == 'cancelled') {
            $mailMessage->line("Votre rendez-vous a été annulé. Vous pouvez reprendre contact avec l'agent pour planifier une nouvelle visite si vous le souhaitez.");
        } elseif ($this->appointment->status == 'completed') {
            $mailMessage->line("Votre rendez-vous a été marqué comme terminé. Nous espérons que la visite s'est bien déroulée.")
                ->line("N'hésitez pas à contacter l'agent pour toute question supplémentaire.");
        }
        
        return $mailMessage
            ->action('Voir mes rendez-vous', url('/user/appointments'))
            ->line('Merci d\'utiliser Immobilus pour vos recherches immobilières !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $property = $this->appointment->property;
        $statusFrench = $this->getStatusInFrench($this->appointment->status);
        
        return [
            'appointment_id' => $this->appointment->id,
            'property_id' => $property->id,
            'property_name' => $property->property_name,
            'status' => $this->appointment->status,
            'status_french' => $statusFrench,
            'appointment_date' => $this->appointment->appointment_date,
            'message' => "Le statut de votre rendez-vous pour la propriété {$property->property_name} a été mis à jour en '{$statusFrench}'."
        ];
    }
    
    /**
     * Convertit le statut en anglais en français
     * 
     * @param string $status Le statut en anglais
     * @return string Le statut en français
     */
    protected function getStatusInFrench($status)
    {
        switch ($status) {
            case 'pending':
                return 'En attente';
            case 'confirmed':
                return 'Confirmé';
            case 'cancelled':
                return 'Annulé';
            case 'completed':
                return 'Terminé';
            default:
                return $status;
        }
    }
}
