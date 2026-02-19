<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('사용자 상세 정보') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold">{{ $user->name }}</h3>
                        <a href="{{ route('users.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">
                            &larr; 목록으로 돌아가기
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">ID</span>
                            <span class="text-lg">{{ $user->id }}</span>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nickname</span>
                            <span class="text-lg">{{ $user->nickname ?? '-' }}</span>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</span>
                            <span class="text-lg">{{ $user->email }}</span>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border-l-4 border-indigo-500">
                            <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Rank (Grade)</span>
                            @if($user->rank_type)
                                <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ $user->rank_type }}
                                </span>
                            @else
                                <span class="text-lg text-gray-400">None</span>
                            @endif
                        </div>
                        
                         <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Joined</span>
                            <span class="text-lg">{{ $user->created_at->format('Y-m-d H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
