<?php

namespace App\Http\Controllers;

use App\Models\{Chat, User};
use Illuminate\Http\Request;
use App\Events\ChatSent;

class ChatController extends Controller
{
    public function between(User $userOne, User $userTwo)
    {
        $this->authorize('view', Chat::class);
        
        $user = $userTwo->is(auth()->user()) ? $userOne : $userTwo;
        $chat = Chat::between($userOne, $userTwo)->get();

        auth()->user()->read($chat);

        return view('components.chat.conversation', compact(['chat', 'user']))->render();
    }

    public function participants()
    {
        $this->authorize('view', Chat::class);

        $participants = auth()->user()->liveGig->participants()->wantsChat()->didntBlockMe()->get()->sortBy('user.name');

        return view('components.chat.participants', compact('participants'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $to)
    {
        $this->authorize('sendMessage', [Chat::class, $to]);

        $request->validate([
            'message' => 'required|string'
        ]);

        $chat = Chat::create([
            'gig_id' => auth()->user()->liveGig->id,
            'from_id' => auth()->user()->id,
            'to_id' => $to->id,
            'message' => $request->message
        ]);

        try {
            ChatSent::dispatch($to, $chat);
        } catch (\Exception $e) {
            bugreport($e);
        }

        $conversation = Chat::between(auth()->user(), $to)->get();
        
        return view('components.chat.conversation', ['chat' => $conversation, 'user' => $to])->render();
    }

    public function user(Request $request)
    {   
        $user = User::findOrFail($request->userId);

        $this->authorize('sendMessage', [Chat::class, $user]);

        return view('components.chat.user', compact('user'))->render();
    }

    public function block(User $user)
    {
        auth()->user()->blocked()->create(['user_id' => $user->id]);

        return back()->with('success', 'O usuário foi bloqueado com sucesso');
    }

    public function unblock(User $user)
    {
        auth()->user()->blocked()->searchFor($user)->delete();

        return back()->with('success', 'O usuário foi desbloqueado com sucesso');
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
