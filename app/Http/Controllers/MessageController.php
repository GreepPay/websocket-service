<?php

namespace App\Http\Controllers;

use App\Services\MessageBroadcaster;
use Illuminate\Http\Request;

/**
 * Handle chat/message pushes.
 */
class MessageController extends Controller
{
    public function __construct(private MessageBroadcaster $broadcaster) {}

    /**
     * Broadcast a new chat message.
     *
     * @param  Request  $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $req)
    {
        $data = $req->validate([
            'conversation_id' => 'required|string',
            'message_id'      => 'required|string',
            'sender_id'       => 'required|integer',
            'body'            => 'required|string|max:2000',
            'sent_at'         => 'sometimes|date_format:Y-m-d\TH:i:sP',
        ]);

        $this->broadcaster->created($data['conversation_id'], $data);

        return response()->json(['broadcasted' => true], 202);
    }
}
