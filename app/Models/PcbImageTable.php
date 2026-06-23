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
        'Image_enc',
        'BoundBox',
        'BoundBox_enc',
        'Other',
        'Other_enc',
    ];

    protected function Image(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value, $attributes) {
                if (!empty($attributes['Image_enc'])) {
                    try {
                        return \Illuminate\Support\Facades\Crypt::decryptString($attributes['Image_enc']);
                    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                        return '*** DECRYPTION ERROR ***';
                    }
                }
                return $value;
            },
            set: fn ($value) => [
                'Image' => 'ENCRYPTED',
                'Image_enc' => \Illuminate\Support\Facades\Crypt::encryptString($value),
            ]
        );
    }

    protected function BoundBox(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value, $attributes) {
                if (!empty($attributes['BoundBox_enc'])) {
                    try {
                        return \Illuminate\Support\Facades\Crypt::decryptString($attributes['BoundBox_enc']);
                    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                        return '*** DECRYPTION ERROR ***';
                    }
                }
                return $value;
            },
            set: fn ($value) => [
                'BoundBox' => 'ENCRYPTED',
                'BoundBox_enc' => \Illuminate\Support\Facades\Crypt::encryptString($value),
            ]
        );
    }

    protected function Other(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value, $attributes) {
                if (!empty($attributes['Other_enc'])) {
                    try {
                        return \Illuminate\Support\Facades\Crypt::decryptString($attributes['Other_enc']);
                    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                        return '*** DECRYPTION ERROR ***';
                    }
                }
                return $value;
            },
            set: fn ($value) => [
                'Other' => 'ENCRYPTED',
                'Other_enc' => \Illuminate\Support\Facades\Crypt::encryptString($value),
            ]
        );
    }

    /**
     * Get the PCB board that the image belongs to.
     */
    public function pcbRelationship()
    {
        return $this->belongsTo(PcbTable::class, 'PCB_Number', 'idx');
    }
}

