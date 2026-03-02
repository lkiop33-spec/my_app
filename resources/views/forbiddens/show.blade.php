
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('View Forbidden') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-white">Forbidden Details</h3>
                        <p class="mt-1 text-sm text-gray-400">Detailed information.</p>
                    </div>
                    
                    <div class="border-t border-gray-700">
                        <dl>
                            <div class="bg-gray-900/50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">ID</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $forbidden->idx ?? $forbidden->id }}</dd>
                            </div>
                            <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">Created At</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $forbidden->wdate ?? $forbidden->created_at }}</dd>
                            </div>
                            
                            <div class="bg-gray-900/50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">text</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $forbidden->text }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('forbiddens.edit', $forbidden->idx ?? $forbidden->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium transition">Edit</a>
                        <a href="{{ route('forbiddens.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md text-white font-medium transition border border-gray-600">Back HTMLList</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
