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
        'partList_enc',
        'pcbIDX',
        'memberIDX',
    ];

    protected function partList(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value, $attributes) {
                if (!empty($attributes['partList_enc'])) {
                    try {
                        return \Illuminate\Support\Facades\Crypt::decryptString($attributes['partList_enc']);
                    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                        return '*** DECRYPTION ERROR ***';
                    }
                }
                return $value;
            },
            set: fn ($value) => [
                'partList' => '*** ENCRYPTED ***',
                'partList_enc' => \Illuminate\Support\Facades\Crypt::encryptString($value),
            ]
        );
    }
}
