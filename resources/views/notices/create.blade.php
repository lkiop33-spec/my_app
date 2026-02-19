<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($notice) ? __('공지사항 수정') : __('공지사항 작성') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ isset($notice) ? route('notices.update', $notice) : route('notices.store') }}">
                        @csrf
                        @if(isset($notice))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('제목')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $notice->title ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="content" :value="__('내용')" />
                            <textarea id="content" name="content" rows="10" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('content', $notice->content ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('notices.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">취소</a>
                            <x-primary-button>
                                {{ isset($notice) ? __('수정 (Update)') : __('등록 (Save)') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
