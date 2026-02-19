<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geade extends Model
{
    use HasFactory;

    protected $fillable = [
        'rank_type',
        'description',
    ];

    // Optional: Cast rank_type to ensure it's treated correctly if needed later
    // protected $casts = [
    //     'rank_type' => 'string',
    // ];
}
