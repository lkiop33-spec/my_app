
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('PcbImageTable Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-white">PcbImageTable List</h3>
                        <p class="mt-1 text-sm text-gray-400">불량 판독이나 AI 모델 비전 학습용으로 업로드된 기판 외관 이미지 및 검수 객체 좌표 정보입니다.</p>
                        </div>
                        <a href="{{ route('pcb_image_tables.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium transition">
                            Create New
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    <th scope="col" class="px-6 py-3">PCB_Number</th>
                                    <th scope="col" class="px-6 py-3">Image</th>
                                    <th scope="col" class="px-6 py-3">BoundBox</th>
                                    <th scope="col" class="px-6 py-3">Other</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pcb_image_tables as $item)
                                    <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                                        <td class="px-6 py-4 font-medium text-white">{{ $item->idx ?? $item->id }}</td>
                                        <td class="px-6 py-4">{{ $item->PCB_Number }}</td>
                                        <td class="px-6 py-4">{{ $item->Image }}</td>
                                        <td class="px-6 py-4">{{ $item->BoundBox }}</td>
                                        <td class="px-6 py-4">{{ $item->Other }}</td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="{{ route('pcb_image_tables.show', $item->idx ?? $item->id) }}" class="font-medium text-blue-400 hover:text-blue-300">View</a>
                                            <a href="{{ route('pcb_image_tables.edit', $item->idx ?? $item->id) }}" class="font-medium text-indigo-400 hover:text-indigo-300">Edit</a>
                                            <form action="{{ route('pcb_image_tables.destroy', $item->idx ?? $item->id) }}" method="POST" class="inline">
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
                        {{ $pcb_image_tables->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
