<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{User, Gig, SongRequest, Rating, Admin};
use App\Mail\Users\{WelcomeEmail, WinnerEmail};

class EmailTest extends AppTest
{
    /** @test */
    public function new_users_receive_a_welcome_email()
    {
        $request = User::factory()->make();

        $this->post(route('register'), [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password
        ]);

        \Mail::assertQueued(WelcomeEmail::class);
    }

    /** @test */
    public function the_winner_can_receive_an_email_upon_announcement()
    {
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now()]);

        $winnerRequest = SongRequest::factory()->create(['gig_id' => $gig]);
        $loserRequest = SongRequest::factory()->create(['gig_id' => $gig]);

        Rating::factory()->create(['song_request_id' => $winnerRequest, 'score' => 5]);
        Rating::factory()->create(['song_request_id' => $loserRequest, 'score' => 1]);

        $this->get(route('ratings.winner'));

        \Mail::assertQueued(function(WinnerEmail $mail) use ($winnerRequest, $loserRequest) {
            return $mail->winner->is($winnerRequest) && ! $mail->winner->is($loserRequest);
        });
    }

    /** @test */
    public function the_winner_email_only_goes_out_once()
    {
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now()]);

        $winnerRequest = SongRequest::factory()->create(['gig_id' => $gig]);
        $loserRequest = SongRequest::factory()->create(['gig_id' => $gig]);

        Rating::factory()->create(['song_request_id' => $winnerRequest, 'score' => 5]);
        Rating::factory()->create(['song_request_id' => $loserRequest, 'score' => 1]);

        $gig->winner()->associate($winnerRequest)->save();

        $this->get(route('ratings.winner'));

        \Mail::assertNotQueued(WinnerEmail::class);
    }
}
