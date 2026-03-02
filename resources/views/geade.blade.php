<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('직급 관리 (Geade)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Add New Geade Form -->
            <div class="p-4 sm:p-8 bg-gray-800 dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-white dark:text-gray-100">
                                {{ __('새 직급 추가') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-400 dark:text-gray-400">
                                {{ __('새로운 직급 정보를 입력해 주세요.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('geades.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="rank_type" :value="__('직급 (Rank Type)')" />
                                <x-text-input id="rank_type" name="rank_type" type="text" class="mt-1 block w-full" :value="old('rank_type')" placeholder="예: pm, manager, senior" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('rank_type')" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('설명 (Description)')" />
                                <textarea id="description" name="description" class="mt-1 block w-full border-gray-600 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3" placeholder="지급에 대한 설명">{{ old('description') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('저장') }}</x-primary-button>

                                @if (session('status'))
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-400 dark:text-gray-400"
                                    >{{ session('status') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Geade List Table -->
            <div class="p-4 sm:p-8 bg-gray-800 dark:bg-gray-800 shadow sm:rounded-lg">
                <header class="mb-4">
                     <h2 class="text-lg font-medium text-white dark:text-gray-100">
                        {{ __('직급 목록') }}
                    </h2>
                </header>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-400 dark:text-gray-400">
                        <thead class="text-xs text-gray-300 uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Rank Type</th>
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="px-6 py-3">Date</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($geades as $geade)
                                <tr class="bg-gray-800 border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-white whitespace-nowrap dark:text-white">
                                        {{ $geade->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 font-semibold leading-tight text-indigo-700 bg-indigo-100 rounded-full dark:bg-indigo-700 dark:text-indigo-100">
                                            {{ strtoupper($geade->rank_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $geade->description }}
                                    </td>
                                     <td class="px-6 py-4">
                                        {{ $geade->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <form method="POST" action="{{ route('geades.destroy', $geade) }}" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">삭제</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-gray-800 border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="5" class="px-6 py-4 text-center">
                                        등록된 직급이 없습니다.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
