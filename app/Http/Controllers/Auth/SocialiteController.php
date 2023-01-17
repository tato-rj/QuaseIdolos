<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\{User, SocialAccount};

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

        try {
            if ($socialAccount = SocialAccount::bySocialId($socialUser->getId())->first())          
                return $this->existingSocialAccount($socialAccount, $socialUser);

            if ($user = User::byEmail($socialUser->getEmail())->first())
                return $this->newSocialAccount($driver, $user, $socialUser);

            return $this->newUser($driver, $socialUser);            
        } catch (\Exception $e) {
            throwValidationException('Infelizmente não conseguimos fazer o login com o ' . $driver);
        }
    }

    public function unlink(SocialAccount $socialAccount, User $user = null)
    {
        $this->authorize('update', $user ?? User::class);

        $socialAccount->delete();

        return back()->with('success', 'Esse provedor foi removido com sucesso');
    }

    public function existingSocialAccount($socialAccount, $socialUser)
    {
        if (! $socialAccount->user->hasOwnAvatar())
            $socialAccount->user->update(['avatar_url' => $this->saveLargeAvatar($socialUser->getAvatar())]);

        \Auth::login($socialAccount->user, $remember = true);

        return redirect(route('home'));
    }

    public function newSocialAccount($driver, $user, $socialUser)
    {
        $user->socialAccounts()->create([
            'social_provider' => $driver,
            'social_id' => $socialUser->getId(),
            'social_token' => $socialUser->token,
            'social_refresh_token' => $socialUser->refreshToken
        ]);

        if (! $user->hasOwnAvatar())
            $user->update(['avatar_url' => $this->saveLargeAvatar($socialUser->getAvatar())]);

        \Auth::login($user, $remember = true);

        return redirect(route('home'));   
    }

    public function newUser($driver, $socialUser)
    {
        $user = User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'avatar_url' => $this->saveLargeAvatar($socialUser->getAvatar()),
        ]);

        $user->socialAccounts()->create([
            'social_provider' => $driver,
            'social_id' => $socialUser->getId(),
            'social_token' => $socialUser->token,
            'social_refresh_token' => $socialUser->refreshToken
        ]);

        \Auth::login($user, $remember = true);

        return redirect(route('home'));
    }

    public function saveLargeAvatar($image)
    {
        return str_replace('=s96-c', '=s400-c', str_replace('type=normal', 'type=large', $image));
    }

    public function validateDriver($driver)
    {
        if (! in_array($driver, $this->drivers))
            throwValidationException('Infelizmente podemos fazer o login com esse provedor');
    }
}
