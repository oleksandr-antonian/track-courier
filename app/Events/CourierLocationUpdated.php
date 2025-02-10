<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourierLocationUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $courierId,
        public float $latitude,
        public float $longitude
    ) {}

    public function broadcastOn(): PresenceChannel
    {
        return new PresenceChannel('couriers.global');
    }

    public function broadcastWith(): array
    {
        return [
            'courier_id' => $this->courierId,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
