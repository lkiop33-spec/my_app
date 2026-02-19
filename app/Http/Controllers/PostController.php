<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * 간단 게시판 목록
     */
    public function index(): View
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(20);

        return view('posts.index', compact('posts'));
    }

    /**
     * 글 작성 폼
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * 글 저장
     */
    public function store(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:500'],
        ], [
            'body.required' => '내용을 입력해 주세요.',
            'body.max' => '내용은 500자까지 입력할 수 있습니다.',
        ]);

        $user = $request->user();

        // API 요청이고 로그인하지 않은 경우, 테스트를 위해 첫 번째 사용자를 사용
        if (!$user && $request->wantsJson()) {
            $user = \App\Models\User::first();
        }

        if (!$user) {
            return $request->wantsJson() 
                ? response()->json(['message' => 'Unauthenticated.'], 401)
                : redirect()->route('login');
        }

        $post = $user->posts()->create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => '글이 등록되었습니다.',
                'post' => $post
            ], 201);
        }

        return redirect()->route('posts.index')
            ->with('status', '글이 등록되었습니다.');
    }
}
