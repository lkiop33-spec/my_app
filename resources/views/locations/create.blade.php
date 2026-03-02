
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Create Location') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('locations.store') }}" class="space-y-6">
                        @csrf
                        
                        
                        
                        <div>
                            <x-input-label for="name" value="name" class="text-gray-300" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('name', '') }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="address" value="address" class="text-gray-300" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('address', '') }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="phone" value="phone" class="text-gray-300" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('phone', '') }}" />
                        </div>
                        
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('locations.index') }}" class="text-gray-400 hover:text-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
