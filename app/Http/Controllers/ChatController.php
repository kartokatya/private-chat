<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Models\Session;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Session $session, Request $request)
    {
        $message = $session->messages()->create(['messages'=>$request->contents]);
        $message->createForSend($session->id);
        $message->createForRecieve($session->id,$request->to_user);
        response($message,200);
    }

    public function chats(Session $session)
    {
        return ChatResource::collection($session->chats->where('user_id',auth()->id()));
    }
}
