<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App\Models\Doc_User;

use Auth, Response;

class LYMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if(!Auth::guard('LY')->check()) // 未登录
        {
            return redirect('/LY/login');
//            $return["status"] = false;
//            $return["log"] = "admin-no-login";
//            $return["msg"] = "请先登录";
//            return Response::json($return);
        }
        else
        {
            $admin = Auth::guard('LY')->user();
            view()->share('LY', $admin);
        }
        return $next($request);

    }
}
