<?php

namespace App\Console\Commands;

use App\Services\CourierLocationService;
use Illuminate\Console\Command;

class SyncCourierLocations extends Command
{
    protected $signature = 'courier:sync-locations';
    protected $description = 'Sync courier locations from Redis to the database and clear old Redis data';

    private CourierLocationService $courierLocationService;

    public function __construct(CourierLocationService $courierLocationService)
    {
        parent::__construct();
        $this->courierLocationService = $courierLocationService;
    }

    public function handle(): void
    {
        $this->info('Starting courier location sync...');
        $this->courierLocationService->syncLocations();
        $this->info('Courier location sync completed.');
    }
}
