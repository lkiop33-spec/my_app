
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit PartTable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('part_tables.update', $partTable->idx ?? $partTable->id) }}" class="space-y-6">
                        @csrf
                        @method("PUT")
                        
                        
                        <div>
                            <x-input-label for="Part_Number" value="Part Number" class="text-gray-300" />
                            <x-text-input id="Part_Number" name="Part_Number" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Part_Number', $partTable->Part_Number) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Name" value="Name" class="text-gray-300" />
                            <x-text-input id="Name" name="Name" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Name', $partTable->Name) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="PCB_Number" value="PCB Number" class="text-gray-300" />
                            <x-text-input id="PCB_Number" name="PCB_Number" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('PCB_Number', $partTable->PCB_Number) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Process_Class" value="Process Class" class="text-gray-300" />
                            <x-text-input id="Process_Class" name="Process_Class" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Process_Class', $partTable->Process_Class) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Process_Name" value="Process Name" class="text-gray-300" />
                            <x-text-input id="Process_Name" name="Process_Name" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Process_Name', $partTable->Process_Name) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Process_Detail" value="Process Detail" class="text-gray-300" />
                            <x-text-input id="Process_Detail" name="Process_Detail" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Process_Detail', $partTable->Process_Detail) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Side" value="Side" class="text-gray-300" />
                            <x-text-input id="Side" name="Side" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Side', $partTable->Side) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Image_File" value="Image File" class="text-gray-300" />
                            <x-text-input id="Image_File" name="Image_File" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Image_File', $partTable->Image_File) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Quantity" value="Quantity" class="text-gray-300" />
                            <x-text-input id="Quantity" name="Quantity" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Quantity', $partTable->Quantity) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Location_1" value="Location 1" class="text-gray-300" />
                            <x-text-input id="Location_1" name="Location_1" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Location_1', $partTable->Location_1) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Location_2" value="Location 2" class="text-gray-300" />
                            <x-text-input id="Location_2" name="Location_2" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Location_2', $partTable->Location_2) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Location_3" value="Location 3" class="text-gray-300" />
                            <x-text-input id="Location_3" name="Location_3" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Location_3', $partTable->Location_3) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="Location_4" value="Location 4" class="text-gray-300" />
                            <x-text-input id="Location_4" name="Location_4" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('Location_4', $partTable->Location_4) }}" />
                        </div>
                        
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('part_tables.index') }}" class="text-gray-400 hover:text-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
