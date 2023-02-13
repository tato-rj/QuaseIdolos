<?php

namespace App\Http\Controllers;

use App\Models\{Chat, User};
use Illuminate\Http\Request;
use App\Events\ChatSent;

class ChatController extends Controller
{
    public function between(User $userOne, User $userTwo)
    {
        $user = $userTwo->is(auth()->user()) ? $userOne : $userTwo;
        $chat = Chat::between($userOne, $userTwo)->get();

        auth()->user()->read($chat);

        return view('components.chat.conversation', compact(['chat', 'user']))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $to)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        Chat::create([
            'gig_id' => auth()->user()->liveGig->id,
            'from_id' => auth()->user()->id,
            'to_id' => $to->id,
            'message' => $request->message
        ]);

        $chat = Chat::between(auth()->user(), $to)->get();

        try {
            ChatSent::dispatch($to);
        } catch (\Exception $e) {
            bugreport($e);
        }

        return view('components.chat.conversation', ['chat' => $chat, 'user' => $to])->render();
    }

    public function read(Chat $chat)
    {
        return $chat->markAsRead();
    }

    public function unreadCount(Request $request)
    {
        $unread = auth()->user()->receivedMessages()->unread()->get();

        $global = view('components.chat.unread', ['count' => $unread->count()])->render();

        $users = collect();

        foreach ($unread->groupBy('from_id') as $userId => $chat) {
            $users->push(['user_id' => $userId, 'view' => view('components.chat.unread', ['count' => $chat->count()])->render()]);
        }

        return response()->json(compact(['global', 'users']));
    }
}
