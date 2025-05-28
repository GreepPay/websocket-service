<?php

namespace App\Http\Controllers;

use App\Services\P2pOrderBroadcaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class P2POrderController extends Controller
{
    public function __construct(private P2pOrderBroadcaster $broadcaster)
    {
    }

    /**
     * Broadcast a “created” event for a new P2P order.
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
     * Broadcast an “updated” event for an existing P2P order.
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
