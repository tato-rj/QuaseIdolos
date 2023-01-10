<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialiteController extends Controller
{
    protected $drivers = ['github', 'facebook', 'google', 'instagram'];

    public function redirect($driver)
    {
        $this->validateDriver($driver);

        return Socialite::driver($driver)->redirect();
    }

    public function callback($driver)
    {
        $this->validateDriver($driver);

        $socialUser = Socialite::driver($driver)->user();

        $user = User::updateOrCreate([
            'email' => $socialUser->email
        ], [
            'name' => $socialUser->name,
            //SOCIAL CREDENTIALS
            'social_id' => $socialUser->id,
            'social_token' => $socialUser->token,
            'social_refresh_token' => $socialUser->refreshToken
        ]);

        if (! $user->hasOwnAvatar())
            $user->update(['avatar_url' => $this->saveAvatar($socialUser->avatar)]);

        \Auth::login($user);

        return redirect(route('home'));
    }

    public function saveAvatar($image)
    {
        return str_replace('=s96-c', '=s400-c', str_replace('type=normal', 'type=large', $image));
    }

    public function validateDriver($driver)
    {
        if (! in_array($driver, $this->drivers))
            abort(401);
    }
}
