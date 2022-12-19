<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Users\{WelcomeEmail, WinnerEmail};
use App\Voting\Ranking;

class MailController extends Controller
{
    protected $mails = [
        'welcome-email' => WelcomeEmail::class,
        'winner-email' => WinnerEmail::class
    ];

    public function preview($mail)
    {
        if (! array_key_exists($mail, $this->mails) || production())
            abort(404);

        $method = lcfirst(class_basename($this->mails[$mail]));

        return $this->$method();
    }

    public function welcomeEmail()
    {
        return new WelcomeEmail(auth()->user());
    }

    public function winnerEmail()
    {
        $ranking = (new Ranking)->mock()->create();

        return new WinnerEmail($ranking);
    }
}
