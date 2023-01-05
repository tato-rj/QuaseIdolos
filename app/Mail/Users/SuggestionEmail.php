<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Suggestion;

class SuggestionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $suggestion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Suggestion $suggestion)
    {
        $this->suggestion = $suggestion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pedido confirmado!')->markdown('emails.users.suggestion');
    }
}
