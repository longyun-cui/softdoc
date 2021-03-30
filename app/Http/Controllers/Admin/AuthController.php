<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

use Response, Auth, Validator, DB, Exception;


class AuthController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
//        $this->repo = new AuthRepository;
    }

    // 登陆
    public function login()
    {
        if(request()->isMethod('get'))
        {
            return view(env('TEMPLATE_DOC_ADMIN').'auth.login');
        }
        else if(request()->isMethod('post'))
        {
//            $where['password'] = request()->get('password');
//            $where['email'] = request()->get('email');
//            $where['mobile'] = request()->get('mobile');
//            $admin = Administrator::where($where)->first();

            // 邮箱验证
//            $email = request()->get('email');
//            $admin = Administrator::whereEmail($email)->first();

            // 手机验证
            $mobile = request()->get('mobile');
            $admin = User::where(['user_category'=>0,'mobile'=>$mobile])->first();

            if($admin)
            {
//                if($admin->active == 1)
//                {
                    $password = request()->get('password');
                    if(password_check($password,$admin->password))
                    {
                        Auth::guard('admin')->login($admin,true);
                        return response_success();
                    }
                    else return response_error([],'账户or密码不正确');
//                }
//                else return response_error([],'账户尚未激活，请先激活账户。');
            }
            else return response_error([],'账户不存在或没有权限');
        }
    }

    // 退出
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    // 登陆
    public function register()
    {
        if(request()->isMethod('get'))
        {
            return view(env('TEMPLATE_DOC_ADMIN').'auth.register');
        }
        else if(request()->isMethod('post'))
        {
//            $where['password'] = request()->get('password');
//            $where['email'] = request()->get('email');
//            $where['mobile'] = request()->get('mobile');
//            $admin = Administrator::where($where)->first();

            // 邮箱验证
//            $email = request()->get('email');
//            $admin = Administrator::whereEmail($email)->first();

            // 手机验证
            $mobile = request()->get('mobile');
            $admin = User::where(['user_category'=>0,'mobile'=>$mobile])->first();

            if($admin)
            {
//                if($admin->active == 1)
//                {
                $password = request()->get('password');
                if(password_check($password,$admin->password))
                {
                    Auth::guard('admin')->login($admin,true);
                    return response_success();
                }
                else return response_error([],'账户or密码不正确');
//                }
//                else return response_error([],'账户尚未激活，请先激活账户。');
            }
            else return response_error([],'账户不存在或没有权限');
        }
    }






}
