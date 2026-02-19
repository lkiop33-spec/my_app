<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                간단 게시판
            </h2>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                글 쓰기
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($posts->isEmpty())
                        <p class="text-gray-500 text-center py-8">아직 글이 없습니다. 첫 글을 남겨 보세요!</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach ($posts as $post)
                                <li class="py-4 first:pt-0">
                                    <p class="text-gray-900">{{ $post->body }}</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $post->user->display_name }} · {{ $post->created_at->format('Y-m-d H:i') }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
