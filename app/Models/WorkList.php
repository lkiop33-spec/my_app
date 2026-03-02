<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkList extends Model
{
    use HasFactory;

    protected $table = 'work_lists';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'partList',
        'pcbIDX',
        'memberIDX',
    ];
}
