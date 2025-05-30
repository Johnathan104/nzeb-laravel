<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeliharaan extends Model
{
    protected $table = 'pemeliharaan';

    protected $fillable = [
        'room_id',
        'lokasi',
        'tanggal_mulai',
        'user_id',
        'issue_id',
        'part_type_id',
        'jenis_pemeliharaan',
        'kondisi',
        'keterangan',
        'durasi',
        'estimasi',
        'supervisor',
        'tanggal_pemohonan',
        'nama_petugas',
    ];

    /**
     * Relationship with the Room model.
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with the Issue model.
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }

    /**
     * Relationship with the BuildingPart model.
     */
    public function buildingPart()
    {
        return $this->belongsTo(BuildingPart::class, 'part_type_id');
    }
}
