<?php

namespace Modulos\Usuarios\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UsuarioRegistradoNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private object $usuario;
    /**
     * Create a new notification instance.
     */
    public function __construct(object $usuario)
    {
        $this->usuario = $usuario;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Alta de usuario en el Sistema ' . config('app.name'))
            ->markdown('emails.usuario-registrado', [
                'nombre' => $this->usuario->nombre,
                'email' => $this->usuario->email,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [

        ];
    }
}
