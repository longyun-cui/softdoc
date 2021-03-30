<?php

namespace App\Http\Controllers\Front;

use function foo\func;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Front\IndexRepository;


class IndexController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new IndexRepository;
    }


    public function view_root()
    {
        return $this->repo->view_root(request()->all());
    }


    // 【我的原创】
    public function view_home_mine_original()
    {
        return $this->repo->view_home_mine_original(request()->all());
    }

    // 【我的待办事】
    public function view_home_mine_todolist()
    {
        return $this->repo->view_home_mine_todolist(request()->all());
    }
    // 【我的日程】
    public function view_home_mine_schedule()
    {
        return $this->repo->view_home_mine_schedule(request()->all());
    }
    // 【收藏内容】
    public function view_home_mine_collection()
    {
        return $this->repo->view_home_mine_collection(request()->all());
    }
    // 【点赞内容】
    public function view_home_mine_favor()
    {
        return $this->repo->view_home_mine_favor(request()->all());
    }
    // 【发现】
    public function view_home_mine_discovery()
    {
        return $this->repo->view_home_mine_discovery(request()->all());
    }
    // 【我的关注】
    public function view_home_mine_follow()
    {
        return $this->repo->view_home_mine_follow(request()->all());
    }
    // 【我的好友圈】
    public function view_home_mine_circle()
    {
        return $this->repo->view_home_mine_circle(request()->all());
    }




    // 【我的好友圈】
    public function view_home_notification()
    {
        return $this->repo->view_home_notification(request()->all());
    }




    // 【内容详情】
    public function view_item($id=0)
    {
        return $this->repo->view_item(request()->all(),$id);
    }




    public function view_user($id=0)
    {
        return $this->repo->view_user(request()->all(),$id);
    }
    public function view_user_original($id=0)
    {
        return $this->repo->view_user_original(request()->all(),$id);
    }
    public function view_user_follow($id=0)
    {
        return $this->repo->view_user_follow(request()->all(),$id);
    }
    public function view_user_fans($id=0)
    {
        return $this->repo->view_user_fans(request()->all(),$id);
    }




    // 【添加关注】
    public function user_relation_add()
    {
        return $this->repo->user_relation_add(request()->all());
    }
    // 【取消关注】
    public function user_relation_remove()
    {
        return $this->repo->user_relation_remove(request()->all());
    }




    // 【添加关注】
    public function view_relation_follow()
    {
        return $this->repo->view_relation_follow(request()->all());
    }
    // 【取消关注】
    public function view_relation_fans()
    {
        return $this->repo->view_relation_fans(request()->all());
    }




    // 【ajax】【获取日程】
    public function ajax_get_schedule()
    {
        return $this->repo->ajax_get_schedule(request()->all());
    }



    // 【创建】
    public function view_home_mine_item_create()
    {
        return $this->repo->view_home_mine_item_create();
    }
    // 【编辑&存储】
    public function view_home_mine_item_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_home_mine_item_edit();
        else if (request()->isMethod('post')) return $this->repo->home_mine_item_save(request()->all());
    }


    // 【目录类型】编辑视图
    public function view_home_mine_item_edit_menutype()
    {
        return $this->repo->view_home_mine_item_edit_menutype(request()->all());
    }
    // 【时间线】编辑视图
    public function view_home_mine_item_edit_timeline()
    {
        return $this->repo->view_home_mine_item_edit_timeline(request()->all());
    }


    // 【目录类型】存储
    public function home_mine_item_menutype_save()
    {
        if(request()->isMethod('get')) return $this->repo->view_home_mine_item_edit_menutype(request()->all());
        else if (request()->isMethod('post')) return $this->repo->home_mine_item_menutype_save(request()->all());
    }
    // 【时间线】存储
    public function home_mine_item_timeline_save()
    {
        if(request()->isMethod('get')) return $this->repo->view_home_mine_item_edit_timeline(request()->all());
        else if (request()->isMethod('post')) return $this->repo->home_mine_item_timeline_save(request()->all());
    }




    // 【删除】
    public function item_delete()
    {
        return $this->repo->item_delete(request()->all());
    }

    // 【收藏】
    public function item_add_collection()
    {
        return $this->repo->item_add_this(request()->all(),21);
    }
    public function item_remove_collection()
    {
        return $this->repo->item_remove_this(request()->all(),21);
    }

    // 【点赞】
    public function item_add_favor()
    {
        return $this->repo->item_add_this(request()->all(),11);
    }
    public function item_remove_favor()
    {
        return $this->repo->item_remove_this(request()->all(),11);
    }

    // 【待办事】
    public function item_add_todolist()
    {
        return $this->repo->item_add_this(request()->all(),31);
    }
    public function item_remove_todolist()
    {
        return $this->repo->item_remove_this(request()->all(),31);
    }

    // 【日程】
    public function item_add_schedule()
    {
        return $this->repo->item_add_this(request()->all(),32);
    }
    public function item_remove_schedule()
    {
        return $this->repo->item_remove_this(request()->all(),32);
    }


    // 【转发】
    public function item_forward()
    {
        return $this->repo->item_forward(request()->all());
    }




    // 收藏
    public function item_collect_save()
    {
        return $this->repo->item_collect_save(request()->all());
    }
    public function item_collect_cancel()
    {
        return $this->repo->item_collect_cancel(request()->all());
    }


    // 点赞
    public function item_favor_save()
    {
        return $this->repo->item_favor_save(request()->all());
    }
    public function item_favor_cancel()
    {
        return $this->repo->item_favor_cancel(request()->all());
    }




    // 评论
    public function item_comment_save()
    {
        return $this->repo->item_comment_save(request()->all());
    }
    public function item_comment_get()
    {
        return $this->repo->item_comment_get(request()->all());
    }
    public function item_comment_get_html()
    {
        return $this->repo->item_comment_get_html(request()->all());
    }


    // 回复
    public function item_reply_save()
    {
        return $this->repo->item_reply_save(request()->all());
    }
    public function item_reply_get()
    {
        return $this->repo->item_reply_get(request()->all());
    }


    // 评论点赞
    public function item_comment_favor_save()
    {
        return $this->repo->item_comment_favor_save(request()->all());
    }
    public function item_comment_favor_cancel()
    {
        return $this->repo->item_comment_favor_cancel(request()->all());
    }



}
