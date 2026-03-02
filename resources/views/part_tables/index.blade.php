
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('PartTable Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-white">PartTable List</h3>
                        <p class="mt-1 text-sm text-gray-400">개별 보드에 부착될 저항, IC 칩 등 자재 스펙과 제조사 명칭, 모델별 소요 수량(BOM)을 명세합니다.</p>
                        </div>
                        <a href="{{ route('part_tables.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium transition">
                            Create New
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    <th scope="col" class="px-6 py-3">Part_Number</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">PCB_Number</th>
                                    <th scope="col" class="px-6 py-3">Process_Class</th>
                                    <th scope="col" class="px-6 py-3">Process_Name</th>
                                    <th scope="col" class="px-6 py-3">Process_Detail</th>
                                    <th scope="col" class="px-6 py-3">Side</th>
                                    <th scope="col" class="px-6 py-3">Image_File</th>
                                    <th scope="col" class="px-6 py-3">Quantity</th>
                                    <th scope="col" class="px-6 py-3">Location_1</th>
                                    <th scope="col" class="px-6 py-3">Location_2</th>
                                    <th scope="col" class="px-6 py-3">Location_3</th>
                                    <th scope="col" class="px-6 py-3">Location_4</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($part_tables as $item)
                                    <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                                        <td class="px-6 py-4 font-medium text-white">{{ $item->idx ?? $item->id }}</td>
                                        <td class="px-6 py-4">{{ $item->Part_Number }}</td>
                                        <td class="px-6 py-4">{{ $item->Name }}</td>
                                        <td class="px-6 py-4">{{ $item->PCB_Number }}</td>
                                        <td class="px-6 py-4">{{ $item->Process_Class }}</td>
                                        <td class="px-6 py-4">{{ $item->Process_Name }}</td>
                                        <td class="px-6 py-4">{{ $item->Process_Detail }}</td>
                                        <td class="px-6 py-4">{{ $item->Side }}</td>
                                        <td class="px-6 py-4">{{ $item->Image_File }}</td>
                                        <td class="px-6 py-4">{{ $item->Quantity }}</td>
                                        <td class="px-6 py-4">{{ $item->Location_1 }}</td>
                                        <td class="px-6 py-4">{{ $item->Location_2 }}</td>
                                        <td class="px-6 py-4">{{ $item->Location_3 }}</td>
                                        <td class="px-6 py-4">{{ $item->Location_4 }}</td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="{{ route('part_tables.show', $item->idx ?? $item->id) }}" class="font-medium text-blue-400 hover:text-blue-300">View</a>
                                            <a href="{{ route('part_tables.edit', $item->idx ?? $item->id) }}" class="font-medium text-indigo-400 hover:text-indigo-300">Edit</a>
                                            <form action="{{ route('part_tables.destroy', $item->idx ?? $item->id) }}" method="POST" class="inline">
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
                        {{ $part_tables->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
