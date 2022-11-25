<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\SongRequest;

class WinnerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $winner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SongRequest $winner)
    {
        $this->winner = $winner;
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
