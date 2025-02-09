<?php

namespace App\Models;

use App\Enums\CourierAvailabilityStatus;
use App\Enums\CourierTransportType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Courier extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'availability_status',
        'transport_type',
        'city_id',
    ];

    protected $casts = [
        'availability_status' => CourierAvailabilityStatus::class,
        'transport_type' => CourierTransportType::class,
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
