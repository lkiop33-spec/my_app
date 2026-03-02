<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PcbImageTable extends Model
{
    use HasFactory;

    protected $table = 'pcb_image_tables';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'PCB_Number',
        'Image',
        'BoundBox',
        'Other',
    ];
}
