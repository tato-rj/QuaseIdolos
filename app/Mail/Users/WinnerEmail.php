<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\{Rating, User};
use Illuminate\Support\Collection;

class WinnerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $winner, $ranking, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $ranking, User $user = null)
    {
        $this->ranking = $ranking;
        $this->winner = $ranking->ratings->first()->songRequest;
        $this->user = $user ?? $this->winner->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Parabéns 🏆')->markdown('emails.users.winner');
    }
}
