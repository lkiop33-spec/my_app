<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = Level::paginate(10);
        return view('levels.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Level::create($request->all());
        return redirect()->route('levels.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $level = Level::findOrFail($id);
        return view('levels.show', compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $level = Level::findOrFail($id);
        return view('levels.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $level = Level::findOrFail($id);
        $level->update($request->all());
        return redirect()->route('levels.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $level = Level::findOrFail($id);
        $level->delete();
        return redirect()->route('levels.index')->with('success', 'Deleted successfully.');
    }
}
