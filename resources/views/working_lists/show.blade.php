<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight flex justify-between items-center">
            <span>{{ __('작업 누적 내역 조회') }}</span>
            <a href="{{ route('working_lists.index') }}" class="text-xs text-gray-400 hover:text-white flex items-center transition">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                목록으로 돌아가기
            </a>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen text-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gray-800 border border-gray-700/60 shadow-2xl rounded-none overflow-hidden">
                
                <!-- 상세 헤더 배너 -->
                <div class="p-8 bg-gray-800/80 border-b border-gray-700/60 flex justify-between items-start">
                    <div>
                        <span class="text-2xs font-extrabold uppercase tracking-widest bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-2 py-0.5 rounded">
                            Working List Detail
                        </span>
                        <h3 class="text-2xl font-extrabold text-white mt-2 font-mono" x-text="'No: ' + '{{ $workingList->no }}'"></h3>
                        <p class="text-xs text-gray-400 mt-1.5 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            기록 일시: {{ $workingList->datetime ? $workingList->datetime->format('Y-m-d H:i:s') : '-' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            작업자: {{ $workingList->worker_name ?? '미지정' }}
                        </p>
                    </div>

                    <span class="text-xs font-mono bg-gray-700/40 text-gray-300 border border-gray-600/30 px-3 py-1 rounded-lg">
                        DB ID: #{{ $workingList->id }}
                    </span>
                </div>

                <!-- 상세 내용 영역 -->
                <div class="p-8 space-y-6">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">작업 세부 설명 (Text)</h4>
                        <div class="bg-gray-900 rounded-none p-5 border border-gray-800/80 min-h-[150px] whitespace-pre-wrap text-sm text-gray-200 leading-relaxed font-sans shadow-inner">
                            {{ $workingList->text ?? '기록된 내용이 없습니다.' }}
                        </div>
                    </div>

                    <!-- 타임스탬프 메타 영역 -->
                    <div class="grid grid-cols-2 gap-4 bg-gray-900/40 rounded-none p-4 border border-gray-800/50 text-2xs font-mono text-gray-500">
                        <div>
                            <span>등록 시간 (Created At):</span>
                            <span class="block text-xs text-gray-400 mt-1">{{ $workingList->created_at ? $workingList->created_at->format('Y-m-d H:i:s') : '-' }}</span>
                        </div>
                        <div>
                            <span>최종 갱신 (Updated At):</span>
                            <span class="block text-xs text-gray-400 mt-1">{{ $workingList->updated_at ? $workingList->updated_at->format('Y-m-d H:i:s') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- 상세 액션 푸터 -->
                <div class="px-8 py-5 bg-gray-800/80 border-t border-gray-700/60 flex justify-between items-center">
                    <form action="{{ route('working_lists.destroy', $workingList) }}" method="POST" onsubmit="return confirm('정말로 이 누적 데이터를 영구 삭제하시겠습니까?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs font-bold transition">
                            영구 삭제
                        </button>
                    </form>

                    <div class="flex space-x-3">
                        <a href="{{ route('working_lists.index') }}" class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-gray-400 border border-gray-800 rounded-none text-xs font-semibold transition">
                            목록
                        </a>
                        <a href="{{ route('working_lists.edit', $workingList) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-none text-xs font-semibold shadow-lg shadow-amber-600/20 hover:shadow-amber-600/30 transition-all">
                            작업 편집
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
