<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    /**
     * Display a listing of all users with full information.
     */
    public function index(): JsonResponse
    {
        $users = User::with('departmentRel')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'display_name' => $user->display_name,
                'email' => $user->email,
                'rank_type' => $user->rank_type,
                'department_id' => $user->department_id,
                'department_name' => $user->departmentRel?->name ?? $user->department ?? 'N/A',
                'joined_at' => $user->joined_at ? $user->joined_at->format('Y-m-d') : null,
                'last_login_at' => $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : null,
                'birth_date' => $user->birth_date,
                'location' => $user->location,
                'part' => $user->part,
                'account_id' => $user->account_id,
                'last_access' => $user->last_access,
                'level' => $user->level,
                'phone' => $user->phone,
                'interphone' => $user->interphone,
                'photo' => $user->photo,
                'join_date' => $user->join_date,
                'created_at' => $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : null,
                'updated_at' => $user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : null,
            ];
        });

        return response()->json($users, 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
