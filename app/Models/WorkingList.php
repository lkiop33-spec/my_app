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
            $limit = 1000;
            $count = self::count();
            if ($count > $limit) {
                // 최신 1000개 데이터의 ID만 유지하고, 나머지는 삭제
                $keepIds = self::latest('id')->take($limit)->pluck('id');
                self::whereNotIn('id', $keepIds)->delete();
            }
        });
    }
}
