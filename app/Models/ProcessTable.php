<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessTable extends Model
{
    use HasFactory;

    protected $table = 'process_tables';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'Code',
        'Name',
        'Class',
        'Sequence',
    ];
}
