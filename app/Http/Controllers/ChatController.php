<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Http\Resources\ChatResource;
use App\Events\PrivateChatEvent;

class ChatController extends Controller
{
    public function send(Session $session, Request $request){
        $message= $session->messages()->create(['content'=> $request->content]);

        $chat=$message->createForSend($session->id);

        $message->createForreceive($session->id,$request->to_user);
        
        broadcast(new PrivateChatEvent($message->content,$chat));

        return response($message,200);
    }

    public function chats(Session $session){
        return ChatResource::collection($session->chats->where('user_id',auth()->id()));
    }
}
