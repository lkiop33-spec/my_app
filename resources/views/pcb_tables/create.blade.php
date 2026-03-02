
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Create PcbTable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('pcb_tables.store') }}" class="space-y-6">
                        @csrf
                        
                        
                        
                        <div>
                            <x-input-label for="PCB_Number" value="PCB Number" class="text-gray-300" />
                            <x-text-input id="PCB_Number" name="PCB_Number" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('PCB_Number', '') }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Name_Type" value="Name Type" class="text-gray-300" />
                            <x-text-input id="Name_Type" name="Name_Type" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Name_Type', '') }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Image_File" value="Image File" class="text-gray-300" />
                            <x-text-input id="Image_File" name="Image_File" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Image_File', '') }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Image_Side" value="Image Side" class="text-gray-300" />
                            <x-text-input id="Image_Side" name="Image_Side" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Image_Side', '') }}" />
                        </div>
                        
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('pcb_tables.index') }}" class="text-gray-400 hover:text-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
