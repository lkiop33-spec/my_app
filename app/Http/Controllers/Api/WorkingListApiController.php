<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkingListApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. 유효성 검사 (worker_name과 text만 입력받도록 수정)
        $validator = Validator::make($request->all(), [
            'worker_name' => 'nullable|string|max:100',
            'text' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '유효성 검사 실패',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. no(작업 번호) 및 datetime(기록 일시) 자동 생성
        $generatedNo = 'WRK-BOND-' . mt_rand(1000, 9999);
        $datetime = now();

        // 3. 모델 생성 및 저장
        $workingList = WorkingList::create([
            'no' => $generatedNo,
            'worker_name' => $request->input('worker_name'),
            'text' => $request->input('text'),
            'datetime' => $datetime,
        ]);

        // 3. JSON 응답 전송
        return response()->json([
            'success' => true,
            'message' => '작업 결과가 성공적으로 기록되었습니다. AR 글래스 동기화 완료.',
            'data' => [
                'id' => $workingList->id,
                'no' => $workingList->no,
                'worker_name' => $workingList->worker_name,
                'text' => $workingList->text,
                'datetime' => $workingList->datetime->format('Y-m-d H:i:s'),
                'created_at' => $workingList->created_at->format('Y-m-d H:i:s'),
            ]
        ], 201);
    }

    /**
     * Get the latest working list item formatted as | delimited text.
     */
    public function latest()
    {
        $latest = WorkingList::latest('id')->first();

        if (!$latest) {
            return response('', 200)->header('Content-Type', 'text/plain; charset=UTF-8');
        }

        $formatted = sprintf(
            "%s|%s|%s|%s|%s",
            $latest->id,
            $latest->no,
            $latest->worker_name ?? '',
            $latest->text ?? '',
            $latest->datetime ? $latest->datetime->format('Y-m-d H:i:s') : ''
        );

        return response($formatted, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
