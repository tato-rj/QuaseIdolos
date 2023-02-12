<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, User, Chat};
use Illuminate\Support\Collection;
use App\Events\ChatSent;

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

    /** @test */
    public function users_can_see_their_chat_with_other_users()
    {
        $chat = Chat::factory()->make(['to_id' => $this->otherUser]);

        $this->post(route('chat.store', $chat->to->id), ['message' => $chat->message]);

        $this->get(route('chat.between', ['userOne' => auth()->user(), 'userTwo' => $this->otherUser]))->assertSee($chat->message);
    }

    /** @test */
    public function a_chat_only_shows_messages_between_the_two_users()
    {
        $chat = Chat::factory()->make(['to_id' => $this->otherUser]);

        $this->post(route('chat.store', $chat->to->id), ['message' => $chat->message]);

        $userWithoutChat = User::factory()->create();

        $userWithoutChat->join($this->gig);

        $this->get(route('chat.between', ['userOne' => auth()->user(), 'userTwo' => $userWithoutChat]))->assertDontSee($chat->message);
    }

    /** @test */
    public function when_a_user_sees_the_chat_the_messages_are_marked_as_read()
    {
        $chat = Chat::factory()->make(['to_id' => $this->otherUser]);

        $this->post(route('chat.store', $chat->to->id), ['message' => $chat->message]);

        $this->assertFalse(Chat::first()->isRead());
        
        $this->get(route('chat.between', ['userOne' => auth()->user(), 'userTwo' => $this->otherUser]));

        $this->assertFalse(Chat::first()->isRead());

        $firstUser = auth()->user();

        $this->signIn($this->otherUser);

        $this->get(route('chat.between', ['userOne' => $this->otherUser, 'userTwo' => $firstUser]));

        $this->assertTrue(Chat::first()->isRead());
    }

    /** @test */
    public function when_a_user_sends_a_message_an_event_is_fired()
    {
        $chat = Chat::factory()->make(['to_id' => $this->otherUser]);

        $this->post(route('chat.store', $chat->to->id), ['message' => $chat->message]);

        \Event::assertDispatched(ChatSent::class, function ($event) use ($chat) {
            return $event->user->is($chat->to);
        });
    }
}
