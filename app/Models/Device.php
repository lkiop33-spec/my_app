<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'name',
        'password',
        'location',
        'version',
    ];

    /**
     * Get the location that the device belongs to.
     */
    public function locationRelationship()
    {
        return $this->belongsTo(Location::class, 'location', 'idx');
    }
}

