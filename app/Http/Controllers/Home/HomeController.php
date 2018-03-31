<?php

namespace App\Http\Controllers\Home;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Common\CommonRepository;
use App\Repositories\Home\HomeRepository;


class HomeController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new HomeRepository;
    }


    public function index()
    {
        return view('home.index');
    }




    // 返回【用户信息】视图
    public function info_index()
    {
        return $this->repo->view_info_index();
    }

    // 【用户信息】【编辑】
    public function infoEditAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_info_edit();
        else if (request()->isMethod('post')) return $this->repo->info_save(request()->all());
    }



}
