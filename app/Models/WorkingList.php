<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'worker_name',
        'text',
        'datetime',
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::created(function ($workingList) {
            $limit = 300; // 데이터 보관 한도 축소 (1000 -> 300)
            // 최신 N개 경계에 있는 레코드를 조회
            $boundary = self::latest('id')->skip($limit - 1)->first();
            if ($boundary) {
                // 경계 레코드 ID보다 오래된 모든 데이터를 즉시 일괄 삭제 (성능 개선)
                self::where('id', '<', $boundary->id)->delete();
            }
        });
    }
}
