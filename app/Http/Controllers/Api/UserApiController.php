<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    /**
     * Display a listing of all users names.
     */
    public function index(): JsonResponse
    {
        $users = User::select('id', 'name', 'nickname')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'display_name' => $user->display_name,
            ];
        });

        return response()->json($users);
    }
}
