<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight flex justify-between items-center">
            <span>{{ __('Working Lists') }}</span>
            <div class="flex items-center space-x-2">
                <span class="text-xs bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-3 py-1 rounded-full font-semibold flex items-center">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full mr-1.5 animate-pulse"></span>
                    AR Glass Live: Connected
                </span>
                <span class="text-xs bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 px-3 py-1 rounded-full font-medium">
                    현재 작업중인 누적 데이타
                </span>
            </div>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen text-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- 성공 알림창 -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-900/30 border border-green-500/30 text-green-400 rounded-none shadow-lg flex items-center space-x-2">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- 메인 카드 패널 -->
            <div class="bg-gray-800 border border-gray-700/60 shadow-xl rounded-none overflow-hidden">
                
                <!-- 테이블 헤더 영역 -->
                <div class="p-6 border-b border-gray-700 bg-gray-800/80 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-white flex items-center">
                            실시간 작업 결과 피드
                            <span class="ml-2 text-2xs bg-indigo-600/30 text-indigo-300 border border-indigo-600/20 px-2.5 py-0.5 rounded font-normal">
                                AR 글래스 최신 전송 단말 동기화
                            </span>
                        </h3>
                        <p class="text-xs text-gray-400 mt-1.5 flex items-center">
                            <span class="w-2 h-2 bg-indigo-500 rounded-full mr-1.5 animate-ping"></span>
                            실시간으로 올라오는 공정 작업 결과를 수집 및 기록하고, 연결된 현장 AR 글래스 단말로 최신 지침 정보를 즉시 송신합니다.
                        </p>
                    </div>
                </div>

                <!-- 작업 목록 테이블 -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700 text-sm">
                        <thead class="bg-gray-800/40">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">작업 번호 (No)</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">작업자 (Worker)</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">작업 내용 (Text)</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">기록 일시 (Datetime)</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">액션</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700 bg-gray-800/20">
                            @forelse($items as $item)
                                <tr class="hover:bg-gray-700/30 transition-colors duration-150" data-id="{{ $item->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 font-mono">
                                        #{{ $item->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-indigo-300 font-mono">
                                        {{ $item->no }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-200 font-semibold">
                                        {{ $item->worker_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-200 max-w-md truncate">
                                        {{ $item->text ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 font-mono">
                                        {{ $item->datetime ? $item->datetime->format('Y-m-d H:i:s') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium space-x-3">
                                        <a href="{{ route('working_lists.show', $item) }}" class="text-indigo-400 hover:text-indigo-300 transition">
                                            조회
                                        </a>
                                        <a href="{{ route('working_lists.edit', $item) }}" class="text-amber-400 hover:text-amber-300 transition">
                                            수정
                                        </a>
                                        <form action="{{ route('working_lists.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('정말로 이 누적 데이터를 삭제하시겠습니까?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-300 transition">
                                                삭제
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <svg class="w-10 h-10 text-gray-600 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v2m4.586-1H11" />
                                            </svg>
                                            <p class="text-sm font-semibold">누적 작업 데이터가 없습니다.</p>
                                            <p class="text-xs text-gray-600">등록된 누적 작업 데이터가 존재하지 않습니다.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 페이지네이션 링크 -->
                @if($items->hasPages())
                    <div class="p-6 border-t border-gray-700 bg-gray-800/40">
                        {{ $items->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- 실시간 지능형 자동 새로고침 폴링 스크립트 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 현재 화면의 맨 위에 있는 가장 최신 행(row)의 ID 확보
            const firstRow = document.querySelector('tbody tr[data-id]');
            if (!firstRow) return;
            
            const currentLatestId = parseInt(firstRow.getAttribute('data-id'), 10);

            // 3초 주기로 최신 API를 비동기 호출하여 대조
            setInterval(() => {
                fetch('/api/working_lists/latest')
                    .then(response => response.text())
                    .then(text => {
                        if (!text) return;
                        
                        // "id|no|worker_name|text|datetime" 응답 텍스트 해체
                        const parts = text.split('|');
                        const serverLatestId = parseInt(parts[0], 10);

                        // 서버의 최종 id가 화면에 렌더링된 최신 id보다 크면 (즉 새 데이터 등록 감지 시)
                        if (serverLatestId > currentLatestId) {
                            // 지체 없이 현재 화면을 매끄럽게 새로고침하여 반영
                            location.reload();
                        }
                    })
                    .catch(err => console.error('실시간 새로고침 에러:', err));
            }, 3000); // 3초 주기 폴링
        });
    </script>
</x-app-layout>
