
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit PcbImageTable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('pcb_image_tables.update', $pcbImageTable->idx ?? $pcbImageTable->id) }}" class="space-y-6">
                        @csrf
                        @method("PUT")
                        
                        
                        <div>
                            <x-input-label for="PCB_Number" value="PCB Number" class="text-gray-300" />
                            <x-text-input id="PCB_Number" name="PCB_Number" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('PCB_Number', $pcbImageTable->PCB_Number) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Image" value="Image" class="text-gray-300" />
                            <x-text-input id="Image" name="Image" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Image', $pcbImageTable->Image) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="BoundBox" value="BoundBox" class="text-gray-300" />
                            <x-text-input id="BoundBox" name="BoundBox" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('BoundBox', $pcbImageTable->BoundBox) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Other" value="Other" class="text-gray-300" />
                            <x-text-input id="Other" name="Other" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Other', $pcbImageTable->Other) }}" />
                        </div>
                        
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('pcb_image_tables.index') }}" class="text-gray-400 hover:text-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
