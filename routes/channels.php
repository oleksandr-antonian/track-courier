<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('couriers.locations', function ($user) {
    return $user->hasRole('admin');
});
