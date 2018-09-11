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


    // 【待办事】
    public function view_home_todolist()
    {
        return $this->repo->view_home_todolist(request()->all());
    }
    // 【日程】
    public function view_home_schedule()
    {
        return $this->repo->view_home_schedule(request()->all());
    }
    // 【收藏】
    public function view_home_collection()
    {
        return $this->repo->view_home_collection(request()->all());
    }
    // 【点赞】
    public function view_home_favor()
    {
        return $this->repo->view_home_favor(request()->all());
    }
    // 【收藏】
    public function view_home_discovery()
    {
        return $this->repo->view_home_discovery(request()->all());
    }
    // 【点赞】
    public function view_home_circle()
    {
        return $this->repo->view_home_circle(request()->all());
    }




    // 【内容详情】
    public function view_item($id=0)
    {
        return $this->repo->view_item(request()->all(),$id);
    }




    // 【收藏】
    public function item_add_collection()
    {
        return $this->repo->item_add_this(request()->all(),1);
    }
    public function item_remove_collection()
    {
        return $this->repo->item_remove_this(request()->all(),1);
    }

    // 【点赞】
    public function item_add_favor()
    {
        return $this->repo->item_add_this(request()->all(),9);
    }
    public function item_remove_favor()
    {
        return $this->repo->item_remove_this(request()->all(),9);
    }

    // 【待办事】
    public function item_add_todolist()
    {
        return $this->repo->item_add_this(request()->all(),11);
    }
    public function item_remove_todolist()
    {
        return $this->repo->item_remove_this(request()->all(),11);
    }

    // 【日程】
    public function item_add_schedule()
    {
        return $this->repo->item_add_this(request()->all(),12);
    }
    public function item_remove_schedule()
    {
        return $this->repo->item_remove_this(request()->all(),12);
    }





    public function view_courses()
    {
        return $this->repo->view_courses(request()->all());
    }
    public function view_contents()
    {
        return $this->repo->view_contents(request()->all());
    }

    public function view_course($id=0)
    {
        return $this->repo->view_course(request()->all(),$id);
    }

    public function view_user($id=0)
    {
        return $this->repo->view_user(request()->all(),$id);
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
