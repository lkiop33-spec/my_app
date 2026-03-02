
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Create ProcessTable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('process_tables.store') }}" class="space-y-6">
                        @csrf
                        
                        
                        
                        <div>
                            <x-input-label for="Code" value="Code" class="text-gray-300" />
                            <x-text-input id="Code" name="Code" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Code', '') }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Name" value="Name" class="text-gray-300" />
                            <x-text-input id="Name" name="Name" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Name', '') }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Class" value="Class" class="text-gray-300" />
                            <x-text-input id="Class" name="Class" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Class', '') }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Sequence" value="Sequence" class="text-gray-300" />
                            <x-text-input id="Sequence" name="Sequence" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Sequence', '') }}" />
                        </div>
                        
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('process_tables.index') }}" class="text-gray-400 hover:text-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
