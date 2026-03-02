const fs = require('fs');
const path = require('path');

const models = [
    'Location', 'Part', 'Level', 'WorkList', 'PcbTable', 'PartTable',
    'ProcessTable', 'PcbImageTable', 'DocList', 'Type', 'Language',
    'Forbidden', 'Device'
];

const controllersPath = path.join(__dirname, 'app/Http/Controllers');
const viewsBasePath = path.join(__dirname, 'resources/views');

models.forEach(model => {
    const controllerName = `${model}Controller`;
    const controllerPath = path.join(controllersPath, `${controllerName}.php`);

    // Convert CamelCase to snake_case for views folder and route names
    const snakeCaseModel = model.replace(/[A-Z]/g, letter => `_${letter.toLowerCase()}`).replace(/^_/, '') + 's';
    const variableName = model.charAt(0).toLowerCase() + model.slice(1);
    const variableNamePlural = snakeCaseModel;

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
        $${variableNamePlural} = ${model}::paginate(10);
        return view('${snakeCaseModel}.index', compact('${variableNamePlural}'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('${snakeCaseModel}.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ${model}::create($request->all());
        return redirect()->route('${snakeCaseModel}.index')->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $${variableName} = ${model}::findOrFail($id);
        return view('${snakeCaseModel}.show', compact('${variableName}'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $${variableName} = ${model}::findOrFail($id);
        return view('${snakeCaseModel}.edit', compact('${variableName}'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $${variableName} = ${model}::findOrFail($id);
        $${variableName}->update($request->all());
        return redirect()->route('${snakeCaseModel}.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $${variableName} = ${model}::findOrFail($id);
        $${variableName}->delete();
        return redirect()->route('${snakeCaseModel}.index')->with('success', 'Deleted successfully.');
    }
}
`;

    fs.writeFileSync(controllerPath, content);
    console.log(`Updated Web Controller: ${controllerName}`);
});
