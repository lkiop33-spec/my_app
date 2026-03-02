const fs = require('fs');
const path = require('path');

const models = [
    'Location', 'Part', 'Level', 'WorkList', 'PcbTable', 'PartTable',
    'ProcessTable', 'PcbImageTable', 'DocList', 'Type', 'Language',
    'Forbidden', 'Device'
];

const viewsBasePath = path.join(__dirname, 'resources/views');

const headersMap = {
    'Location': ['name', 'address', 'phone'],
    'Part': ['name', 'level'],
    'Level': ['name', 'level'],
    'WorkList': ['partList', 'pcbIDX', 'memberIDX'],
    'PcbTable': ['PCB_Number', 'Name_Type', 'Image_File', 'Image_Side'],
    'PartTable': ['Part_Number', 'Name', 'PCB_Number', 'Process_Class', 'Process_Name', 'Process_Detail', 'Side', 'Image_File', 'Quantity', 'Location_1', 'Location_2', 'Location_3', 'Location_4'],
    'ProcessTable': ['Code', 'Name', 'Class', 'Sequence'],
    'PcbImageTable': ['PCB_Number', 'Image', 'BoundBox', 'Other'],
    'DocList': ['type', 'name', 'filename', 'path', 'language', 'reference'],
    'Type': ['mtype'],
    'Language': ['mlanguage'],
    'Forbidden': ['text'],
    'Device': ['name', 'password', 'location', 'version']
};

const getIndexTemplate = (modelName, pluralVar, headers) => `
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('${modelName} Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-white">${modelName} List</h3>
                        <a href="{{ route('${pluralVar}.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium transition">
                            Create New
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    ${headers.map(h => `<th scope="col" class="px-6 py-3">${h}</th>`).join('\n                                    ')}
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($${pluralVar} as $item)
                                    <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                                        <td class="px-6 py-4 font-medium text-white">{{ $item->idx ?? $item->id }}</td>
                                        ${headers.map(h => `<td class="px-6 py-4">{{ $item->${h} }}</td>`).join('\n                                        ')}
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="{{ route('${pluralVar}.show', $item->idx ?? $item->id) }}" class="font-medium text-blue-400 hover:text-blue-300">View</a>
                                            <a href="{{ route('${pluralVar}.edit', $item->idx ?? $item->id) }}" class="font-medium text-indigo-400 hover:text-indigo-300">Edit</a>
                                            <form action="{{ route('${pluralVar}.destroy', $item->idx ?? $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-500 hover:text-red-400" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $${pluralVar}->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
`;

const getFormTemplate = (modelName, snakeCaseModel, action, headers, method = 'POST') => `
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('${action === 'create' ? 'Create' : 'Edit'} ${modelName}') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ ${action === 'create' ? `route('${snakeCaseModel}.store')` : `route('${snakeCaseModel}.update', $item->idx ?? $item->id)`} }}" class="space-y-6">
                        @csrf
                        ${method === 'PUT' ? '@method("PUT")' : ''}
                        
                        ${headers.map(h => `
                        <div>
                            <x-input-label for="${h}" value="${h.replace(/_/g, ' ')}" class="text-gray-300" />
                            <x-text-input id="${h}" name="${h}" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('${h}', ${action === 'edit' ? `$item->${h}` : "''"}) }}" />
                        </div>`).join('\n                        ')}
                        
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('${snakeCaseModel}.index') }}" class="text-gray-400 hover:text-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
`;

const getShowTemplate = (modelName, snakeCaseModel, headers) => `
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('View ${modelName}') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-white">${modelName} Details</h3>
                        <p class="mt-1 text-sm text-gray-400">Detailed information.</p>
                    </div>
                    
                    <div class="border-t border-gray-700">
                        <dl>
                            <div class="bg-gray-900/50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">ID</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $item->idx ?? $item->id }}</dd>
                            </div>
                            <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">Created At</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ clone $item->wdate ?? $item->created_at }}</dd>
                            </div>
                            ${headers.map((h, index) => `
                            <div class="${index % 2 === 0 ? 'bg-gray-900/50' : 'bg-gray-800'} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">${h.replace(/_/g, ' ')}</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $item->${h} }}</dd>
                            </div>`).join('')}
                        </dl>
                    </div>
                    
                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('${snakeCaseModel}.edit', $item->idx ?? $item->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium transition">Edit</a>
                        <a href="{{ route('${snakeCaseModel}.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md text-white font-medium transition border border-gray-600">Back HTMLList</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
`;

models.forEach(model => {
    const snakeCaseModel = model.replace(/[A-Z]/g, letter => `_${letter.toLowerCase()}`).replace(/^_/, '') + 's';
    const folderPath = path.join(viewsBasePath, snakeCaseModel);

    if (!fs.existsSync(folderPath)) {
        fs.mkdirSync(folderPath, { recursive: true });
    }

    const headers = headersMap[model] || ['name'];

    fs.writeFileSync(path.join(folderPath, 'index.blade.php'), getIndexTemplate(model, snakeCaseModel, headers));
    fs.writeFileSync(path.join(folderPath, 'create.blade.php'), getFormTemplate(model, snakeCaseModel, 'create', headers));
    fs.writeFileSync(path.join(folderPath, 'edit.blade.php'), getFormTemplate(model, snakeCaseModel, 'edit', headers, 'PUT'));
    fs.writeFileSync(path.join(folderPath, 'show.blade.php'), getShowTemplate(model, snakeCaseModel, headers));

    console.log(`Generated views for ${model}`);
});
