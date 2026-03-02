<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('사용자 관리') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-400 dark:text-gray-400">
                            <thead class="text-xs text-gray-300 uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Rank</th>
                                    <th scope="col" class="px-6 py-3">Department</th>
                                    <th scope="col" class="px-6 py-3">Joined Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="bg-gray-800 border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $user->id }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('users.show', $user) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                {{ $user->name }}
                                            </a>
                                            @if($user->nickname)
                                                <span class="text-xs text-gray-400 ml-1">({{ $user->nickname }})</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('users.updateRank', $user) }}" method="POST">
                                                @csrf
                                                <select name="rank_type" onchange="this.form.submit()" class="block w-full p-2 text-sm text-white border border-gray-600 rounded-lg bg-gray-700 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="">{{ __('None') }}</option>
                                                    @foreach($geades as $geade)
                                                        <option value="{{ $geade->rank_type }}" {{ $user->rank_type == $geade->rank_type ? 'selected' : '' }}>
                                                            {{ $geade->rank_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('users.updateDepartment', $user) }}" method="POST">
                                                @csrf
                                                <select name="department_id" onchange="this.form.submit()" class="block w-full p-2 text-sm text-white border border-gray-600 rounded-lg bg-gray-700 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="">{{ __('None') }}</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">{{ $user->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
