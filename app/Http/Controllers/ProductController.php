<?php

namespace App\Http\Controllers;

use App\Services\ProductBroadcaster;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductBroadcaster $broadcaster) {}

    /**
     * Broadcast a “created” event for a new product.
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
     * Broadcast an “updated” event for an existing product.
     *
     * @param  Request  $req
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $req)
    {
        $data = $req->validate([
            'uuid' => 'required|string',
            'price' => 'sometimes|numeric',
            'stock' => 'sometimes|integer',
        ]);

        $this->broadcaster->updated($data['uuid'], $data);

        return response()->json(['broadcasted' => true], 202);
    }
}
