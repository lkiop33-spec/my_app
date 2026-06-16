<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\WorkingList;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 기존 UTC로 저장된 데이터들에 9시간을 더하여 KST(한국시간)로 보정합니다.
        $items = WorkingList::all();
        foreach ($items as $item) {
            if ($item->datetime) {
                $item->datetime = $item->datetime->addHours(9);
            }
            if ($item->created_at) {
                $item->created_at = $item->created_at->addHours(9);
            }
            if ($item->updated_at) {
                $item->updated_at = $item->updated_at->addHours(9);
            }
            $item->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $items = WorkingList::all();
        foreach ($items as $item) {
            if ($item->datetime) {
                $item->datetime = $item->datetime->subHours(9);
            }
            if ($item->created_at) {
                $item->created_at = $item->created_at->subHours(9);
            }
            if ($item->updated_at) {
                $item->updated_at = $item->updated_at->subHours(9);
            }
            $item->save();
        }
    }
};
