<?php

namespace App\Http\Controllers;

use App\Services\TransactionBroadcaster;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(private TransactionBroadcaster $broadcaster) {}

    /**
     * Broadcast a “created” event for a new transaction.
     *
     * @param  Request  $req
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $req)
    {
        $data = $req->validate([
            'uuid' => 'required|string',
        ]);

        $this->broadcaster->created($data['uuid'], $req->all());

        return response()->json(['broadcasted' => true], 202);
    }

    /**
     * Broadcast an “updated” event for an existing transaction.
     *
     * @param  Request  $req
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $req)
    {
        $data = $req->validate([
            'uuid' => 'required|string',
            'status' => 'sometimes|string|max:20',
        ]);

        $this->broadcaster->updated($data['uuid'], $data);

        return response()->json(['broadcasted' => true], 202);
    }
}
