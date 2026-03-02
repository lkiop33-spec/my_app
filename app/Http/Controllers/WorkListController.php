<?php

namespace App\Http\Controllers;

use App\Models\WorkList;
use Illuminate\Http\Request;

class WorkListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $work_lists = WorkList::paginate(10);
        return view('work_lists.index', compact('work_lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('work_lists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        WorkList::create($request->all());
        return redirect()->route('work_lists.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $workList = WorkList::findOrFail($id);
        return view('work_lists.show', compact('workList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $workList = WorkList::findOrFail($id);
        return view('work_lists.edit', compact('workList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $workList = WorkList::findOrFail($id);
        $workList->update($request->all());
        return redirect()->route('work_lists.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $workList = WorkList::findOrFail($id);
        $workList->delete();
        return redirect()->route('work_lists.index')->with('success', 'Deleted successfully.');
    }
}
