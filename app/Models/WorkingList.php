<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'worker_name',
        'text',
        'datetime',
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];
}
