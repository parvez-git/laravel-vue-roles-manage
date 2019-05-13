<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function userlist()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        $unreadIds = Chat::select(DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        $users = $users->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });

        return response()->json($users);
    }

    public function userConversations($id)
    {
        Chat::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

        $conversations = Chat::where(function($query) use ($id) {
            $query->where('from', auth()->id());
            $query->where('to', $id);
        })->orWhere(function($query) use ($id) {
            $query->where('from', $id);
            $query->where('to', auth()->id());
        })->get();

        return response()->json($conversations);
    }

    public function sendConversation(Request $request)
    {
        $conversation = Chat::create([
            'from'      => auth()->id(),
            'to'        => $request->to,
            'message'   => $request->message
        ]);

        broadcast(new NewChatMessage($conversation));

        return response()->json($conversation);
    }
}
