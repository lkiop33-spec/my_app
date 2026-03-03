<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('시스템 로그 게시판') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    
                    <!-- 필터 폼 -->
                    <form method="GET" action="{{ route('system_logs.index') }}" class="mb-6 flex space-x-4 items-end">
                        <div>
                            <label for="model_type" class="block text-sm font-medium text-gray-300">모델 (테이블)</label>
                            <select name="model_type" id="model_type" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">전체</option>
                                @foreach($modelTypes as $type)
                                    <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="action" class="block text-sm font-medium text-gray-300">동작</label>
                            <select name="action" id="action" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">전체</option>
                                <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>생성 (Created)</option>
                                <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>수정 (Updated)</option>
                                <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>삭제 (Deleted)</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                필터 적용
                            </button>
                            <a href="{{ route('system_logs.index') }}" class="ml-2 text-sm text-gray-400 hover:text-white">초기화</a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">시간</th>
                                    <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">사용자</th>
                                    <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">모델</th>
                                    <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">동작</th>
                                    <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">데이터 요약</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @forelse ($logs as $log)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $log->user ? $log->user->name : '시스템/비회원' }}<br>
                                            <span class="text-xs text-gray-500">{{ $log->ip_address }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $log->model_type }} #{{ $log->model_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($log->action == 'created')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">생성</span>
                                            @elseif($log->action == 'updated')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">수정</span>
                                            @elseif($log->action == 'deleted')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">삭제</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-300 max-w-xs break-words">
                                            @if($log->action == 'updated')
                                                <strong>변경 전:</strong>
                                                <pre class="text-xs bg-gray-700 p-2 rounded mt-1 overflow-x-auto max-w-sm">{{ json_encode($log->old_payload, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) }}</pre>
                                                <strong class="mt-2 block">변경 후:</strong>
                                                <pre class="text-xs bg-gray-700 p-2 rounded mt-1 overflow-x-auto max-w-sm">{{ json_encode($log->new_payload, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) }}</pre>
                                            @elseif($log->action == 'created')
                                                <pre class="text-xs bg-gray-700 p-2 rounded mt-1 overflow-x-auto max-w-sm">{{ json_encode($log->new_payload, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) }}</pre>
                                            @elseif($log->action == 'deleted')
                                                <pre class="text-xs bg-gray-700 p-2 rounded mt-1 overflow-x-auto max-w-sm">{{ json_encode($log->old_payload, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) }}</pre>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            연관된 로그가 없습니다.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 text-gray-300">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
