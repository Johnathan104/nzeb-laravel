<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_name',
        'temp',
        'electricity_usage',
        'building_parts'
    ];
    protected $casts = [
    ];
}?>
