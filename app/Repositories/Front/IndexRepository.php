<?php
namespace App\Repositories\Front;

use App\User;
use App\Models\RootItem;
use App\Models\Content;
use App\Models\Communication;
use App\Models\Notification;
use App\Models\Pivot_User_Collection;
use App\Models\Pivot_User_Item;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Blade;
use Carbon\Carbon;
use QrCode;

class IndexRepository {

    private $model;
    public function __construct()
    {
        Blade::setEchoFormat('%s');
        Blade::setEchoFormat('e(%s)');
        Blade::setEchoFormat('nl2br(e(%s))');
    }

    // 平台主页
    public function view_root($post_data)
    {
//        $item = RootItem::first();
//        dd($item->created_at);

//        $headers = apache_request_headers();
//        $headers = getallheaders();
//        dd($headers);
//        $header = request()->header();
//        dd($header);

        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
        }
        else $user_id = 0;

        $items = RootItem::with([
            'user',
            'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
        ])->where('is_shared','>=',99)->orderBy('id','desc')->get();

        return view('frontend.entrance.root')->with(['items'=>$items]);
    }


    // 内容模板
    public function view_item_html($id)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            $item = RootItem::with([
                'user',
                'contents'=>function($query) { $query->where('p_id',0)->orderBy('id','asc'); },
                'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
            ])->find($id);
        }
        else
        {
            $item = RootItem::with([
                'user',
                'contents'=>function($query) { $query->where('p_id',0)->orderBy('id','asc'); }
            ])->find($id);
        }
        $items[0] = $item;
        return view('frontend.component.items')->with(['items'=>$items])->__toString();
    }




    // 用户首页
    public function view_user($post_data,$id=0)
    {
//        $user_encode = $id;
//        $user_decode = decode($user_encode);
//        if(!$user_decode) return view('frontend.404');

        $user_id = $id;

        $user = User::with([
            'items'=>function($query) { $query->orderBy('id','desc'); }
        ])->withCount('items')->find($user_id);

        if(!$user) return view('frontend.errors.404');

        $user->timestamps = false;
        $user->increment('visit_num');

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            $items = RootItem::with([
                'user',
                'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
            ])->where('user_id',$user_id)->where('is_shared','>=',99)->orderBy('id','desc')->get();
        }
        else
        {
            $items = RootItem::with([
                'user'
            ])->where('user_id',$user_id)->where('is_shared','>=',99)->orderBy('id','desc')->get();
        }

        foreach ($items as $item)
        {
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }
//        dd($lines->toArray());

        return view('frontend.entrance.user')
            ->with(['item_magnitude'=>'item-plural','getType'=>'items','data'=>$user,'items'=>$items]);
    }




    // 【待办事】
    public function view_home_todolist($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) use($user_id) { $query->with([
                    'user',
                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
                ])->wherePivot('type',11)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $items = $query->pivot_item;

//            // Method 2
//            $query = Pivot_User_Item::with([
//                    'item'=>function($query) { $query->with(['user']); }
//                ])->where(['type'=>11,'user_id'=>$user_id])->orderby('id','desc')->get();
//            dd($query->toArray());
        }
        else $items = [];

        return view('frontend.entrance.todolist')->with(['items'=>$items,'root_todolist_active'=>'active']);
    }

    // 【日程】
    public function view_home_schedule($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;

            // Method 1
//            $query = User::with([
//                'pivot_item'=>function($query) use($user_id) { $query->with([
//                    'user',
//                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
//                ])->wherePivot('type',12)->orderby('pivot_user_item.id','desc'); }
//            ])->find($user_id);
//            $items = $query->pivot_item;

            $items = [];
        }
        else $items = [];

        return view('frontend.entrance.schedule')->with(['items'=>$items,'root_schedule_active'=>'active']);
    }

    // 【收藏内容】
    public function view_home_collection($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) use($user_id) { $query->with([
                    'user',
                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
                ])->wherePivot('type',1)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $items = $query->pivot_item;
        }
        else $items = [];

        return view('frontend.entrance.collection')->with(['items'=>$items,'root_collection_active'=>'active']);
    }

    // 【点赞内容】
    public function view_home_favor($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) use($user_id) { $query->with([
                    'user',
                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
                ])->wherePivot('type',9)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $items = $query->pivot_item;
        }
        else $items = [];

        return view('frontend.entrance.favor')->with(['items'=>$items,'root_favor_active'=>'active']);
    }

    // 【发现】
    public function view_home_discovery($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
        }
        else $user_id = 0;

        $items = RootItem::with([
            'user',
            'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
        ])->where('is_shared','>=',99)->orderBy('id','desc')->get();

        return view('frontend.entrance.discovery')->with(['items'=>$items,'root_discovery_active'=>'active']);
    }

    // 【好友圈】
    public function view_home_circle($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) { $query->with(['user'])->wherePivot('type',9)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $items = $query->pivot_item;
        }
        else $items = [];

        return view('frontend.entrance.circle')->with(['items'=>$items,'root_circle_active'=>'active']);
    }



    // 【内容详情】
    public function view_item($post_data,$id=0)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
        }
        else $user_id = 0;

        $item = RootItem::with([
            'user',
            'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
        ])->find($id);
        if($item)
        {
            $item->timestamps = false;
            $item->increment('visit_num');

            if($item->category == 11)
            {
                if($item->item_id == 0) $parent_item = $item;
                else $parent_item = RootItem::with(['contents'])->find($item->item_id);

                $contents_recursion = $this->get_recursion($parent_item->contents,0);
                foreach ($contents_recursion as $v)
                {
                    $v->content_show = strip_tags($v->content);
                    $v->img_tags = get_html_img($v->content);
                }
                view()->share(['contents_recursion'=>$contents_recursion]);

                $parent_item->visit_total = $parent_item->visit_num + $parent_item->contents->sum('visit_num');
                $parent_item->comments_total = $parent_item->comment_num + $parent_item->contents->sum('comment_num');
                view()->share(['parent_item'=>$parent_item]);
            }
            else if($item->category == 18)
            {
                if($item->item_id == 0) $parent_item = $item;
                else $parent_item = RootItem::with(['contents'])->find($item->item_id);

                $time_points = $parent_item->contents;
                foreach ($time_points as $v)
                {
                    $v->content_show = strip_tags($v->content);
                    $v->img_tags = get_html_img($v->content);
                }
                view()->share(['time_points'=>$time_points]);

                $parent_item->visit_total = $parent_item->visit_num + $parent_item->contents->sum('visit_num');
                $parent_item->comments_total = $parent_item->comment_num + $parent_item->contents->sum('comment_num');
                view()->share(['parent_item'=>$parent_item]);
            }

        }
        else return view('frontend.errors.404');

        return view('frontend.entrance.item')->with(['item'=>$item]);
    }



    // 【获取日程】
    public function ajax_get_schedule($post_data)
    {
        if(Auth::check())
        {
            $messages = [
                'year.required' => '参数有误',
                'month.required' => '参数有误'
            ];
            $v = Validator::make($post_data, [
                'year' => 'required',
                'month' => 'required'
            ], $messages);
            if ($v->fails())
            {
                $errors = $v->errors();
                return response_error([],$errors->first());
            }

            $user = Auth::user();
            $user_id = $user->id;

            $year = $post_data['year'];
            $month = $post_data['month'];
            $monthStr = $year."-".$month;
            $start = strtotime($monthStr); // 指定月份月初时间戳
            $end = mktime(23, 59, 59, date('m', strtotime($monthStr))+1, 00); // 指定月份月末时间戳

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) use($user_id,$start,$end) { $query->with([
                    'user',
                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
                ])->wherePivot('type',12)->where(function ($query) use($start,$end) {
                    $query
                        ->where(function ($query) use($start,$end) {$query->where('start_time', '>=', $start)->where('start_time', '<=', $end);})
                        ->orWhere(function ($query) use($start,$end) {$query->where('end_time', '>=', $start)->where('end_time', '<=', $end);})
                        ->orWhere(function ($query) use($start,$end) {$query->where('start_time', '<=', $start)->where('end_time', '>=', $end);});
                })->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);

//            $query->where(function ($query) use($start_time,$end_time) {
//                $query
//                    ->where(function ($query) use($start_time,$end_time) {
//                        $query->where('start_time', '>=', $start_time)->where('start_time', '<=', $end_time);})
//                    ->orWhere(function ($query) use($start_time,$end_time) {
//                        $query->where('end_time', '>=', $start_time)->where('end_time', '<=', $end_time);})
//                    ->orWhere(function ($query) use($start_time,$end_time) {
//                        $query->where('start_time', '<=', $start_time)->where('end_time', '>=', $end_time);});
//            });

            $items = $query->pivot_item;

            $html =  view('frontend.'.env('TEMPLATE').'.component.items')->with(['items'=>$items])->__toString();
            return response_success(['html'=>$html]);

        }
        else return response_error([],'请先登录！');
    }



    // 【添加】
    public function item_add_this($post_data,$type=0)
    {
        if(Auth::check())
        {
            $messages = [
                'type.required' => '参数有误',
                'item_id.required' => '参数有误'
            ];
            $v = Validator::make($post_data, [
                'type' => 'required',
                'item_id' => 'required'
            ], $messages);
            if ($v->fails())
            {
                $errors = $v->errors();
                return response_error([],$errors->first());
            }

            $item_id = $post_data['item_id'];
            $item = RootItem::find($item_id);
            if($item)
            {
                $user = Auth::user();
                $pivot = Pivot_User_Item::where(['type'=>$type,'user_id'=>$user->id,'item_id'=>$item_id])->first();
                if(!$pivot)
                {
                    DB::beginTransaction();
                    try
                    {
                        $time = time();
                        $user->pivot_item()->attach($item_id,['type'=>$type,'created_at'=>$time,'updated_at'=>$time]);

                        $item->timestamps = false;
                        $item->increment('favor_num');


//                        $insert['type'] = 3;
//                        $insert['user_id'] = $user->id;
//                        $insert['item_id'] = $item_id;
//
//                        $communication = new Communication;
//                        $bool = $communication->fill($insert)->save();
//                        if(!$bool) throw new Exception("insert--communication--fail");
//
////                    通知对方
//                        if($item->user_id != $user->id)
//                        {
//                            $notification_insert['type'] = 8;
//                            $notification_insert['sort'] = 3;
//                            $notification_insert['user_id'] = $item->user_id;
//                            $notification_insert['source_id'] = $user->id;
//                            $notification_insert['item_id'] = $item_id;
//                            $notification_insert['comment_id'] = $communication->id;
//
//                            $notification = new Notification;
//                            $bool = $notification->fill($notification_insert)->save();
//                            if(!$bool) throw new Exception("insert--notification--fail");
//                        }
//
//                        $html['html'] = $this->view_item_html($item_id);


                        DB::commit();
                        return response_success([]);
                    }
                    catch (Exception $e)
                    {
                        DB::rollback();
                        $msg = '操作失败，请重试！';
//                        $msg = $e->getMessage();
//                        exit($e->getMessage());
                        return response_fail([],$msg);
                    }
                }
                else
                {
                    if($type == 1) $msg = '已经收藏过了';
                    else if($type == 9) $msg = '成功点赞';
                    else if($type == 11) $msg = '已经在待办事列表';
                    else if($type == 12) $msg = '已经在日程列表';
                    else $msg = '';
                    return response_fail(['reason'=>'exist'],$msg);
                }
            }
            else return response_fail([],'内容不存在！');

        }
        else return response_error([],'请先登录！');
    }
    // 【移除】
    public function item_remove_this($post_data,$type=0)
    {
        if(Auth::check())
        {
            $messages = [
                'type.required' => '参数有误',
                'item_id.required' => '参数有误'
            ];
            $v = Validator::make($post_data, [
                'type' => 'required',
                'item_id' => 'required'
            ], $messages);
            if ($v->fails())
            {
                $errors = $v->errors();
                return response_error([],$errors->first());
            }

            $item_id = $post_data['item_id'];
            $item = RootItem::find($item_id);
            if($item)
            {
                $user = Auth::user();
                $pivots = Pivot_User_Item::where(['type'=>$type,'user_id'=>$user->id,'item_id'=>$item_id])->get();
                if(count($pivots) > 0)
                {
                    DB::beginTransaction();
                    try
                    {
                        $num = Pivot_User_Item::where(['type'=>$type,'user_id'=>$user->id,'item_id'=>$item_id])->delete();
                        if($num != count($pivots)) throw new Exception("delete--pivots--fail");

                        $item->timestamps = false;
                        $item->decrement('favor_num');

//                        $insert['type'] = 4;
//                        $insert['user_id'] = $user->id;
//                        $insert['item_id'] = $item_id;
//
//                        $communication = new Communication;
//                        $bool = $communication->fill($insert)->save();
//                        if(!$bool) throw new Exception("insert--communication--fail");
//
//                        $html['html'] = $this->view_item_html($item_id);

                        DB::commit();
                        return response_success([]);
                    }
                    catch (Exception $e)
                    {
                        DB::rollback();
                        $msg = '操作失败，请重试！';
//                        $msg = $e->getMessage();
//                        exit($e->getMessage());
                        return response_fail([],$msg);
                    }
                }
                else
                {
                    if($type == 1) $msg = '移除收藏成功';
                    else if($type == 9) $msg = '';
                    else if($type == 11) $msg = '移除待办事成功';
                    else if($type == 12) $msg = '移除日程成功';
                    else $msg = '';
                    return response_fail(['reason'=>'exist'],$msg);
                }
            }
            else return response_fail([],'内容不存在！');
        }
        else return response_error([],'请先登录！');

    }




    // 添加评论
    public function item_comment_save($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'item_id.required' => '参数有误',
            'content.required' => '内容不能为空',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'item_id' => 'required',
            'content' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $item_id = $post_data['item_id'];
            if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

            $user = Auth::user();
            $insert['type'] = $post_data['type'];
            $insert['user_id'] = $user->id;
            $insert['item_id'] = $item_id;
            $insert['content'] = $post_data['content'];

            DB::beginTransaction();
            try
            {
                $item = RootItem::find($item_id);
                if(!$item) return response_error([],"该内容不存在，刷新一下试试");

                $item->timestamps = false;
                $item->increment('comment_num');

                $communication = new Communication;
                $bool = $communication->fill($insert)->save();
                if(!$bool) throw new Exception("insert--communication--fail");

//                通知对方
                if($item->user_id != $user->id)
                {
                    $notification_insert['type'] = 8;
                    $notification_insert['sort'] = 1;
                    $notification_insert['user_id'] = $item->user_id;
                    $notification_insert['source_id'] = $user->id;
                    $notification_insert['item_id'] = $item_id;
                    $notification_insert['comment_id'] = $communication->id;

                    $notification = new Notification;
                    $bool = $notification->fill($notification_insert)->save();
                    if(!$bool) throw new Exception("insert--notification--fail");
                }

                $html["html"] = view('frontend.'.env('TEMPLATE').'.component.comment')->with("comment",$communication)->__toString();

                DB::commit();
                return response_success($html);
            }
            catch (Exception $e)
            {
                DB::rollback();
                $msg = '添加失败，请重试！';
                $msg = $e->getMessage();
//                exit($e->getMessage());
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
            'item_id.required' => '参数有误'
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'item_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        $type = $post_data['type'];

        $item_id = $post_data['item_id'];
        if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

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
            ->where(['type'=>$type,'reply_id'=>0,'item_id'=>$item_id]);
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
            ->where(['type'=>$type,'reply_id'=>0,'item_id'=>$item_id]);
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
            $return["html"] = view('frontend.'.env('TEMPLATE').'.component.comments')->with("communications",$comments)->__toString();
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
            'item_id.required' => '参数有误'
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'item_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        $item_encode = $post_data['item_id'];
        $item_decode = decode($item_encode);
        if(!$item_decode) return response_error([],"参数有误，刷新一下试试");

        $communications = Communication::with(['user'])
            ->where(['item_id'=>$item_decode])->orderBy('id','desc')->get();

        $html["html"] = view('frontend.component.comments')->with("communications",$communications)->__toString();
        return response_success($html);

    }


    // 添加回复
    public function item_reply_save($post_data)
    {
        $messages = [
            'type.required' => '参数有误',
            'item_id.required' => '参数有误',
            'comment_id.required' => '参数有误',
            'content.required' => '回复不能为空',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'item_id' => 'required',
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
            $item_id = $post_data['item_id'];
            if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

            $comment_encode = $post_data['comment_id'];
            $comment_decode = decode($comment_encode);
            if(!$comment_decode) return response_error([],"参数有误，刷新一下试试！");

            $user = Auth::user();
            $insert['type'] = $post_data['type'];
            $insert['user_id'] = $user->id;
            $insert['item_id'] = $item_id;
            $insert['reply_id'] = $comment_decode;
            $insert['content'] = $post_data['content'];

            DB::beginTransaction();
            try
            {
                $item = RootItem::find($item_id);
                if(!$item) return response_error([],"该内容不存在，刷新一下试试");

                $item->timestamps = false;
                $item->increment('comment_num');

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
                    $notification_insert['item_id'] = $item_id;
                    $notification_insert['comment_id'] = $communication->id;
                    $notification_insert['reply_id'] = $comment->id;

                    $notification = new Notification;
                    $bool = $notification->fill($notification_insert)->save();
                    if(!$bool) throw new Exception("insert--notification--fail");
                }

                $html["html"] = view('frontend.'.env('TEMPLATE').'.component.reply')->with("reply",$communication)->__toString();

                DB::commit();
                return response_success($html);
            }
            catch (Exception $e)
            {
                DB::rollback();
                $msg = '添加失败，请重试！';
                $msg = $e->getMessage();
//                exit($e->getMessage());
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
            'item_id.required' => '参数有误',
            'comment_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'item_id' => 'required',
            'comment_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        $type = $post_data['type'];

        $item_id = $post_data['item_id'];
        if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

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
            ])->where(['type'=>$type,'item_id'=>$item_id,'dialog_id'=>$comment_decode])
                ->where('reply_id','<>',0);
        }
        else
        {
            $comments = Communication::with([
                'user',
                'reply'=>function($query) { $query->with(['user']); },
            ])->where(['type'=>$type,'item_id'=>$item_id,'dialog_id'=>$comment_decode])
                ->where('reply_id','<>',0);
        }

        if(!empty($post_data['min_id']) && $post_data['min_id'] != 0) $comments->where('id', '<', $post_data['min_id']);

        $comments = $comments->orderBy('id','desc')->paginate(10);

        if(!$comments->isEmpty())
        {
            $return["html"] = view('frontend.'.env('TEMPLATE').'.component.replies')->with("communications",$comments)->__toString();
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
            'item_id.required' => '参数有误',
            'comment_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'item_id' => 'required',
            'comment_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $item_id = $post_data['item_id'];
            if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

            $comment_encode = $post_data['comment_id'];
            $comment_decode = decode($comment_encode);
            if(!$comment_decode) return response_error([],"参数有误，刷新一下试试！");

            $user = Auth::user();
            $insert['type'] = $post_data['type'];
            $insert['user_id'] = $user->id;
            $insert['item_id'] = $item_id;
            $insert['reply_id'] = $comment_decode;

            DB::beginTransaction();
            try
            {
                $item = RootItem::find($item_id);
                if(!$item) return response_error([],"该内容不存在，刷新一下试试");

                $item->timestamps = false;
                $item->increment('favor_num');

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
                    $notification_insert['item_id'] = $item_id;
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
                $msg = '添加失败，请重试！';
//                $msg = $e->getMessage();
//                exit($e->getMessage());
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
            'item_id.required' => '参数有误',
            'comment_id.required' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'type' => 'required',
            'item_id' => 'required',
            'comment_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $item_id = $post_data['item_id'];
            if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

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
                        'type'=>5,
                        'user_id'=>$user_id,
                        'item_id'=>$item_id,
                        'reply_id'=>$comment_decode
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
                    $msg = '操作失败，请重试！';
//                    $msg = $e->getMessage();
//                    exit($e->getMessage());
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