<?php

namespace App\Http\Controllers;

use App\Models\PartTable;
use Illuminate\Http\Request;

class PartTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $part_tables = PartTable::paginate(10);
        return view('part_tables.index', compact('part_tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('part_tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        PartTable::create($request->all());
        return redirect()->route('part_tables.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $partTable = PartTable::findOrFail($id);
        return view('part_tables.show', compact('partTable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $partTable = PartTable::findOrFail($id);
        return view('part_tables.edit', compact('partTable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $partTable = PartTable::findOrFail($id);
        $partTable->update($request->all());
        return redirect()->route('part_tables.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $partTable = PartTable::findOrFail($id);
        $partTable->delete();
        return redirect()->route('part_tables.index')->with('success', 'Deleted successfully.');
    }
}
