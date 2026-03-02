<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('공지사항 보기') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white dark:text-gray-100">
                    <div class="mb-6 border-b border-gray-700 dark:border-gray-700 pb-4">
                        <h1 class="text-2xl font-bold mb-2">{{ $notice->title }}</h1>
                        <div class="flex items-center text-sm text-gray-400 dark:text-gray-400 gap-4">
                            <span>작성자: {{ $notice->user->name ?? 'Unknown' }}</span>
                            <span>작성일: {{ $notice->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>

                    <div class="prose dark:prose-invert max-w-none mb-8 whitespace-pre-wrap">
                        {{ $notice->content }}
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-700 dark:border-gray-700 pt-4">
                        <a href="{{ route('notices.index') }}" class="text-gray-400 dark:text-gray-400 hover:underline">
                            &larr; 목록으로 돌아가기
                        </a>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('notices.edit', $notice) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                수정
                            </a>
                            <form method="POST" action="{{ route('notices.destroy', $notice) }}" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    삭제
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
