<?php

namespace App\Extensions\Mail;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
class createMdpClient extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($user, $token)
    {
        // The $notifiable is already a User instance so not really necessary to pass it here
        $this->user = $user;
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];

    }

    public function toMail($notifiable)
    {
        $urlPwd = url('/create-password/'.$this->token.'?email='.$this->user->email);
        $url = url('/login');
        $mail = (new MailMessage)
            ->subject('Création de votre espace client')
            ->from('xxxx', 'xxxx') // A MODIFER
            ->greeting('Bonjour,')
            ->line('Nous avons mis en place une plateforme digitale dédiée afin de mieux vous accompagner pour la mise en conformité RGPD.')
            ->line('Voici vos informations personnelles pour accéder à votre compte : ')
            ->line('URL : '.$url)
            ->line('Login: '.$this->user->email)
            ->line('Vous pouvez créer un mot de passe en cliquant ici :')
            ->action('Création de votre mot de passe', $urlPwd);

            return $mail;
    }

}
