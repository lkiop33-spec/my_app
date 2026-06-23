<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PcbImageTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class PcbImageApiController extends Controller
{
    /**
     * Display a listing of PCB images which are not empty and exist physically.
     */
    public function index(): JsonResponse
    {
        $images = PcbImageTable::with('pcbRelationship')->get()
            ->filter(function($item) {
                if (empty($item->Image)) {
                    return false;
                }
                return File::exists(public_path('uploads/' . $item->Image));
            })
            ->map(function($item) {
                return [
                    'id' => $item->idx ?? $item->id,
                    'pcb_idx' => $item->PCB_Number,
                    'pcb_number' => $item->pcbRelationship?->PCB_Number ?? 'N/A',
                    'pcb_name_type' => $item->pcbRelationship?->Name_Type ?? 'N/A',
                    'filename' => $item->Image,
                    'image_url' => url('/api/image/pcb/' . $item->Image),
                    'bound_box' => $item->BoundBox,
                    'other' => $item->Other,
                    'created_at' => $item->wdate ?? $item->created_at,
                ];
            })->values();

        return response()->json($images, 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
