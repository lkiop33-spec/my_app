<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PcbTable extends Model
{
    use HasFactory;

    protected $table = 'pcb_tables';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'PCB_Number',
        'Name_Type',
        'Image_File',
        'Image_Side',
    ];
}
