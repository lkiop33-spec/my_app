<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartTable extends Model
{
    use HasFactory;

    protected $table = 'part_tables';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'Part_Number',
        'Name',
        'PCB_Number',
        'Process_Class',
        'Process_Name',
        'Process_Detail',
        'Side',
        'Image_File',
        'Quantity',
        'Location_1',
        'Location_2',
        'Location_3',
        'Location_4',
    ];
}
