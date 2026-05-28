<?php

namespace App\Http\Controllers;

use App\Models\WorkingList;
use Illuminate\Http\Request;

class WorkingListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WorkingList::query();

        // 검색 필터 적용
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('no', 'like', "%{$search}%")
                  ->orWhere('text', 'like', "%{$search}%");
            });
        }

        $items = $query->latest('datetime')->paginate(10)->withQueryString();

        return view('working_lists.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('working_lists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no' => 'required|string|max:50',
            'text' => 'nullable|string',
            'datetime' => 'nullable|date',
        ]);

        WorkingList::create([
            'no' => $request->input('no'),
            'text' => $request->input('text'),
            'datetime' => $request->input('datetime') ?? now(),
        ]);

        return redirect()->route('working_lists.index')
            ->with('success', '새로운 누적 작업 데이터가 등록되었습니다.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkingList $workingList)
    {
        return view('working_lists.show', compact('workingList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkingList $workingList)
    {
        return view('working_lists.edit', compact('workingList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkingList $workingList)
    {
        $request->validate([
            'no' => 'required|string|max:50',
            'text' => 'nullable|string',
            'datetime' => 'nullable|date',
        ]);

        $workingList->update([
            'no' => $request->input('no'),
            'text' => $request->input('text'),
            'datetime' => $request->input('datetime') ?? $workingList->datetime,
        ]);

        return redirect()->route('working_lists.index')
            ->with('success', '누적 작업 데이터가 성공적으로 수정되었습니다.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkingList $workingList)
    {
        $workingList->delete();

        return redirect()->route('working_lists.index')
            ->with('success', '누적 작업 데이터가 삭제되었습니다.');
    }
}
