<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Users\WelcomeEmail;

class MailController extends Controller
{
    protected $mails = [
        'welcome-email' => WelcomeEmail::class
    ];

    public function preview($mail)
    {
        if (! array_key_exists($mail, $this->mails))
            abort(404);

        return new $this->mails[$mail](auth()->user());
    }
}
