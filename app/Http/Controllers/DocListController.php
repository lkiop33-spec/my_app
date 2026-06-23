<?php

namespace App\Http\Controllers;

use App\Models\DocList;
use App\Models\Type;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        $types = Type::all();
        $languages = Language::all();
        return view('doc_lists.create', compact('types', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|exists:types,idx',
            'name' => 'required|string|max:10|unique:doc_lists,name',
            'doc_file' => 'required|file|max:10240',
            'language' => 'nullable|exists:languages,idx',
            'reference' => 'nullable|string|max:20',
        ]);

        $data = $request->except('doc_file');
        
        if ($request->hasFile('doc_file')) {
            $file = $request->file('doc_file');
            // Strict 20-character filename limit validation: 10 random characters + extension (approx 15 chars total)
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'uploads';

            $uploadsPath = public_path($path);
            if (!File::isDirectory($uploadsPath)) {
                File::makeDirectory($uploadsPath, 0755, true, true);
            }

            $file->move($uploadsPath, $filename);
            
            $data['filename'] = $filename;
            $data['path'] = $path;
        }

        DocList::create($data);
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
        $types = Type::all();
        $languages = Language::all();
        return view('doc_lists.edit', compact('docList', 'types', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $docList = DocList::findOrFail($id);

        $request->validate([
            'type' => 'required|exists:types,idx',
            'name' => 'required|string|max:10|unique:doc_lists,name,' . $docList->idx . ',idx',
            'doc_file' => 'nullable|file|max:10240',
            'language' => 'nullable|exists:languages,idx',
            'reference' => 'nullable|string|max:20',
        ]);

        $data = $request->except('doc_file');

        if ($request->hasFile('doc_file')) {
            $file = $request->file('doc_file');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'uploads';

            $uploadsPath = public_path($path);
            if (!File::isDirectory($uploadsPath)) {
                File::makeDirectory($uploadsPath, 0755, true, true);
            }

            $file->move($uploadsPath, $filename);

            // Delete old file
            if ($docList->filename && $docList->path && File::exists(public_path($docList->path . '/' . $docList->filename))) {
                File::delete(public_path($docList->path . '/' . $docList->filename));
            }

            $data['filename'] = $filename;
            $data['path'] = $path;
        }

        $docList->update($data);
        return redirect()->route('doc_lists.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $docList = DocList::findOrFail($id);
        
        if ($docList->filename && $docList->path && File::exists(public_path($docList->path . '/' . $docList->filename))) {
            File::delete(public_path($docList->path . '/' . $docList->filename));
        }

        $docList->delete();
        return redirect()->route('doc_lists.index')->with('success', 'Deleted successfully.');
    }
}
