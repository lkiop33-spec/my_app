<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forbidden extends Model
{
    use HasFactory;

    protected $table = 'forbiddens';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'text',
    ];
}
