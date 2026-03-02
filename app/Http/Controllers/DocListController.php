<?php

namespace App\Http\Controllers;

use App\Models\DocList;
use Illuminate\Http\Request;

class DocListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doc_lists = DocList::paginate(10);
        return view('doc_lists.index', compact('doc_lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doc_lists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DocList::create($request->all());
        return redirect()->route('doc_lists.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $docList = DocList::findOrFail($id);
        return view('doc_lists.show', compact('docList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $docList = DocList::findOrFail($id);
        return view('doc_lists.edit', compact('docList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $docList = DocList::findOrFail($id);
        $docList->update($request->all());
        return redirect()->route('doc_lists.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $docList = DocList::findOrFail($id);
        $docList->delete();
        return redirect()->route('doc_lists.index')->with('success', 'Deleted successfully.');
    }
}
