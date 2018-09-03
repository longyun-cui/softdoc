<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Front\WeixinRepository;

class WeixinController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new WeixinRepository;
    }



    // 返回主页视图
    public function index()
    {
        return $this->repo->index();
    }

    // 公众号授权
    public function weixin_login()
    {
        $this->repo->weixin_login(request()->all());
    }

    // 公众号授权
    public function weixin_auth()
    {
        $this->repo->weixin_auth(request()->all());
    }

    // 公众号
    public function gongzhonghao()
    {
        $this->repo->gongzhonghao();
    }


    // 返回主页视图
    public function root()
    {
        $this->repo->root();
    }


    // 返回主页视图
    public function test()
    {
        $this->repo->test();
    }



}
