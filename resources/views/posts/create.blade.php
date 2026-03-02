<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('posts.index') }}" class="text-gray-400 hover:text-white">&larr; 목록</a>
            <h2 class="font-semibold text-xl text-white leading-tight">
                글 쓰기
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="body" value="내용" />
                            <x-text-input
                                id="body"
                                name="body"
                                type="text"
                                class="block mt-1 w-full"
                                :value="old('body')"
                                placeholder="내용을 적어 주세요."
                                maxlength="500"
                                required
                                autofocus
                            />
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-400">500자까지 입력할 수 있습니다.</p>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-3">
                            <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-600 rounded-md font-semibold text-xs text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                취소
                            </a>
                            <x-primary-button>
                                등록
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
