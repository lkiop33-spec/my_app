
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Create WorkList') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('work_lists.store') }}" class="space-y-6">
                        @csrf
                        
                        
                        
                        <div>
                            <x-input-label for="partList" value="partList" class="text-gray-300" />
                            <x-text-input id="partList" name="partList" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('partList', '') }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="pcbIDX" value="PCB Board (pcbIDX)" class="text-gray-300" />
                            <select id="pcbIDX" name="pcbIDX" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">{{ __('Select PCB') }}</option>
                                @foreach($pcbs as $pcb)
                                    <option value="{{ $pcb->idx }}" {{ old('pcbIDX', '') == $pcb->idx ? 'selected' : '' }}>
                                        {{ $pcb->PCB_Number }} ({{ $pcb->Name_Type }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pcbIDX')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <x-input-label for="memberIDX" value="Worker (memberIDX)" class="text-gray-300" />
                            <select id="memberIDX" name="memberIDX" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">{{ __('Select Worker') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('memberIDX', '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('memberIDX')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('work_lists.index') }}" class="text-gray-400 hover:text-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
