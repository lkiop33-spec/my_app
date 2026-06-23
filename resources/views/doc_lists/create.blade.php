<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Create DocList') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('doc_lists.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="type" value="type" class="text-gray-300" />
                            <select id="type" name="type" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">{{ __('Select Type') }}</option>
                                @foreach($types as $t)
                                    <option value="{{ $t->idx }}" {{ old('type') == $t->idx ? 'selected' : '' }}>
                                        {{ $t->mtype }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <x-input-label for="name" value="name" class="text-gray-300" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('name', '') }}" />
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <x-input-label for="doc_file" value="Document File" class="text-gray-300" />
                            <input id="doc_file" name="doc_file" type="file" class="mt-1 block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer" />
                            @error('doc_file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <x-input-label for="language" value="language" class="text-gray-300" />
                            <select id="language" name="language" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">{{ __('Select Language') }}</option>
                                @foreach($languages as $lang)
                                    <option value="{{ $lang->idx }}" {{ old('language') == $lang->idx ? 'selected' : '' }}>
                                        {{ $lang->mlanguage }}
                                    </option>
                                @endforeach
                            </select>
                            @error('language')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <x-input-label for="reference" value="reference" class="text-gray-300" />
                            <x-text-input id="reference" name="reference" type="text" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white" value="{{ old('reference', '') }}" />
                            @error('reference')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
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
