<?php

namespace App\Http\Controllers;

use App\Models\Geade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::latest()->get();
        $geades = Geade::all();

        return view('users.index', compact('users', 'geades'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    /**
     * Update the user's rank.
     */
    public function updateRank(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'rank_type' => 'nullable|string|exists:geades,rank_type',
        ]);

        $user->update(['rank_type' => $validated['rank_type'] ?? null]);

        return redirect()->back()->with('status', '직급이 수정되었습니다.');
    }
}
