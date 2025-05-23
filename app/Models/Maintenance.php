<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'routine',
        'room_id',
        'pelaksana',
        'location',
        'operator',
        'date_start',
        'date_end',
        'safety_helmet',
        'safety_vest',
        'safety_shoes',
        'gloves',
        'mask',
        'full_body_harness',
        'work_steps',
        'hazards',
        'pemohon',
        'mitigation',
        'status',
    ];

    /**
     * Define the relationship with the Room model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}