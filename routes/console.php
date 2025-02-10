<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('courier:sync-locations')->hourly();
