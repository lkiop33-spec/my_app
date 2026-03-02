<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('공지사항 (Notice)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white dark:text-gray-100">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('notices.create') }}" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('글쓰기') }}
                        </a>
                    </div>
                    
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-400 dark:text-gray-400">
                            <thead class="text-xs text-gray-300 uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    <th scope="col" class="px-6 py-3 w-1/2">Title</th>
                                    <th scope="col" class="px-6 py-3">Writer</th>
                                    <th scope="col" class="px-6 py-3">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($notices as $notice)
                                    <tr class="bg-gray-800 border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $notice->id }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('notices.show', $notice) }}" class="font-medium text-white dark:text-white hover:underline">
                                                {{ $notice->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">{{ $notice->user->name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">{{ $notice->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr class="bg-gray-800 border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="4" class="px-6 py-4 text-center">
                                            등록된 공지사항이 없습니다.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $notices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
