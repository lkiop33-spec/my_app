<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('View DocList') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-white">DocList Details</h3>
                        <p class="mt-1 text-sm text-gray-400">Detailed information.</p>
                    </div>
                    
                    <div class="border-t border-gray-700">
                        <dl>
                            <div class="bg-gray-900/50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">ID</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $docList->idx ?? $docList->id }}</dd>
                            </div>
                            <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">Created At</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $docList->wdate ?? $docList->created_at }}</dd>
                            </div>
                            
                            <div class="bg-gray-900/50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">type</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $docList->typeRelationship?->mtype ?? 'N/A' }}</dd>
                            </div>
                            <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">name</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $docList->name }}</dd>
                            </div>
                            <div class="bg-gray-900/50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">filename</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">
                                    @if($docList->filename && $docList->path)
                                        @php
                                            $extension = strtolower(pathinfo($docList->filename, PATHINFO_EXTENSION));
                                            $isImage = in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'webp']);
                                        @endphp
                                        @if($isImage)
                                            <div class="mb-2">
                                                <img src="{{ asset($docList->path . '/' . $docList->filename) }}" alt="Document Image" class="max-w-md rounded-lg shadow border border-gray-700 bg-gray-900 p-1" />
                                            </div>
                                        @endif
                                        <a href="{{ asset($docList->path . '/' . $docList->filename) }}" target="_blank" class="text-blue-400 hover:underline font-medium">
                                            {{ $docList->filename }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">path</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $docList->path }}</dd>
                            </div>
                            <div class="bg-gray-900/50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">language</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $docList->languageRelationship?->mlanguage ?? 'N/A' }}</dd>
                            </div>
                            <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-400">reference</dt>
                                <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $docList->reference }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('doc_lists.edit', $docList->idx ?? $docList->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium transition">Edit</a>
                        <a href="{{ route('doc_lists.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md text-white font-medium transition border border-gray-600">Back HTMLList</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
