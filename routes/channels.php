<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('couriers.{courierId}', function ($user, $courierId) {
    return (int) $user->id === (int) $courierId || $user->hasRole('admin');
});
