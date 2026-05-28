<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight flex justify-between items-center">
            <span>{{ __('신규 누적 작업 등록') }}</span>
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
            
            <div class="bg-gray-800 border border-gray-700/60 shadow-2xl rounded-2xl overflow-hidden p-8">
                <div class="mb-6 border-b border-gray-700 pb-4">
                    <h3 class="text-base font-bold text-white">작업 상세 메타데이터 입력</h3>
                    <p class="text-xs text-gray-400 mt-1">공정 내에서 누적 추적 중인 작업 정보를 꼼꼼히 채워주세요.</p>
                </div>

                <form method="POST" action="{{ route('working_lists.store') }}" class="space-y-6">
                    @csrf

                    <!-- 1. 작업 번호 (no) -->
                    <div>
                        <label for="no" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">작업 번호 (No) <span class="text-red-500">*</span></label>
                        <input type="text" name="no" id="no" value="{{ old('no') }}" required placeholder="예: WRK-2026-0001" 
                               class="w-full rounded-xl border-gray-700 bg-gray-900 text-gray-200 placeholder-gray-500 text-sm p-3 focus:border-indigo-500 focus:ring-indigo-500 @error('no') border-red-500 @enderror">
                        @error('no')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2. 작업 일시 (datetime) -->
                    <div>
                        <label for="datetime" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">작업 일시 (Datetime)</label>
                        <input type="datetime-local" name="datetime" id="datetime" value="{{ old('datetime', now()->format('Y-m-d\TH:i')) }}"
                               class="w-full rounded-xl border-gray-700 bg-gray-900 text-gray-200 text-sm p-3 focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="text-3xs text-gray-500 mt-1.5 block">미선택 시 현재 서버 표준 시각으로 자동 적용됩니다.</span>
                        @error('datetime')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 3. 작업 내용 (text) -->
                    <div>
                        <label for="text" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">작업 내용 설명 (Text)</label>
                        <textarea name="text" id="text" rows="5" placeholder="누적 작업에 대한 세부 내용을 기록하세요..." 
                                  class="w-full rounded-xl border-gray-700 bg-gray-900 text-gray-200 placeholder-gray-500 text-sm p-3 focus:border-indigo-500 focus:ring-indigo-500 @error('text') border-red-500 @enderror">{{ old('text') }}</textarea>
                        @error('text')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 제출 영역 -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-700">
                        <a href="{{ route('working_lists.index') }}" class="px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-gray-400 border border-gray-800 rounded-xl text-xs font-semibold transition">
                            취소
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/30 transition-all">
                            등록 완료
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
