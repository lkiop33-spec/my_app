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
        'Name_Type_enc',
        'Image_File',
        'Image_File_enc',
        'Image_Side',
    ];

    protected function NameType(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value, $attributes) {
                if (!empty($attributes['Name_Type_enc'])) {
                    try {
                        return \Illuminate\Support\Facades\Crypt::decryptString($attributes['Name_Type_enc']);
                    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                        return '*** DECRYPTION ERROR ***';
                    }
                }
                return $value;
            },
            set: fn ($value) => [
                'Name_Type' => '*** ENCRYPTED ***',
                'Name_Type_enc' => \Illuminate\Support\Facades\Crypt::encryptString($value),
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
                'Image_File' => '*** ENCRYPTED ***',
                'Image_File_enc' => \Illuminate\Support\Facades\Crypt::encryptString($value),
            ]
        );
    }
}
