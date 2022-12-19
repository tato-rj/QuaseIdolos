<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\{User, Artist};

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $artists;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->artists = Artist::inRandomOrder()->take(12)->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bem-vindo(a) ao Quase Ídolos 🎉')->markdown('emails.users.welcome');
    }
}
