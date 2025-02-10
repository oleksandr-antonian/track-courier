<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierLocation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['courier_id', 'latitude', 'longitude', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
