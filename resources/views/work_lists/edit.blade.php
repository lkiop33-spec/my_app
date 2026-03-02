
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit WorkList') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('work_lists.update', $workList->idx ?? $workList->id) }}" class="space-y-6">
                        @csrf
                        @method("PUT")
                        
                        
                        <div>
                            <x-input-label for="partList" value="partList" class="text-gray-300" />
                            <x-text-input id="partList" name="partList" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('partList', $workList->partList) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="pcbIDX" value="pcbIDX" class="text-gray-300" />
                            <x-text-input id="pcbIDX" name="pcbIDX" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('pcbIDX', $workList->pcbIDX) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="memberIDX" value="memberIDX" class="text-gray-300" />
                            <x-text-input id="memberIDX" name="memberIDX" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('memberIDX', $workList->memberIDX) }}" />
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
