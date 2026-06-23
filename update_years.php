<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Post;
use App\Models\Notice;

$postsUpdated = 0;
Post::where('created_at', 'like', '2026-%')->get()->each(function($post) use (&$postsUpdated) {
    $post->timestamps = false;
    $post->created_at = str_replace('2026-', '2025-', $post->created_at);
    if ($post->updated_at) {
        $post->updated_at = str_replace('2026-', '2025-', $post->updated_at);
    }
    $post->save();
    $postsUpdated++;
});

$noticesUpdated = 0;
Notice::where('created_at', 'like', '2026-%')->get()->each(function($notice) use (&$noticesUpdated) {
    $notice->timestamps = false;
    $notice->created_at = str_replace('2026-', '2025-', $notice->created_at);
    if ($notice->updated_at) {
        $notice->updated_at = str_replace('2026-', '2025-', $notice->updated_at);
    }
    $notice->save();
    $noticesUpdated++;
});

echo "Updated $postsUpdated posts and $noticesUpdated notices from 2026 to 2025.\n";
