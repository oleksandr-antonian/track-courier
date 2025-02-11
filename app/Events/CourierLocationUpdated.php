<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourierLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $courierId,
        public float $latitude,
        public float $longitude
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('couriers.locations');
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
