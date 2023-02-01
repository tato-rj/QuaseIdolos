<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{User, Gig, SongRequest, Rating, Suggestion, Invitation};
use App\Mail\Users\{WelcomeEmail, WinnerEmail, SuggestionEmail};

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
        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now()]);

        auth()->user()->join($gig);
        
        $winnerRequest = SongRequest::factory()->create(['gig_id' => $gig]);
        $loserRequest = SongRequest::factory()->create(['gig_id' => $gig]);

        Rating::factory()->create(['song_request_id' => $winnerRequest, 'score' => 5]);
        Rating::factory()->create(['song_request_id' => $loserRequest, 'score' => 1]);

        $this->get(route('ratings.winner.show'));

        \Mail::assertQueued(function(WinnerEmail $mail) use ($winnerRequest, $loserRequest) {
            return $mail->winner->is($winnerRequest) && ! $mail->winner->is($loserRequest);
        });
    }

    /** @test */
    public function each_winner_in_a_group_request_can_receive_an_email_upon_announcement()
    {
        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now()]);

        auth()->user()->join($gig);
        
        $winnerRequest = SongRequest::factory()->create(['gig_id' => $gig]);
        $loserRequest = SongRequest::factory()->create(['gig_id' => $gig]);

        Invitation::factory()->create(['song_request_id' => $winnerRequest]);

        Rating::factory()->create(['song_request_id' => $winnerRequest, 'score' => 5]);
        Rating::factory()->create(['song_request_id' => $loserRequest, 'score' => 1]);

        $this->get(route('ratings.winner.show'));

        \Mail::assertQueued(function(WinnerEmail $mail) use ($winnerRequest) {
            return $mail->hasTo($winnerRequest->singers()->pluck('email'));
        });
    }

    /** @test */
    public function the_winner_email_only_goes_out_once()
    {
        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now()]);

        auth()->user()->join($gig);

        $winnerRequest = SongRequest::factory()->create(['gig_id' => $gig]);
        $loserRequest = SongRequest::factory()->create(['gig_id' => $gig]);

        Rating::factory()->create(['song_request_id' => $winnerRequest, 'score' => 5]);
        Rating::factory()->create(['song_request_id' => $loserRequest, 'score' => 1]);

        $gig->winner()->associate($winnerRequest)->save();

        $this->get(route('ratings.winner.show'));

        \Mail::assertNotQueued(WinnerEmail::class);
    }

    /** @test */
    public function an_email_is_sent_to_the_user_when_a_suggestion_is_confirmed()
    {
        $suggestion = Suggestion::factory()->create();

        $this->signIn($this->admin);

        $this->post(route('suggestions.confirm', $suggestion));

        \Mail::assertQueued(function(SuggestionEmail $mail) use ($suggestion) {
            return $mail->suggestion->is($suggestion);
        });
    }
}
