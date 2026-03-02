<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Part extends Model
{
    use HasFactory;

    protected $table = 'parts';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'name',
        'level',
    ];
}
