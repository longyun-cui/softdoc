<?php
namespace App\Repositories\Front;

use App\User;
use App\Models\Course;
use App\Models\Content;
use App\Models\Communication;
use App\Models\Notification;
use App\Models\Pivot_User_Collection;
use App\Models\Pivot_User_Course;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Blade;
use QrCode;

class RootRepository {

    private $model;
    public function __construct()
    {
        Blade::setEchoFormat('%s');
        Blade::setEchoFormat('e(%s)');
        Blade::setEchoFormat('nl2br(e(%s))');
    }


    // 课程模板
    public function view_item_html($id)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
            $course = Course::with([
                'user',
                'contents'=>function($query) { $query->where('p_id',0)->orderBy('id','asc'); },
                'collections'=>function($query) use ($user_id) { $query->where(['user_id' => $user_id]); }
            ])->find($id);
        }
        else
        {
            $course = Course::with([
                'user',
                'contents'=>function($query) { $query->where('p_id',0)->orderBy('id','asc'); }
            ])->find($id);
        }
        $courses[0] = $course;
        return view('frontend.component.course')->with(['courses'=>$courses])->__toString();
    }


    // 平台主页
    public function view_courses($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
            $courses = Course::with([
                'user',
                'contents'=>function($query) { $query->where('p_id',0)->orderBy('id','asc'); },
                'collections'=>function($query) use ($user_id) { $query->where(['user_id' => $user_id,'content_id' => 0]); },
                'others'=>function($query) use ($user_id) { $query->where(['user_id' => $user_id,'content_id' => 0]); }
            ])->where('active', 1)->orderBy('id','desc')->paginate(20);
        }
        else
        {
            $courses = Course::with([
                'user',
                'contents'=>function($query) { $query->where('p_id',0)->orderBy('id','asc'); }
            ])->where('active', 1)->orderBy('id','desc')->paginate(20);
        }

        foreach ($courses as $item)
        {
            $item->content_show = strip_tags($item->content);
            $img_tags = get_html_img($item->content);
            $item->img_tags = $img_tags;
        }
//        dd($lines->toArray());

        return view('frontend.root.courses')->with(['item_magnitude'=>'item-plural','getType'=>'items','courses'=>$courses]);
    }

    // 平台主页
    public function view_contents($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
            $contents = Content::with([
                'user',
//                'collections'=>function($query) use ($user_id) { $query->where(['user_id' => $user_id,'content_id' => 0]); },
//                'others'=>function($query) use ($user_id) { $query->where(['user_id' => $user_id,'content_id' => 0]); }
            ])->whereHas('course', function ($query) { $query->where('active', 1);} )
                ->orderBy('id','desc')->paginate(20);
        }
        else
        {
            $contents = Content::with([
                'user',
            ])->whereHas('course', function ($query) { $query->where('active', 1);} )
                ->orderBy('id','desc')->paginate(20);
        }


        foreach ($contents as $item)
        {
            $item->content_show = strip_tags($item->content);
            $img_tags = get_html_img($item->content);
            $item->img_tags = $img_tags;
        }
//        dd($lines->toArray());

        return view('frontend.root.contents')->with(['item_magnitude'=>'item-plural','getType'=>'items','contents'=>$contents]);
    }


    // 用户首页
    public function view_user($post_data,$id=0)
    {
//        $course_encode = $post_data['id'];
        $user_encode = $id;
        $user_decode = decode($user_encode);
        if(!$user_decode) return view('frontend.404');

        $user = User::with([
            'courses'=>function($query) { $query->orderBy('id','desc'); }
        ])->withCount('courses')->find($user_decode);
        $user->timestamps = false;
        $user->increment('visit_num');

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            $courses = Course::with([
                'user',
                'contents'=>function($query) { $query->where('p_id',0)->orderBy('id','asc'); },
                'collections'=>function($query) use ($me_id) { $query->where(['user_id' => $me_id,'content_id' => 0]); },
                'others'=>function($query) use ($me_id) { $query->where(['user_id' => $me_id,'content_id' => 0]); }
            ])->where(['user_id'=>$user_decode,'active'=>1])->orderBy('id','desc')->paginate(20);
        }
        else
        {
            $courses = Course::with([
                'user',
                'contents'=>function($query) { $query->where('p_id',0)->orderBy('id','asc'); }
            ])->where(['user_id'=>$user_decode,'active'=>1])->orderBy('id','desc')->paginate(20);
        }

        foreach ($courses as $item)
        {
            $item->content_show = strip_tags($item->content);
            $img_tags = get_html_img($item->content);
            $item->img_tags = $img_tags;
        }
//        dd($lines->toArray());

        return view('frontend.root.user')->with(['item_magnitude'=>'item-plural','getType'=>'items','data'=>$user,'courses'=>$courses]);
    }


    // 课程详情
    public function view_course($post_data,$id=0)
    {
//        $course_encode = $post_data['id'];
        $course_encode = $id;
        $course_decode = decode($course_encode);
        if(!$course_decode) return view('frontend.404');

        $content = [];
        if(!empty($post_data['content']))
        {
            $content_encode = $post_data['content'];
            $content_decode = decode($content_encode);
            if(!$content_decode) return view('frontend.404');

            if(Auth::check())
            {
                $user = Auth::user();
                $user_id = $user->id;
                $content = Content::with([
                    'collections'=>function($query) use ($user_id,$content_decode) { $query->where(['user_id' => $user_id,'content_id' => $content_decode]); },
                    'others'=>function($query) use ($user_id,$content_decode) { $query->where(['user_id' => $user_id,'content_id' => $content_decode]); }
                ])->find($content_decode);
            }
            else
            {
                $content = Content::find($content_decode);
            }
            if(!$content) return view('frontend.404');

            $content->encode_id = encode($content->id);
            $content->user->encode_id = encode($content->user->id);

            $content->timestamps = false;
            $content->increment('visit_num');
        }

        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
            $course = Course::with([
                'user',
                'contents'=>function($query) { $query->orderBy('id','asc'); },
                'collections'=>function($query) use ($user_id) { $query->where(['user_id' => $user_id,'content_id' => 0]); },
                'others'=>function($query) use ($user_id) { $query->where(['user_id' => $user_id,'content_id' => 0]); }
            ])->find($course_decode);
        }
        else
        {
            $course = Course::with([
                'user',
                'contents'=>function($query) { $query->orderBy('id','asc'); }
            ])->find($course_decode);
        }

        $course->comments_total = $course->comment_num + $course->contents->sum('comment_num');

        $course->timestamps = false;
        $course->increment('visit_num');

        $author = User::find($course->user_id);
        $author->timestamps = false;
        $author->increment('visit_num');

        $course->encode_id = encode($course->id);
        $course->user->encode_id = encode($course->user->id);

        $course->contents_recursion = $this->get_recursion($course->contents,0);


        if(!empty($post_data['content']))
        {
            if($content->user_id == $course->user_id) $item = $content;
            else return view('frontend.404');

        }
        else $item = $course;

        return view('frontend.course.course')->with(['item_magnitude'=>'item-singular','getType'=>'item','course'=>$course,'content'=>$content,'item'=>$item]);
    }




    // 收藏
    public function item_collect_save($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $course_encode = $post_data['course_id'];
            $course_decode = decode($course_encode);
            if(!$course_decode) return response_error([],"参数有误，请重试！");

            $content_encode = $post_data['content_id'];
            $content_decode = decode($content_encode);
            if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

            $course = Course::find($course_decode);
            if($course)
            {
                if($content_decode != 0)
                {
                    $content = Content::find($content_decode);
                    if(!$course && $content->course_id != $course_decode) return response_error([],"参数有误，刷新一下试试");
                }

                DB::beginTransaction();
                try
                {
                    $time = time();
                    $user = Auth::user();
                    $user->pivot_collection_courses()->attach($course_decode,['type'=>1,'content_id'=>$content_decode,'created_at'=>$time,'updated_at'=>$time]);

                    if($content_decode == 0)
                    {
                        $course->timestamps = false;
                        $course->increment('collect_num');
                    }
                    else
                    {
                        $content->timestamps = false;
                        $content->increment('collect_num');
                    }

                    $insert['type'] = 11;
                    $insert['user_id'] = $user->id;
                    $insert['course_id'] = $course_decode;
                    $insert['content_id'] = $content_decode;

                    $communication = new Communication;
                    $bool = $communication->fill($insert)->save();
                    if(!$bool) throw new Exception("insert--communication--fail");

                    $html['html'] = $this->view_item_html($course_decode);

                    DB::commit();
                    return response_success($html);
                }
                catch (Exception $e)
                {
                    DB::rollback();
//                    exit($e->getMessage());
//                    $msg = $e->getMessage();
                    $msg = '添加失败，请重试！';
                    return response_fail([], $msg);
                }
            }
            else return response_error([],"该话题不存在，刷新一下试试！");
        }
        else return response_error([],"请先登录！");

    }
    // 取消收藏
    public function item_collect_cancel($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $course_encode = $post_data['course_id'];
            $course_decode = decode($course_encode);
            if(!$course_decode) return response_error([],"该话题不存在，刷新一下试试！");

            $content_encode = $post_data['content_id'];
            $content_decode = decode($content_encode);
            if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

            $course = Course::find($course_decode);
            if($course)
            {
                if($content_decode != 0)
                {
                    $content = Content::find($content_decode);
                    if(!$course && $content->course_id != $course_decode) return response_error([],"参数有误，刷新一下试试");
                }

                DB::beginTransaction();
                try
                {
                    $user = Auth::user();
                    $user_id = $user->id;

                    $collections = Pivot_User_Collection::where(['type'=>1,'user_id'=>$user_id,'course_id'=>$course_decode,'content_id'=>$content_decode]);
                    $count = count($collections->get());
                    if($count)
                    {
                        $num = $collections->delete();
                        if($num != $count) throw new Exception("delete--pivot--fail");

                        if($content_decode == 0) $course->decrement('collect_num');
                        else $content->decrement('collect_num');
                    }

                    $insert['type'] = 12;
                    $insert['user_id'] = $user->id;
                    $insert['course_id'] = $course_decode;
                    $insert['content_id'] = $content_decode;

                    $communication = new Communication;
                    $bool = $communication->fill($insert)->save();
                    if(!$bool) throw new Exception("insert--communication--fail");

                    $html['html'] = $this->view_item_html($course_decode);

                    DB::commit();
                    return response_success($html);
                }
                catch (Exception $e)
                {
                    DB::rollback();
//                    exit($e->getMessage());
//                    $msg = $e->getMessage();
                    $msg = '操作失败，请重试！';
                    return response_fail([], $msg);
                }
            }
            else return response_error([],"该话题不存在，刷新一下试试！");

        }
        else return response_error([],"请先登录！");

    }


    // 点赞
    public function item_favor_save($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $course_encode = $post_data['course_id'];
            $course_decode = decode($course_encode);
            if(!$course_decode) return response_error([],"参数有误，请重试！");

            $content_encode = $post_data['content_id'];
            $content_decode = decode($content_encode);
            if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

            $course = Course::find($course_decode);
            if($course)
            {
                if($content_decode != 0)
                {
                    $content = Content::find($content_decode);
                    if(!$course && $content->course_id != $course_decode) return response_error([],"参数有误，刷新一下试试");
                }

                DB::beginTransaction();
                try
                {
                    $time = time();
                    $user = Auth::user();
                    $user->pivot_item_courses()->attach($course_decode,['type'=>1,'content_id'=>$content_decode,'created_at'=>$time,'updated_at'=>$time]);

                    if($content_decode == 0)
                    {
                        $course->timestamps = false;
                        $course->increment('favor_num');
                    }
                    else
                    {
                        $content->timestamps = false;
                        $content->increment('favor_num');
                    }

                    $insert['type'] = 3;
                    $insert['user_id'] = $user->id;
                    $insert['course_id'] = $course_decode;
                    $insert['content_id'] = $content_decode;

                    $communication = new Communication;
                    $bool = $communication->fill($insert)->save();
                    if(!$bool) throw new Exception("insert--communication--fail");

//                    通知对方
                    if($course->user_id != $user->id)
                    {
                        $notification_insert['type'] = 8;
                        $notification_insert['sort'] = 3;
                        $notification_insert['user_id'] = $course->user_id;
                        $notification_insert['source_id'] = $user->id;
                        $notification_insert['course_id'] = $course_decode;
                        $notification_insert['content_id'] = $content_decode;
                        $notification_insert['comment_id'] = $communication->id;

                        $notification = new Notification;
                        $bool = $notification->fill($notification_insert)->save();
                        if(!$bool) throw new Exception("insert--notification--fail");
                    }

                    $html['html'] = $this->view_item_html($course_decode);

                    DB::commit();
                    return response_success($html);
                }
                catch (Exception $e)
                {
                    DB::rollback();
//                    exit($e->getMessage());
//                    $msg = $e->getMessage();
                    $msg = '添加失败，请重试！';
                    return response_fail([], $msg);
                }
            }
            else return response_error([],"该话题不存在，刷新一下试试！");
        }
        else return response_error([],"请先登录！");

    }
    // 取消点赞
    public function item_favor_cancel($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $course_encode = $post_data['course_id'];
            $course_decode = decode($course_encode);
            if(!$course_decode) return response_error([],"该话题不存在，刷新一下试试！");

            $content_encode = $post_data['content_id'];
            $content_decode = decode($content_encode);
            if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

            $course = Course::find($course_decode);
            if($course)
            {
                if($content_decode != 0)
                {
                    $content = Content::find($content_decode);
                    if(!$course && $content->course_id != $course_decode) return response_error([],"参数有误，刷新一下试试");
                }

                DB::beginTransaction();
                try
                {
                    $user = Auth::user();
                    $user_id = $user->id;

                    $favors = Pivot_User_Course::where(['type'=>1,'user_id'=>$user_id,'course_id'=>$course_decode,'content_id'=>$content_decode]);
                    $count = count($favors->get());
                    if($count)
                    {
                        $num = $favors->delete();
                        if($num != $count) throw new Exception("delete--pivot--fail");

                        if($content_decode == 0) $course->decrement('favor_num');
                        else $content->decrement('favor_num');
                    }

                    $insert['type'] = 4;
                    $insert['user_id'] = $user->id;
                    $insert['course_id'] = $course_decode;
                    $insert['content_id'] = $content_decode;

                    $communication = new Communication;
                    $bool = $communication->fill($insert)->save();
                    if(!$bool) throw new Exception("insert--communication--fail");

                    $html['html'] = $this->view_item_html($course_decode);

                    DB::commit();
                    return response_success($html);
                }
                catch (Exception $e)
                {
                    DB::rollback();
//                    exit($e->getMessage());
//                    $msg = $e->getMessage();
                    $msg = '操作失败，请重试！';
                    return response_fail([], $msg);
                }
            }
            else return response_error([],"该话题不存在，刷新一下试试！");

        }
        else return response_error([],"请先登录！");

    }




    // 添加评论
    public function item_comment_save($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
            'content.required' => '内容不能为空',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required',
            'content' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $course_encode = $post_data['course_id'];
            $course_decode = decode($course_encode);
            if(!$course_decode) return response_error([],"参数有误，刷新一下试试");

            $content_encode = $post_data['content_id'];
            $content_decode = decode($content_encode);
            if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

            $user = Auth::user();
            $insert['type'] = $post_data['type'];
            $insert['user_id'] = $user->id;
            $insert['course_id'] = $course_decode;
            $insert['content_id'] = $content_decode;
            $insert['content'] = $post_data['content'];

            DB::beginTransaction();
            try
            {
                $course = Course::find($course_decode);
                if(!$course) return response_error([],"该课题不存在，刷新一下试试");

                if($content_decode != 0)
                {
                    $content = Content::find($content_decode);
                    if(!$course && $content->course_id != $course_decode) return response_error([],"参数有误，刷新一下试试");

                    $content->timestamps = false;
                    $content->increment('comment_num');
                }
                else
                {
                    $course->timestamps = false;
                    $course->increment('comment_num');
                }

                $communication = new Communication;
                $bool = $communication->fill($insert)->save();
                if(!$bool) throw new Exception("insert--communication--fail");

//                通知对方
                if($course->user_id != $user->id)
                {
                    $notification_insert['type'] = 8;
                    $notification_insert['sort'] = 1;
                    $notification_insert['user_id'] = $course->user_id;
                    $notification_insert['source_id'] = $user->id;
                    $notification_insert['course_id'] = $course_decode;
                    $notification_insert['content_id'] = $content_decode;
                    $notification_insert['comment_id'] = $communication->id;

                    $notification = new Notification;
                    $bool = $notification->fill($notification_insert)->save();
                    if(!$bool) throw new Exception("insert--notification--fail");
                }

                $html["html"] = view('frontend.component.comment')->with("comment",$communication)->__toString();

                DB::commit();
                return response_success($html);
            }
            catch (Exception $e)
            {
                DB::rollback();
//                exit($e->getMessage());
//                $msg = $e->getMessage();
                $msg = '添加失败，请重试！';
                return response_fail([], $msg);
            }
        }
        else return response_error([],"请先登录！");

    }
    // 获取评论
    public function item_comment_get($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        $type = $post_data['type'];

        $course_encode = $post_data['course_id'];
        $course_decode = decode($course_encode);
        if(!$course_decode) return response_error([],"参数有误，刷新一下试试");

        $content_encode = $post_data['content_id'];
        $content_decode = decode($content_encode);
        if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
            $comments = Communication::with([
                'user',
                'reply'=>function($query) { $query->with(['user']); },
//                'dialogs'=>function($query) use ($user_id) { $query->with([
//                    'user',
//                    'reply'=>function($query1) { $query1->with(['user']); },
//                    'favors'=>function($query) use ($user_id)  { $query->where(['type'=>5,'user_id'=>$user_id]); }
//                ])->orderBy('id','desc'); },
                'favors'=>function($query) use ($user_id) { $query->where(['type'=>5,'user_id'=>$user_id]); }
            ])->withCount('dialogs')
            ->where(['type'=>$type,'reply_id'=>0,'course_id'=>$course_decode,'content_id'=>$content_decode]);
        }
        else
        {
            $comments = Communication::with([
                'user',
                'reply'=>function($query) { $query->with(['user']); }//,
//                'dialogs'=>function($query) { $query->with([
//                    'user',
//                    'reply'=>function($query1) { $query1->with(['user']); }
//                ])->orderBy('id','desc'); },
            ])->withCount('dialogs')
            ->where(['type'=>$type,'reply_id'=>0,'course_id'=>$course_decode,'content_id'=>$content_decode]);
        }

        if(!empty($post_data['min_id']) && $post_data['min_id'] != 0) $comments->where('id', '<', $post_data['min_id']);

        $comments = $comments->orderBy('id','desc')->paginate(10);

        foreach ($comments as $comment)
        {
            if($comment->dialogs_count)
            {
                $comment->dialog_max_id = 0;
                $comment->dialog_min_id = 0;
                $comment->dialog_more = 'more';
                $comment->dialog_more_text = '还有 <span class="text-blue">'.$comment->dialogs_count.'</span> 回复';
            }
            else
            {
                $comment->dialog_max_id = 0;
                $comment->dialog_min_id = 0;
                $comment->dialog_more = 'none';
                $comment->dialog_more_text = '没有了';
            }

//            if(count($comment->dialogs))
//            {
//                $comment->dialogs = $comment->dialogs->take(1);
//
//                $comment->dialog_max_id = $comment->dialogs->first()->id;
//                $comment->dialog_min_id = $comment->dialogs->last()->id;
//                if($comment->dialogs->count() >= 1)
//                {
//                    $comment->dialog_more = 'more';
//                    $comment->dialog_more_text = '更多';
//                }
//                else
//                {
//                    $comment->dialog_more = 'none';
//                    $comment->dialog_more_text = '没有了';
//                }
//            }
//            else
//            {
//                $comment->dialog_max_id = 0;
//                $comment->dialog_min_id = 0;
//                $comment->dialog_more = 'none';
//                $comment->dialog_more_text = '没有了';
//            }
        }

        if(!$comments->isEmpty())
        {
            $return["html"] = view('frontend.component.comments')->with("communications",$comments)->__toString();
            $return["max_id"] = $comments->first()->id;
            $return["min_id"] = $comments->last()->id;
            $return["more"] = ($comments->count() >= 10) ? 'more' : 'none';
        }
        else
        {
            $return["html"] = '';
            $return["max_id"] = 0;
            $return["min_id"] = 0;
            $return["more"] = 'none';
        }

        return response_success($return);

    }
    // 用户评论
    public function item_comment_get_html($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        $course_encode = $post_data['course_id'];
        $course_decode = decode($course_encode);
        if(!$course_decode) return response_error([],"参数有误，刷新一下试试");

        $content_encode = $post_data['content_id'];
        $content_decode = decode($content_encode);
        if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

        $communications = Communication::with(['user'])
            ->where(['course_id'=>$course_decode,'content_id'=>$content_decode])->orderBy('id','desc')->get();

        $html["html"] = view('frontend.component.comments')->with("communications",$communications)->__toString();
        return response_success($html);

    }


    // 添加回复
    public function item_reply_save($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
            'comment_id.required' => '参数有误',
            'content.required' => '回复不能为空',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required',
            'comment_id' => 'required',
            'content' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $course_encode = $post_data['course_id'];
            $course_decode = decode($course_encode);
            if(!$course_decode) return response_error([],"该话题不存在，刷新一下试试！");

            $content_encode = $post_data['content_id'];
            $content_decode = decode($content_encode);
            if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

            $comment_encode = $post_data['comment_id'];
            $comment_decode = decode($comment_encode);
            if(!$comment_decode) return response_error([],"参数有误，刷新一下试试！");

            $user = Auth::user();
            $insert['type'] = $post_data['type'];
            $insert['user_id'] = $user->id;
            $insert['course_id'] = $course_decode;
            $insert['content_id'] = $content_decode;
            $insert['reply_id'] = $comment_decode;
            $insert['content'] = $post_data['content'];

            DB::beginTransaction();
            try
            {
                $course = Course::find($course_decode);
                if(!$course) return response_error([],"该课题不存在，刷新一下试试");

                if($content_decode != 0)
                {
                    $content = Content::find($content_decode);
                    if(!$course && $content->course_id != $course_decode) return response_error([],"参数有误，刷新一下试试");

                    $content->timestamps = false;
                    $content->increment('comment_num');
                }
                else
                {
                    $course->timestamps = false;
                    $course->increment('comment_num');
                }

                $comment = Communication::find($comment_decode);
                if(!$comment) return response_error([],"该评论不存在，刷新一下试试！");
                $comment->timestamps = false;
                $comment->increment('comment_num');

                if($comment->dialog_id)
                {
                    $insert['dialog_id'] = $comment->dialog_id;
                    $dialog = Communication::find($insert['dialog_id']);
                    $dialog->timestamps = false;
                    $dialog->increment('comment_num');
                }
                else
                {
                    $insert['dialog_id'] = $comment_decode;
                }

                $communication = new Communication;
                $bool = $communication->fill($insert)->save();
                if(!$bool) throw new Exception("insert--communication--fail");

//                通知对方
                if($comment->user_id != $user->id)
                {
                    $notification_insert['type'] = 8;
                    $notification_insert['sort'] = 2;
                    $notification_insert['user_id'] = $comment->user_id;
                    $notification_insert['source_id'] = $user->id;
                    $notification_insert['course_id'] = $course_decode;
                    $notification_insert['content_id'] = $content_decode;
                    $notification_insert['comment_id'] = $communication->id;
                    $notification_insert['reply_id'] = $comment->id;

                    $notification = new Notification;
                    $bool = $notification->fill($notification_insert)->save();
                    if(!$bool) throw new Exception("insert--notification--fail");
                }

                $html["html"] = view('frontend.component.reply')->with("reply",$communication)->__toString();

                DB::commit();
                return response_success($html);
            }
            catch (Exception $e)
            {
                DB::rollback();
//                exit($e->getMessage());
//                $msg = $e->getMessage();
                $msg = '添加失败，请重试！';
                return response_fail([], $msg);
            }
        }
        else return response_error([],"请先登录！");

    }
    // 获取回复
    public function item_reply_get($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
            'comment_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required',
            'comment_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        $type = $post_data['type'];

        $course_encode = $post_data['course_id'];
        $course_decode = decode($course_encode);
        if(!$course_decode) return response_error([],"参数有误，刷新一下试试");

        $content_encode = $post_data['content_id'];
        $content_decode = decode($content_encode);
        if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

        $comment_encode = $post_data['comment_id'];
        $comment_decode = decode($comment_encode);
        if(!$comment_decode) return response_error([],"参数有误，刷新一下试试");

        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
            $comments = Communication::with([
                'user',
                'reply'=>function($query) { $query->with(['user']); },
                'favors'=>function($query) use ($user_id) { $query->where(['type'=>5,'user_id'=>$user_id]); }
            ])->where(['type'=>$type,'course_id'=>$course_decode,'content_id'=>$content_decode,'dialog_id'=>$comment_decode])
                ->where('reply_id','<>',0);
        }
        else
        {
            $comments = Communication::with([
                'user',
                'reply'=>function($query) { $query->with(['user']); },
            ])->where(['type'=>$type,'course_id'=>$course_decode,'content_id'=>$content_decode,'dialog_id'=>$comment_decode])
                ->where('reply_id','<>',0);
        }

        if(!empty($post_data['min_id']) && $post_data['min_id'] != 0) $comments->where('id', '<', $post_data['min_id']);

        $comments = $comments->orderBy('id','desc')->paginate(10);

        if(!$comments->isEmpty())
        {
            $return["html"] = view('frontend.component.replies')->with("communications",$comments)->__toString();
            $return["max_id"] = $comments->first()->id;
            $return["min_id"] = $comments->last()->id;
            $return["more"] = ($comments->count() >= 10) ? 'more' : 'none';
        }
        else
        {
            $return["html"] = '';
            $return["max_id"] = 0;
            $return["min_id"] = 0;
            $return["more"] = 'none';
        }

        return response_success($return);

    }


    // 评论点赞
    public function item_comment_favor_save($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
            'comment_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required',
            'comment_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $course_encode = $post_data['course_id'];
            $course_decode = decode($course_encode);
            if(!$course_decode) return response_error([],"该话题不存在，刷新一下试试！");

            $content_encode = $post_data['content_id'];
            $content_decode = decode($content_encode);
            if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

            $comment_encode = $post_data['comment_id'];
            $comment_decode = decode($comment_encode);
            if(!$comment_decode) return response_error([],"参数有误，刷新一下试试！");

            $user = Auth::user();
            $insert['type'] = $post_data['type'];
            $insert['user_id'] = $user->id;
            $insert['course_id'] = $course_decode;
            $insert['content_id'] = $content_decode;
            $insert['reply_id'] = $comment_decode;

            DB::beginTransaction();
            try
            {
                $course = Course::find($course_decode);
                if(!$course) return response_error([],"该课题不存在，刷新一下试试");

                if($content_decode != 0)
                {
                    $content = Content::find($content_decode);
                    if(!$course && $content->course_id != $course_decode) return response_error([],"参数有误，刷新一下试试");

                    $content->timestamps = false;
                    $content->increment('favor_num');
                }
                else
                {
                    $course->timestamps = false;
                    $course->increment('favor_num');
                }

                $comment = Communication::find($comment_decode);
                if(!$comment) return response_error([],"该评论不存在，刷新一下试试！");
                $comment->timestamps = false;
                $comment->increment('favor_num');

                $communication = new Communication;
                $bool = $communication->fill($insert)->save();
                if(!$bool) throw new Exception("insert--communication--fail");

//                通知对方
                if($comment->user_id != $user->id)
                {
                    $notification_insert['type'] = 8;
                    $notification_insert['sort'] = 5;
                    $notification_insert['user_id'] = $comment->user_id;
                    $notification_insert['source_id'] = $user->id;
                    $notification_insert['course_id'] = $course_decode;
                    $notification_insert['content_id'] = $content_decode;
                    $notification_insert['comment_id'] = $communication->id;
                    $notification_insert['reply_id'] = $comment_decode;

                    $notification = new Notification;
                    $bool = $notification->fill($notification_insert)->save();
                    if(!$bool) throw new Exception("insert--notification--fail");
                }

                DB::commit();
                return response_success();
            }
            catch (Exception $e)
            {
                DB::rollback();
//                exit($e->getMessage());
//                $msg = $e->getMessage();
                $msg = '添加失败，请重试！';
                return response_fail([], $msg);
            }
        }
        else return response_error([],"请先登录！");

    }
    // 评论取消赞
    public function item_comment_favor_cancel($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'course_id.required' => '参数有误',
            'content_id.required' => '参数有误',
            'comment_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'course_id' => 'required',
            'content_id' => 'required',
            'comment_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $course_encode = $post_data['course_id'];
            $course_decode = decode($course_encode);
            if(!$course_decode) return response_error([],"该话题不存在，刷新一下试试！");

            $content_encode = $post_data['content_id'];
            $content_decode = decode($content_encode);
            if(!$content_decode && $content_decode != 0) return response_error([],"参数有误，刷新一下试试");

            $comment_encode = $post_data['comment_id'];
            $comment_decode = decode($comment_encode);
            if(!$comment_decode) return response_error([],"参数有误，刷新一下试试！");

                DB::beginTransaction();
                try
                {
                    $user = Auth::user();
                    $user_id = $user->id;

                    $comment = Communication::find($comment_decode);
                    if(!$comment && $comment->user_id != $user_id) return response_error([],"参数有误，刷新一下试试");
                    $comment->decrement('favor_num');

                    $favors = Communication::where([
                        'type'=>5,'user_id'=>$user_id,
                        'course_id'=>$course_decode,'content_id'=>$content_decode,'reply_id'=>$comment_decode
                    ]);
                    $count = count($favors->get());
                    if($count)
                    {
                        $num = $favors->delete();
                        if($num != $count) throw new Exception("delete--commnucation--fail");
                    }

                    DB::commit();
                    return response_success();
                }
                catch (Exception $e)
                {
                    DB::rollback();
//                    exit($e->getMessage());
//                    $msg = $e->getMessage();
                    $msg = '操作失败，请重试！';
                    return response_fail([], $msg);
                }

        }
        else return response_error([],"请先登录！");

    }





    // 顺序排列
    function get_recursion($result, $parent_id=0, $level=0)
    {
        /*记录排序后的类别数组*/
        static $list = array();

        foreach ($result as $k => $v)
        {
            if($v->p_id == $parent_id)
            {
                $v->level = $level;

                foreach($list as $key=>$val)
                {
                    if($val->id == $parent_id) $list[$key]->has_child = 1;
                }

                /*将该类别的数据放入list中*/
                $list[] = $v;

                $this->get_recursion($result, $v->id, $level+1);
            }
        }

        return $list;
    }




}