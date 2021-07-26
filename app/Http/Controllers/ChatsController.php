<?php

namespace App\Http\Controllers;
use App\http\Controllers\BaseController as BaseController;
use App\Http\Resources\Chat as ResourcesChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Chat;

class ChatsController extends BaseController
{

    public function currentuser()
    {
        return auth()->user();
    }

    public function index()
    {
        $chats = User::find(Auth::id())
                ->chats()
                ->latest('updated_at')
                ->paginate(15);

        return $this->sendResponse(ResourcesChat::collection($chats),'Chats retrieved successfully!');
    }

    public function show(User $user)
    {
        $chat = $this->findOrCreateChatRoom($user);

        return $this->sendResponse(new ResourcesChat($chat),'Chat retrieved successfully!');
    }

    public function findOrCreateChatRoom(User $user)
    {
        $chat =  auth()->user()->chats->filter(function ($chat) use ($user) {
            if ($chat->participants->contains($user)) {
                return $chat;
            }
        })->first();

        if (!$chat) {
            $chat = Chat::create();

            $chat->participants()->attach([Auth::id(),$user->id]);
        }

        return $chat;
    }

}
