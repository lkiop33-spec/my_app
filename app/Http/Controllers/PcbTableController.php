<?php

namespace App\Http\Controllers;

use App\Models\PcbTable;
use Illuminate\Http\Request;

class PcbTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pcb_tables = PcbTable::paginate(10);
        return view('pcb_tables.index', compact('pcb_tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pcb_tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        PcbTable::create($request->all());
        return redirect()->route('pcb_tables.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pcbTable = PcbTable::findOrFail($id);
        return view('pcb_tables.show', compact('pcbTable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pcbTable = PcbTable::findOrFail($id);
        return view('pcb_tables.edit', compact('pcbTable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pcbTable = PcbTable::findOrFail($id);
        $pcbTable->update($request->all());
        return redirect()->route('pcb_tables.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pcbTable = PcbTable::findOrFail($id);
        $pcbTable->delete();
        return redirect()->route('pcb_tables.index')->with('success', 'Deleted successfully.');
    }
}
