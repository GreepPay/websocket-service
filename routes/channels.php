<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/*
|--------------------------------------------------------------------------
| P2P-order private channel
| Name : p2p-order.{orderUuid}
| Auth : ANY logged-in user (guarded by auth:custom on /broadcasting/auth)
|--------------------------------------------------------------------------
*/
Broadcast::channel('p2p-order.{orderUuid}', fn () => true);
