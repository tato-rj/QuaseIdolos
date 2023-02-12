<?php

namespace App\Http\Controllers;

use App\Models\{Chat, User};
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $to)
    {
        $request->validate(['message' => 'required|string']);

        return Chat::create([
            'from_id' => auth()->user()->id,
            'to_id' => $to->id,
            'message' => $request->message
        ]);
    }

    public function read(Chat $chat)
    {
        return $chat->markAsRead();
    }
}
