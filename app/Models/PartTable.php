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
        'Name_enc',
        'Process_Detail_enc',
        'Image_File_enc',
    ];

    protected function Name(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value, $attributes) {
                if (!empty($attributes['Name_enc'])) {
                    try {
                        return \Illuminate\Support\Facades\Crypt::decryptString($attributes['Name_enc']);
                    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                        return '*** DECRYPTION ERROR ***';
                    }
                }
                return $value;
            },
            set: fn ($value) => [
                'Name' => 'ENCRYPTED',
                'Name_enc' => \Illuminate\Support\Facades\Crypt::encryptString($value),
            ]
        );
    }

    protected function ProcessDetail(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value, $attributes) {
                if (!empty($attributes['Process_Detail_enc'])) {
                    try {
                        return \Illuminate\Support\Facades\Crypt::decryptString($attributes['Process_Detail_enc']);
                    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                        return '*** DECRYPTION ERROR ***';
                    }
                }
                return $value;
            },
            set: fn ($value) => [
                'Process_Detail' => 'ENCRYPTED',
                'Process_Detail_enc' => \Illuminate\Support\Facades\Crypt::encryptString($value),
            ]
        );
    }

    protected function ImageFile(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value, $attributes) {
                if (!empty($attributes['Image_File_enc'])) {
                    try {
                        return \Illuminate\Support\Facades\Crypt::decryptString($attributes['Image_File_enc']);
                    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                        return '*** DECRYPTION ERROR ***';
                    }
                }
                return $value;
            },
            set: fn ($value) => [
                'Image_File' => 'ENCRYPTED',
                'Image_File_enc' => \Illuminate\Support\Facades\Crypt::encryptString($value),
            ]
        );
    }

    /**
     * Get the PCB that the part belongs to.
     */
    public function pcbRelationship()
    {
        return $this->belongsTo(PcbTable::class, 'PCB_Number', 'idx');
    }
}

