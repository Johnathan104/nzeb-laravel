<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPart extends Model
{
    use HasFactory;

    protected $table = 'building_parts'; // Table name

    protected $fillable = [
        'class',
        'type',          // Type of the building part
        'pemeriksaan',   // Pemeriksaan field
        'pemeliharaan',  // Pemeliharaan field
        'perawatan',     // Perawatan field
        'title',         // Title of the building part
        'locations',     // JSON column for locations
        'url',
    ];

    protected $casts = [

    ];
}
