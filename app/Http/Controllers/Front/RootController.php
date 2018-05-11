<?php

namespace App\Http\Controllers\Front;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Front\RootRepository;


class RootController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new RootRepository;
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
