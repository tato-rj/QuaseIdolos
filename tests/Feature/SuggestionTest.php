<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\Suggestion;

class SuggestionTest extends AppTest
{
    /** @test */
    public function an_admin_can_remove_a_suggestion()
    {
        $suggestion = Suggestion::factory()->create();

        $this->signIn($this->admin);

        $this->delete(route('suggestions.destroy', $suggestion));

        $this->assertDatabaseMissing('suggestions', ['id' => $suggestion->id]);
    }

    /** @test */
    public function a_user_can_add_a_suggestion()
    {
        $suggestion = Suggestion::factory()->make();

        $this->signIn();

        $this->assertCount(0, auth()->user()->suggestions);

        $this->post(route('suggestions.store', $suggestion->toArray()));

        $this->assertCount(1, auth()->user()->fresh()->suggestions);
    }

    /** @test */
    public function a_suggestion_can_be_confirmed()
    {
        $suggestion = Suggestion::factory()->create();

        $this->signIn($this->admin);

        $this->assertCount(1, $suggestion->unconfirmed()->get());

        $this->post(route('suggestions.confirm', $suggestion));

        $this->assertCount(0, $suggestion->unconfirmed()->get());
    }
}
