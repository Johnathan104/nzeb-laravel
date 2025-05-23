<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'room_id',
        'part_type_id',
        'part_name',
        'user_id'
    ];

    /**
     * Relationship with the Room model.
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Relationship with the BuildingPart model.
     */
    public function buildingPart()
    {
        return $this->belongsTo(BuildingPart::class, 'part_type_id');
    }
}
