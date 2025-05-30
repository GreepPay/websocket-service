<?php

namespace App\Http\Controllers;

use App\Services\ShopOrderBroadcaster;
use Illuminate\Http\Request;

class ShopOrderController extends Controller
{
    public function __construct(private ShopOrderBroadcaster $broadcaster) {}

    /**
     * Broadcast a “created” event for a new shop order.
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
     * Broadcast an “updated” event for an existing shop order.
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
