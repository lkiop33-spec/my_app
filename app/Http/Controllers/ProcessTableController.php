<?php

namespace App\Http\Controllers;

use App\Models\ProcessTable;
use Illuminate\Http\Request;

class ProcessTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $process_tables = ProcessTable::paginate(10);
        return view('process_tables.index', compact('process_tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('process_tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ProcessTable::create($request->all());
        return redirect()->route('process_tables.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $processTable = ProcessTable::findOrFail($id);
        return view('process_tables.show', compact('processTable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $processTable = ProcessTable::findOrFail($id);
        return view('process_tables.edit', compact('processTable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $processTable = ProcessTable::findOrFail($id);
        $processTable->update($request->all());
        return redirect()->route('process_tables.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $processTable = ProcessTable::findOrFail($id);
        $processTable->delete();
        return redirect()->route('process_tables.index')->with('success', 'Deleted successfully.');
    }
}
