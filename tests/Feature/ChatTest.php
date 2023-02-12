<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, User, Chat};
use Illuminate\Support\Collection;

class ChatTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->signIn();
        $this->gig = Gig::factory()->live()->create();
        $this->otherUser = User::factory()->create();

        auth()->user()->join($this->gig);
        $this->otherUser->join($this->gig);
    }

    /** @test */
    public function a_user_can_send_chat_messages()
    {
        $message = 'Hello!';

        $chat = Chat::factory()->make(['to_id' => $this->otherUser]);

        $this->post(route('chat.store', $chat->to->id), ['message' => $chat->message]);

        $this->assertDatabaseHas('chats', ['from_id' => auth()->user()->id]);

        $this->assertCount(1, Chat::sender(auth()->user())->get());
        $this->assertCount(0, Chat::recipient(auth()->user())->get());

        $this->assertCount(0, Chat::sender($this->otherUser)->get());
        $this->assertCount(1, Chat::recipient($this->otherUser)->get());
    }

    /** @test */
    public function a_chat_message_can_be_marked_as_read_or_unread()
    {
        $this->assertCount(0, Chat::sender(auth()->user())->unread()->get());
        $this->assertCount(0, Chat::recipient($this->otherUser)->unread()->get());

        $chat = Chat::factory()->make(['to_id' => $this->otherUser]);

        $this->post(route('chat.store', $chat->to->id), ['message' => $chat->message]);

        $this->assertCount(1, Chat::sender(auth()->user())->unread()->get());

        $this->assertCount(1, Chat::recipient($this->otherUser)->unread()->get());

        $this->patch(route('chat.read', Chat::sender(auth()->user())->unread()->first()));

        $this->assertCount(0, Chat::sender(auth()->user())->unread()->get());

        $this->assertCount(0, Chat::recipient($this->otherUser)->unread()->get());
    }
}
