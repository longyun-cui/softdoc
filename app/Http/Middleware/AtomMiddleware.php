<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App\User;

use Auth, Response;

class AtomMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if(!Auth::guard('atom')->check()) // 未登录
        {
            return redirect('/atom/login');
//            $return["status"] = false;
//            $return["log"] = "admin-no-login";
//            $return["msg"] = "请先登录";
//            return Response::json($return);
        }
        else
        {
            $admin = Auth::guard('atom')->user();
            view()->share('atom', $admin);
        }
        return $next($request);

    }
}
