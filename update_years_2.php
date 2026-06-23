<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Geade;
use App\Models\Level;
use App\Models\User;
use App\Models\Department;

// 1. Geade (직급)
$geadesUpdated = 0;
Geade::where('created_at', 'like', '2026-%')->get()->each(function($item) use (&$geadesUpdated) {
    $item->timestamps = false;
    $item->created_at = str_replace('2026-', '2025-', $item->created_at);
    if ($item->updated_at) {
        $item->updated_at = str_replace('2026-', '2025-', $item->updated_at);
    }
    $item->save();
    $geadesUpdated++;
});

// 2. Level (권한/등급)
$levelsUpdated = 0;
Level::where('created_at', 'like', '2026-%')->get()->each(function($item) use (&$levelsUpdated) {
    $item->timestamps = false;
    $item->created_at = str_replace('2026-', '2025-', $item->created_at);
    if ($item->updated_at) {
        $item->updated_at = str_replace('2026-', '2025-', $item->updated_at);
    }
    $item->save();
    $levelsUpdated++;
});

// 3. Department (부서)
$departmentsUpdated = 0;
Department::where('created_at', 'like', '2026-%')->get()->each(function($item) use (&$departmentsUpdated) {
    $item->timestamps = false;
    $item->created_at = str_replace('2026-', '2025-', $item->created_at);
    if ($item->updated_at) {
        $item->updated_at = str_replace('2026-', '2025-', $item->updated_at);
    }
    $item->save();
    $departmentsUpdated++;
});

// 4. User (사용자)
$usersUpdated = 0;
User::where('created_at', 'like', '2026-%')
    ->orWhere('joined_at', 'like', '2026-%')
    ->orWhere('join_date', 'like', '2026-%')
    ->get()->each(function($item) use (&$usersUpdated) {
        $item->timestamps = false;
        
        if (strpos($item->created_at, '2026-') === 0) {
            $item->created_at = str_replace('2026-', '2025-', $item->created_at);
        }
        if ($item->updated_at && strpos($item->updated_at, '2026-') === 0) {
            $item->updated_at = str_replace('2026-', '2025-', $item->updated_at);
        }
        if ($item->joined_at && strpos($item->joined_at, '2026-') === 0) {
            $item->joined_at = str_replace('2026-', '2025-', $item->joined_at);
        }
        if ($item->join_date && strpos($item->join_date, '2026-') === 0) {
            $item->join_date = str_replace('2026-', '2025-', $item->join_date);
        }
        
        $item->save();
        $usersUpdated++;
    });

echo "Updated $geadesUpdated geades, $levelsUpdated levels, $departmentsUpdated departments, $usersUpdated users from 2026 to 2025.\n";
