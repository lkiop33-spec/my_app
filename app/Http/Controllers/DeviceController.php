<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = Device::paginate(10);
        return view('devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        return view('devices.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20|unique:devices,name',
            'password' => 'required|string|max:20|unique:devices,password',
            'location' => 'required|exists:locations,idx',
            'version' => 'required|string|max:20',
        ]);

        Device::create($request->all());
        return redirect()->route('devices.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $device = Device::findOrFail($id);
        return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $device = Device::findOrFail($id);
        $locations = Location::all();
        return view('devices.edit', compact('device', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:20|unique:devices,name,' . $device->idx . ',idx',
            'password' => 'required|string|max:20|unique:devices,password,' . $device->idx . ',idx',
            'location' => 'required|exists:locations,idx',
            'version' => 'required|string|max:20',
        ]);

        $device->update($request->all());
        return redirect()->route('devices.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Deleted successfully.');
    }
}
