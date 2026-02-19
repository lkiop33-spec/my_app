<?php

namespace App\Http\Controllers;

use App\Models\Geade;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GeadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $geades = Geade::latest()->get();
        return view('geade', compact('geades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rank_type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Geade::create($validated);

        return redirect()->route('geades.index')->with('status', '직급이 추가되었습니다.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Geade $geade): RedirectResponse
    {
        $geade->delete();

        return redirect()->route('geades.index')->with('status', '직급이 삭제되었습니다.');
    }
}
