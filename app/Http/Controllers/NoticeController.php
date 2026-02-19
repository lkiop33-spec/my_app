<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $notices = Notice::with('user')->latest()->paginate(10);
        return view('notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('notices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $request->user()->notices()->create($validated);

        return redirect()->route('notices.index')->with('status', '공지사항이 등록되었습니다.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice): View
    {
        return view('notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice): View
    {
        return view('notices.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $notice->update($validated);

        return redirect()->route('notices.index')->with('status', '공지사항이 수정되었습니다.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice): RedirectResponse
    {
        $notice->delete();

        return redirect()->route('notices.index')->with('status', '공지사항이 삭제되었습니다.');
    }
}
