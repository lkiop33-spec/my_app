<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DocList;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class DocImageApiController extends Controller
{
    /**
     * Display a listing of document images (filtered by image extensions and physical existence).
     */
    public function index(): JsonResponse
    {
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'webp'];

        $docImages = DocList::with(['typeRelationship', 'languageRelationship'])->get()
            ->filter(function ($item) use ($allowedExtensions) {
                if (empty($item->filename)) {
                    return false;
                }
                $ext = strtolower(pathinfo($item->filename, PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExtensions)) {
                    return false;
                }
                return File::exists(public_path('uploads/' . $item->filename));
            })
            ->map(function ($item) {
                return [
                    'id' => $item->idx ?? $item->id,
                    'type' => $item->type,
                    'type_name' => $item->typeRelationship?->mtype ?? 'N/A',
                    'name' => $item->name,
                    'filename' => $item->filename,
                    'image_url' => url('/api/image/doc/' . $item->filename),
                    'language' => $item->language,
                    'language_name' => $item->languageRelationship?->mlanguage ?? 'N/A',
                    'reference' => $item->reference,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            })
            ->values();

        return response()->json($docImages, 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
