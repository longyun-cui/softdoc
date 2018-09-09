<?php

namespace App\Http\Controllers\Home;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use App\Services\Home\ContentService;
use App\Repositories\Home\ContentRepository;


class ContentController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
//        $this->service = new ProductService;
        $this->repo = new ContentRepository;
    }


    public function index()
    {
        return $this->repo->index();
    }

    // 列表
    public function viewList()
    {
        if(request()->isMethod('get')) return view('home.course.list')->with(['menu_course_list'=>'active']);
        else if(request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }

    // 创建
    public function createAction()
    {
        return $this->repo->view_create();
    }

    // 编辑
    public function editAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_edit();
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    // 【删除】
    public function deleteAction()
    {
        return $this->repo->delete(request()->all());
    }

    // 【分享】
    public function enableAction()
    {
        return $this->repo->enable(request()->all());
    }

    // 【取消分享】
    public function disableAction()
    {
        return $this->repo->disable(request()->all());
    }


    // 列表
    public function content_viewIndex()
    {
        return $this->repo->content_view_index(request()->all());
    }

    // 编辑
    public function content_editAction()
    {
        if(request()->isMethod('get')) return $this->repo->content_view_edit();
        else if (request()->isMethod('post')) return $this->repo->content_save(request()->all());
    }

    // 【删除】
    public function content_getAction()
    {
        return $this->repo->content_get(request()->all());
    }

    // 【删除】
    public function content_deleteAction()
    {
        return $this->repo->content_delete(request()->all());
    }


    // 【select2】
    public function select2_menus()
    {
        return $this->repo->select2_menus(request()->all());
    }




}
