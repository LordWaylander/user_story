<?php

namespace App\Extensions\Mail;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;

class linkQuestionnaire extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $questionnaire;

    public function __construct($user, $questionnaire)
    {
        // The $notifiable is already a User instance so not really necessary to pass it here
        $this->user = $user;
        $this->questionnaire = $questionnaire;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/questionnaire/show/'.$this->questionnaire->id_questionnaire);
        $mail = (new MailMessage)
            ->subject('Réponse au questionnaire')
            ->from('xxxx', 'xxxx') // A MODIFER
            ->greeting('Bonjour '.$this->user->name)
            ->line('Nous avons remarqué que vous n\'aviez pas encore répondu à certains questionnaires.')
            ->line('Vous pouvez y répondre depuis votre espace client.')
            ->line('Pour rappel voici vos informations de connection :')
            ->line('Mail: '.$this->user->email)
            ->line('Pour accéder à votre espace client :')
            ->action('espace client', $url);

            return $mail;
    }

}
