const fs = require('fs');
const path = require('path');

const models = [
    'Location', 'Part', 'Level', 'WorkList', 'PcbTable', 'PartTable',
    'ProcessTable', 'PcbImageTable', 'DocList', 'Type', 'Language',
    'Forbidden', 'Device'
];

const controllersPath = path.join(__dirname, 'app/Http/Controllers');

models.forEach(model => {
    const controllerName = `${model}Controller`;
    const controllerPath = path.join(controllersPath, `${controllerName}.php`);

    // Check if controller exists
    if (!fs.existsSync(controllerPath)) {
        console.log(`Controller not found: ${controllerName}`);
        return;
    }

    const variableName = model.charAt(0).toLowerCase() + model.slice(1);

    let content = `<?php

namespace App\\Http\\Controllers;

use App\\Models\\${model};
use Illuminate\\Http\\Request;

class ${controllerName} extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(${model}::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Add basic validation if needed, keeping it simple for now
        $${variableName} = ${model}::create($request->all());
        return response()->json($${variableName}, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $${variableName} = ${model}::find($id);
        if (!$${variableName}) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($${variableName});
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $${variableName} = ${model}::find($id);
        if (!$${variableName}) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $${variableName}->update($request->all());
        return response()->json($${variableName});
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $${variableName} = ${model}::find($id);
        if (!$${variableName}) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $${variableName}->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
`;

    fs.writeFileSync(controllerPath, content);
    console.log(`Updated ${controllerName}`);
});
