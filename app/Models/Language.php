<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'mlanguage',
    ];
}
