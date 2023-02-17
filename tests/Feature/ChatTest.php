<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, User, Chat};
use Illuminate\Support\Collection;
use App\Events\{ChatSent, ChatRead};

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


    /** @test */
    public function when_a_user_reads_a_message_an_event_is_fired()
    {
        $chat = Chat::factory()->create(['gig_id' => $this->gig, 'from_id' => auth()->user(), 'to_id' => $this->otherUser]);

        $this->assertFalse($chat->isRead());
        
        $this->signIn($this->otherUser);

        $chat->markAsRead();

        $this->assertTrue($chat->isRead());

        \Event::assertDispatched(ChatRead::class);
    }

    /** @test */
    public function when_a_gig_is_deleted_its_chats_are_also_removed()
    {
        $chat = Chat::factory()->create();

        $this->signIn($this->superAdmin);

        $this->assertDatabaseHas('chats', ['id' => $chat->id]);

        $this->delete(route('gig.destroy', $chat->gig));

        $this->assertDatabaseMissing('chats', ['id' => $chat->id]);
    }

    /** @test */
    public function when_a_user_is_deleted_its_chats_are_also_removed()
    {
        $chat = Chat::factory()->create();

        $this->signIn($this->superAdmin);

        $this->assertDatabaseHas('chats', ['id' => $chat->id]);

        $this->delete(route('profile.destroy', $chat->to));

        $this->assertDatabaseMissing('chats', ['id' => $chat->id]);
    }

    /** @test */
    public function it_sends_back_the_global_count_of_unread_messages_along_with_individual_ones()
    {
        $thirdUser = User::factory()->create();
        
        $thirdUser->join($this->gig);

        $readMessage = Chat::factory()->create(['gig_id' => $this->gig, 'to_id' => auth()->user(), 'from_id' => $this->otherUser]);
        
        $unreadMessage = Chat::factory()->create(['gig_id' => $this->gig, 'to_id' => auth()->user(), 'from_id' => $this->otherUser]);

        $otherMessage = Chat::factory()->create(['gig_id' => $this->gig, 'to_id' => auth()->user(), 'from_id' => $thirdUser]);

        $readMessage->markAsRead();

        $response = $this->get(route('chat.unread-count'));

        $this->assertStringContainsString('2</div>', $response->json()['global']);

        $this->assertCount(2, $response->json()['users']);
    }

    /** @test */
    public function users_can_choose_not_to_participate_in_the_chat()
    {
        $this->get(route('chat.participants'))->assertSee($this->otherUser->first_name);

        $this->otherUser->update(['participates_in_chat' => false]);

        $this->get(route('chat.participants'))->assertDontSee($this->otherUser->first_name);
    }

    /** @test */
    public function users_can_block_other_users_from_their_chat()
    {
        $firstUser = auth()->user();

        $this->assertFalse(auth()->user()->blocked()->searchFor($this->otherUser)->exists());

        $this->signIn($this->otherUser);

        $this->get(route('chat.participants'))->assertSee($firstUser->first_name);

        $this->signIn($firstUser);

        $this->post(route('chat.block', $this->otherUser));

        $this->assertTrue(auth()->user()->blocked()->searchFor($this->otherUser)->exists());

        $this->signIn($this->otherUser);

        $this->get(route('chat.participants'))->assertDontSee($firstUser->first_name);
    }

    /** @test */
    public function users_can_unblock_other_users_from_their_chat()
    {
        $this->assertFalse(auth()->user()->blocked()->searchFor($this->otherUser)->exists());

        $this->post(route('chat.block', $this->otherUser));

        $this->assertTrue(auth()->user()->blocked()->searchFor($this->otherUser)->exists());

        $this->post(route('chat.unblock', $this->otherUser));

        $this->assertFalse(auth()->user()->blocked()->searchFor($this->otherUser)->exists());
    }

    /** @test */
    public function users_cannot_send_a_message_to_those_who_blocked_them()
    {
        $firstUser = auth()->user();

        $chat = Chat::factory()->make(['to_id' => $this->otherUser]);

        $this->post(route('chat.store', $chat->to->id), ['message' => 'Hello!']);

        $this->signIn($this->otherUser);

        $this->post(route('chat.block', $firstUser));

        $this->signIn($firstUser);

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->post(route('chat.store', $chat->to->id), ['message' => 'Not now']);
    }
}
