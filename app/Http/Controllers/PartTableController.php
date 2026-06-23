<?php

namespace App\Http\Controllers;

use App\Models\PartTable;
use App\Models\PcbTable;
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
        $pcbs = PcbTable::all();
        return view('part_tables.create', compact('pcbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Part_Number' => 'required|string|max:20|unique:part_tables,Part_Number',
            'Name' => 'required|string|max:100',
            'PCB_Number' => 'required|exists:pcb_tables,idx',
            'Process_Class' => 'nullable|string|max:100',
            'Process_Name' => 'nullable|string|max:100',
            'Process_Detail' => 'nullable|string|max:100|unique:part_tables,Process_Detail',
            'Side' => 'nullable|string|max:100',
            'Image_File' => 'nullable|string|max:100',
            'Quantity' => 'nullable|string|max:100',
            'Location_1' => 'nullable|string|max:100',
            'Location_2' => 'nullable|string|max:100',
            'Location_3' => 'nullable|string|max:100',
            'Location_4' => 'nullable|string|max:100',
        ]);

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
        $pcbs = PcbTable::all();
        return view('part_tables.edit', compact('partTable', 'pcbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $partTable = PartTable::findOrFail($id);

        $request->validate([
            'Part_Number' => 'required|string|max:20|unique:part_tables,Part_Number,' . $partTable->idx . ',idx',
            'Name' => 'required|string|max:100',
            'PCB_Number' => 'required|exists:pcb_tables,idx',
            'Process_Class' => 'nullable|string|max:100',
            'Process_Name' => 'nullable|string|max:100',
            'Process_Detail' => 'nullable|string|max:100|unique:part_tables,Process_Detail,' . $partTable->idx . ',idx',
            'Side' => 'nullable|string|max:100',
            'Image_File' => 'nullable|string|max:100',
            'Quantity' => 'nullable|string|max:100',
            'Location_1' => 'nullable|string|max:100',
            'Location_2' => 'nullable|string|max:100',
            'Location_3' => 'nullable|string|max:100',
            'Location_4' => 'nullable|string|max:100',
        ]);

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
