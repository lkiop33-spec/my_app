<?php

namespace App\Http\Controllers;

use App\Models\PcbImageTable;
use Illuminate\Http\Request;

class PcbImageTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pcb_image_tables = PcbImageTable::paginate(10);
        return view('pcb_image_tables.index', compact('pcb_image_tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pcb_image_tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        PcbImageTable::create($request->all());
        return redirect()->route('pcb_image_tables.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pcbImageTable = PcbImageTable::findOrFail($id);
        return view('pcb_image_tables.show', compact('pcbImageTable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pcbImageTable = PcbImageTable::findOrFail($id);
        return view('pcb_image_tables.edit', compact('pcbImageTable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pcbImageTable = PcbImageTable::findOrFail($id);
        $pcbImageTable->update($request->all());
        return redirect()->route('pcb_image_tables.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pcbImageTable = PcbImageTable::findOrFail($id);
        $pcbImageTable->delete();
        return redirect()->route('pcb_image_tables.index')->with('success', 'Deleted successfully.');
    }
}
