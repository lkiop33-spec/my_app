<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\JsonResponse;

class ImageServeApiController extends Controller
{
    /**
     * Serve the requested image file.
     *
     * @param string $type
     * @param string $filename
     * @return BinaryFileResponse|JsonResponse
     */
    public function show(string $type, string $filename)
    {
        // Validate type (must be either 'pcb' or 'doc')
        if (!in_array($type, ['pcb', 'doc'])) {
            return response()->json([
                'error' => 'Invalid image type.'
            ], 400, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // Both pcb and doc files are stored in public/uploads (as per requirements and controller logs)
        $path = public_path('uploads/' . $filename);

        if (!File::exists($path) || !File::isFile($path)) {
            return response()->json([
                'error' => 'Image not found.'
            ], 404, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // Return file response
        return response()->file($path);
    }
}
