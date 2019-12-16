<?php

namespace App\Http\Middleware;

use App\Helpers\ErrorCode;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    protected $pathArr = [
        'backend/index',
        'backend/logout',
        'backend/user/show',
        'backend/admin/list',
        'backend/article/show',
        'backend/article/list/show',
        'backend/article/category/show',
    ];

    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->guest()) {
            if ((in_array($request->path(), $this->pathArr) || strpos($request->path(),'/article/edit')) && $request->method() == 'GET') {
                return redirect()->guest('/backend/login');
            } else {
                throw new \Exception('请先登陆',ErrorCode::SYSTEM_ERROR);
            }
        }
            
        return $next($request);
    }
}
