<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XssSanitization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        
        // 재귀적으로 문자열 입력값의 HTML 태그를 제거 (단, 비밀번호 등은 예외 처리 가능. 여기서는 기본적으로 모든 문자열에 적용)
        array_walk_recursive($input, function (&$input, $key) {
            if (is_string($input) && !in_array(strtolower($key), ['password', 'password_confirmation'])) {
                $input = strip_tags($input);
            }
        });
        
        $request->merge($input);

        return $next($request);
    }
}
