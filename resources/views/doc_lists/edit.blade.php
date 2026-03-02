
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit DocList') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('doc_lists.update', $docList->idx ?? $docList->id) }}" class="space-y-6">
                        @csrf
                        @method("PUT")
                        
                        
                        <div>
                            <x-input-label for="type" value="type" class="text-gray-300" />
                            <x-text-input id="type" name="type" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('type', $docList->type) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="name" value="name" class="text-gray-300" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('name', $docList->name) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="filename" value="filename" class="text-gray-300" />
                            <x-text-input id="filename" name="filename" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('filename', $docList->filename) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="path" value="path" class="text-gray-300" />
                            <x-text-input id="path" name="path" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('path', $docList->path) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="language" value="language" class="text-gray-300" />
                            <x-text-input id="language" name="language" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('language', $docList->language) }}" />
                        </div>
                        
                        <div>
                            <x-input-label for="reference" value="reference" class="text-gray-300" />
                            <x-text-input id="reference" name="reference" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('reference', $docList->reference) }}" />
                        </div>
                        
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('doc_lists.index') }}" class="text-gray-400 hover:text-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
