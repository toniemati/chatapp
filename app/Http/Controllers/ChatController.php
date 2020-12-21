<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function rooms(Request $request)
    {
        return ChatRoom::all();
    }

    public function messages(Request $request, $roomID)
    {
        return ChatMessage::where('chat_room_id', $roomID)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function newMessage(Request $request, $roomID)
    {
        $newMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'chat_room_id' => $roomID,
            'message' => $request->message
        ]);

        broadcast(new NewChatMessage($newMessage))->toOthers();

        return $newMessage;
    }
}
