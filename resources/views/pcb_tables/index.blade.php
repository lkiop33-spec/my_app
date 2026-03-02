
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('PcbTable Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-white">PcbTable List</h3>
                        <p class="mt-1 text-sm text-gray-400">조립 대상이 되는 핵심 모델 기판(예: ECU 파워보드 등)의 이름과 가로/세로 기본 제원 스펙을 보관합니다.</p>
                        </div>
                        <a href="{{ route('pcb_tables.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium transition">
                            Create New
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    <th scope="col" class="px-6 py-3">PCB_Number</th>
                                    <th scope="col" class="px-6 py-3">Name_Type</th>
                                    <th scope="col" class="px-6 py-3">Image_File</th>
                                    <th scope="col" class="px-6 py-3">Image_Side</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pcb_tables as $item)
                                    <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                                        <td class="px-6 py-4 font-medium text-white">{{ $item->idx ?? $item->id }}</td>
                                        <td class="px-6 py-4">{{ $item->PCB_Number }}</td>
                                        <td class="px-6 py-4">{{ $item->Name_Type }}</td>
                                        <td class="px-6 py-4">{{ $item->Image_File }}</td>
                                        <td class="px-6 py-4">{{ $item->Image_Side }}</td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="{{ route('pcb_tables.show', $item->idx ?? $item->id) }}" class="font-medium text-blue-400 hover:text-blue-300">View</a>
                                            <a href="{{ route('pcb_tables.edit', $item->idx ?? $item->id) }}" class="font-medium text-indigo-400 hover:text-indigo-300">Edit</a>
                                            <form action="{{ route('pcb_tables.destroy', $item->idx ?? $item->id) }}" method="POST" class="inline">
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
                        {{ $pcb_tables->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
