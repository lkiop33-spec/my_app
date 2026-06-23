<?php

namespace App\Http\Controllers;

use App\Models\PcbImageTable;
use App\Models\PcbTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        $pcbs = PcbTable::all();
        return view('pcb_image_tables.create', compact('pcbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'PCB_Number' => 'required|exists:pcb_tables,idx',
            'Image' => 'required|file|image|mimes:png,jpg,jpeg|max:10240',
            'BoundBox' => 'nullable|string|max:100',
            'Other' => 'nullable|string|max:100',
        ]);

        $data = $request->all();
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            $uploadsPath = public_path('uploads');
            if (!File::isDirectory($uploadsPath)) {
                File::makeDirectory($uploadsPath, 0755, true, true);
            }
            
            $file->move($uploadsPath, $filename);
            $data['Image'] = $filename;
        }

        PcbImageTable::create($data);
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
        $pcbs = PcbTable::all();
        return view('pcb_image_tables.edit', compact('pcbImageTable', 'pcbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pcbImageTable = PcbImageTable::findOrFail($id);

        $request->validate([
            'PCB_Number' => 'required|exists:pcb_tables,idx',
            'Image' => 'nullable|file|image|mimes:png,jpg,jpeg|max:10240',
            'BoundBox' => 'nullable|string|max:100',
            'Other' => 'nullable|string|max:100',
        ]);

        $data = $request->all();
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            $uploadsPath = public_path('uploads');
            if (!File::isDirectory($uploadsPath)) {
                File::makeDirectory($uploadsPath, 0755, true, true);
            }
            
            $file->move($uploadsPath, $filename);
            
            // Delete old file
            if ($pcbImageTable->Image && File::exists($uploadsPath . '/' . $pcbImageTable->Image)) {
                File::delete($uploadsPath . '/' . $pcbImageTable->Image);
            }
            
            $data['Image'] = $filename;
        } else {
            unset($data['Image']);
        }

        $pcbImageTable->update($data);
        return redirect()->route('pcb_image_tables.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pcbImageTable = PcbImageTable::findOrFail($id);
        
        $uploadsPath = public_path('uploads');
        if ($pcbImageTable->Image && File::exists($uploadsPath . '/' . $pcbImageTable->Image)) {
            File::delete($uploadsPath . '/' . $pcbImageTable->Image);
        }

        $pcbImageTable->delete();
        return redirect()->route('pcb_image_tables.index')->with('success', 'Deleted successfully.');
    }
}
