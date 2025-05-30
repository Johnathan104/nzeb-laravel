<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'date-start',
        'date-end',
        'room_id',
        'issues_found',
        'user_id',
        'members', // Add members to fillable
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date-start' => 'datetime',
        'date-end' => 'datetime',
        'members' => 'array', // Cast members as an array
        'issues_found'=> 'array'
    ];

    /**
     * Define the relationship with the Room model.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Define the relationship with the User model.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users', 'id', 'id')
                    ->whereIn('id', $this->members);
    }
}
