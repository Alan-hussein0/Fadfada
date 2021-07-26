<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\http\Controllers\BaseController as BaseController;
use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageRead;
use App\Events\NewMessage;
use App\Http\Resources\Message as ResourcesMessage;
use Illuminate\Support\Facades\Auth;

class MessagesController extends BaseController
{
    public function get(Chat $chat)
    {
        return $this->sendResponse(
            ResourcesMessage::collection(
            Message::where('chat_id', $chat->id)
            ->latest()
            ->paginate(20)
        ),'the message retrieved successfully!');
    }



    public function store(Chat $chat, Request $request)
    {
        $this->validate($request,[
            'message' => 'required|string'
        ]);

        $message = User::find(Auth::id())->messages()->create([
            'message' => $request->message,
            'chat_id' => $chat->id,
        ])->load('sender');

        $chat->messages()->attach($message);

        $chat->touch();

        broadcast(new NewMessage(Auth::user(), $message, $chat))->toOthers();

        return $this->sendResponse($message, 'message sent!');
    }


    public function update(Chat $chat, User $user)
    {
      $message =  $chat->senderMessages($user)
            ->get()
            ->markAsRead();

        broadcast(new MessageRead(Auth::user(), $chat))->toOthers();

        return $this->sendResponse(
            new ResourcesMessage($message),'Messages mark as read!');
    }
}

