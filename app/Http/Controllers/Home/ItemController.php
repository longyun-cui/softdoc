<?php

namespace App\Http\Controllers\Home;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use App\Services\Home\ItemService;
use App\Repositories\Home\ItemRepository;


class ItemController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
//        $this->service = new ProductService;
        $this->repo = new ItemRepository;
    }


    public function index()
    {
        return $this->repo->index();
    }

    // 列表
    public function viewList()
    {
        if(request()->isMethod('get'))
        {

            $category = request('category','all');
            if($category == "all") view()->share('menu_all_list_active', 'active');
            else if($category == "article") view()->share('menu_article_list_active', 'active');
            else if($category == "debase") view()->share('menu_debase_list_active', 'active');
            else if($category == "menu") view()->share('menu_menu_list_active', 'active');
            else if($category == "timeline") view()->share('menu_timeline_list_active', 'active');
            else view()->share('menu_all_list_active', 'active');

            return view('home.item.list');
        }
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

    // 【删除】
    public function shareAction()
    {
        return $this->repo->share(request()->all());
    }

    // 【启用】
    public function enableAction()
    {
        return $this->repo->enable(request()->all());
    }

    // 【禁用】
    public function disableAction()
    {
        return $this->repo->disable(request()->all());
    }



    // 目录类型列表
    public function content_menutype_viewIndex()
    {
        return $this->repo->content_menutype_view_index(request()->all());
    }
    // 时间线列表
    public function content_timeline_viewIndex()
    {
        return $this->repo->content_timeline_view_index(request()->all());
    }

    // 编辑
    public function content_menutype_editAction()
    {
        if(request()->isMethod('get')) return $this->repo->content_view_edit();
        else if (request()->isMethod('post')) return $this->repo->content_menutype_save(request()->all());
    }
    public function content_timeline_editAction()
    {
        if(request()->isMethod('get')) return $this->repo->content_view_edit();
        else if (request()->isMethod('post')) return $this->repo->content_timeline_save(request()->all());
    }

    // 【获取】
    public function content_getAction()
    {
        return $this->repo->content_get(request()->all());
    }

    // 【删除】
    public function content_deleteAction()
    {
        return $this->repo->content_delete(request()->all());
    }

    // 【启用】
    public function content_enableAction()
    {
        return $this->repo->content_enable(request()->all());
    }

    // 【禁用】
    public function content_disableAction()
    {
        return $this->repo->content_disable(request()->all());
    }




    // 【select2】
    public function select2_menus()
    {
        return $this->repo->select2_menus(request()->all());
    }




}
