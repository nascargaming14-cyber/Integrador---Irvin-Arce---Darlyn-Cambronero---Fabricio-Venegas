<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public function __construct(public string $token)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        $minutes = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        return (new MailMessage)
            ->subject('Restablece tu contraseña — Servigrama')
            ->greeting('¿Olvidaste tu contraseña?')
            ->line('No te preocupes, le pasa a cualquiera. Toca el botón de abajo para crear una nueva contraseña.')
            ->action('Restablecer contraseña', $url)
            ->line("Este enlace expira en {$minutes} minutos.")
            ->line('Si no solicitaste este cambio, puedes ignorar este correo y tu contraseña seguirá igual.')
            ->salutation('Equipo Servigrama');
    }
}
