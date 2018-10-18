<?php
namespace App\Repositories\Front;

use App\User;
use App\Models\RootItem;
use App\Models\Content;
use App\Models\Communication;
use App\Models\Notification;
use App\Models\Pivot_User_Item;
use App\Models\Pivot_User_Relation;

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
            $me = Auth::user();
            $me_id = $me->id;
            $notification_count = Notification::where(['user_id'=>$me_id,'is_read'=>0])->count();
            view()->share('notification_count',$notification_count);
        }
        else $me_id = 0;

        $items = RootItem::with([
            'user',
            'forward_item'=>function($query) { $query->with('user'); },
            'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
        ])->where('is_shared','>=',99)->orderBy('id','desc')->paginate(20);
        view()->share('items_type','paginate');
//        dd($items->toArray());

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

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
                'contents'=>function($query) { $query->where(['active'=>1,'p_id'=>0])->orderBy('id','asc'); },
                'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
            ])->find($id);
        }
        else
        {
            $item = RootItem::with([
                'user',
                'contents'=>function($query) { $query->where(['active'=>1,'p_id'=>0])->orderBy('id','asc'); }
            ])->find($id);
        }
        $items[0] = $item;
        return view('frontend.'.env('TEMPLATE').'.component.items')->with(['items'=>$items])->__toString();
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
                'forward_item'=>function($query) { $query->with('user'); },
                'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
            ])->where('user_id',$user_id)->where('is_shared','>=',99)->orderBy('id','desc')->get();

            if($user_id != $me_id)
            {
                $relation = Pivot_User_Relation::where(['mine_user_id'=>$me_id,'relation_user_id'=>$user_id])->first();
                view()->share(['relation'=>$relation]);
            }
        }
        else
        {
            $items = RootItem::with([
                'user',
                'forward_item'=>function($query) { $query->with('user'); }
            ])->where('user_id',$user_id)->where('is_shared','>=',99)->orderBy('id','desc')->get();
        }

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }
//        dd($lines->toArray());

        return view('frontend.entrance.user')->with(['data'=>$user,'items'=>$items]);
    }

    // 【Ta关注的人】
    public function view_user_follow($post_data,$id=0)
    {
        $Ta = User::withCount('items')->find($id);
        if(!$Ta) return view('frontend.errors.404');

        $pivot_users = Pivot_User_Relation::with(['relation_user'])->where(['mine_user_id'=>$id])->whereIn('relation_type',[21,41])
            ->orderBy('id','desc')->get();

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            if($id != $me_id)
            {
                $relation = Pivot_User_Relation::where(['mine_user_id'=>$me_id,'relation_user_id'=>$id])->first();
                view()->share(['relation'=>$relation]);
            }

            $me_users = Pivot_User_Relation::where(['mine_user_id'=>$me_id])->get();

            foreach ($pivot_users as $num => $user)
            {
                $relationship = $me_users->where('relation_user_id', $user->relation_user_id);
                if(count($relationship) > 0)
                {
                    $user->relation_with_me = $relationship->first()->relation_type;
//                    if($user->relation_user_id == $me_id) unset($pivot_users[$num]);
                }
                else $user->relation_with_me = 0;
            }
        }
        else
        {
            foreach ($pivot_users as $user)
            {
                $user->relation_with_me = 0;
            }
        }

        return view('frontend.entrance.user-follow')->with(['data'=>$Ta,'users'=>$pivot_users]);
    }
    // 【关注Ta的人】
    public function view_user_fans($post_data,$id=0)
    {
        $Ta = User::withCount('items')->find($id);
        if(!$Ta) return view('frontend.errors.404');

        $pivot_users = Pivot_User_Relation::with(['relation_user'])->where(['mine_user_id'=>$id])->whereIn('relation_type',[21,71])
            ->orderBy('id','desc')->get();

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            if($id != $me_id)
            {
                $relation = Pivot_User_Relation::where(['mine_user_id'=>$me_id,'relation_user_id'=>$id])->first();
                view()->share(['relation'=>$relation]);
            }

            $me_users = Pivot_User_Relation::where(['mine_user_id'=>$me_id])->get();

            foreach ($pivot_users as $num => $user)
            {
                $relationship = $me_users->where('relation_user_id', $user->relation_user_id);
                if(count($relationship) > 0)
                {
                    $user->relation_with_me = $relationship->first()->relation_type;
//                    if($user->relation_user_id == $me_id) unset($pivot_users[$num]);
                }
                else $user->relation_with_me = 0;
            }
        }
        else
        {
            foreach ($pivot_users as $user)
            {
                $user->relation_with_me = 0;
            }
        }

        return view('frontend.entrance.user-fans')->with(['data'=>$Ta,'users'=>$pivot_users]);
    }




    // 【添加关注】
    public function user_relation_add($post_data)
    {
        $messages = [
            'user_id.required' => '参数有误',
            'user_id.numeric' => '参数有误',
            'user_id.exists' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'user_id' => 'required|numeric|exists:root_users,id'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $user_id = $post_data['user_id'];
            $user = User::find($user_id);

            DB::beginTransaction();
            try
            {
                $me_relation = Pivot_User_Relation::where(['mine_user_id'=>$me_id,'relation_user_id'=>$user_id])->first();
                if($me_relation)
                {
                    if($me_relation->relation_type == 71) $me_relation->relation_type = 21;
                    else $me_relation->relation_type = 41;
                    $me_relation->save();
                }
                else
                {
                    $me_relation = new Pivot_User_Relation;
                    $me_relation->mine_user_id = $me_id;
                    $me_relation->relation_user_id = $user_id;
                    $me_relation->relation_type = 41;
                    $me_relation->save();
                }
                $me->timestamps = false;
                $me->increment('follow_num');

                $it_relation = Pivot_User_Relation::where(['mine_user_id'=>$user_id,'relation_user_id'=>$me_id])->first();
                if($it_relation)
                {
                    if($it_relation->relation_type == 41) $it_relation->relation_type = 21;
                    else $it_relation->relation_type = 71;
                    $it_relation->save();
                }
                else
                {
                    $it_relation = new Pivot_User_Relation;
                    $it_relation->mine_user_id = $user_id;
                    $it_relation->relation_user_id = $me_id;
                    $it_relation->relation_type = 71;
                    $it_relation->save();
                }
                $user->timestamps = false;
                $user->increment('fans_num');

                DB::commit();
                return response_success(['relation_type'=>$me_relation->relation_type]);
            }
            catch (Exception $e)
            {
                DB::rollback();
                $msg = '添加关注失败，请重试！';
//                $msg = $e->getMessage();
//                exit($e->getMessage());、
                return response_fail([], $msg);
            }
        }
        else return response_error([],"请先登录！");
    }
    // 【取消关注】
    public function user_relation_remove($post_data)
    {
        $messages = [
            'user_id.required' => '参数有误',
            'user_id.numeric' => '参数有误',
            'user_id.exists' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'user_id' => 'required|numeric|exists:root_users,id'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $user_id = $post_data['user_id'];
            $user = User::find($user_id);

            DB::beginTransaction();
            try
            {
                $me_relation = Pivot_User_Relation::where(['mine_user_id'=>$me_id,'relation_user_id'=>$user_id])->first();
                if($me_relation)
                {
                    if($me_relation->relation_type == 21) $me_relation->relation_type = 71;
                    else if($me_relation->relation_type == 41) $me_relation->relation_type = 91;
                    else $me_relation->relation_type = 91;
                    $me_relation->save();
                }
                $me->timestamps = false;
                $me->decrement('follow_num');

                $it_relation = Pivot_User_Relation::where(['mine_user_id'=>$user_id,'relation_user_id'=>$me_id])->first();
                if($it_relation)
                {
                    if($it_relation->relation_type == 21) $it_relation->relation_type = 41;
                    else if($it_relation->relation_type == 71) $it_relation->relation_type = 92;
                    else $it_relation->relation_type = 92;
                    $it_relation->save();
                }
                $user->timestamps = false;
                $user->decrement('fans_num');

                DB::commit();
                return response_success(['relation_type'=>$me_relation->relation_type]);
            }
            catch (Exception $e)
            {
                DB::rollback();
                $msg = '取消关注失败，请重试！';
//                $msg = $e->getMessage();
//                exit($e->getMessage());、
                return response_fail([], $msg);
            }
        }
        else return response_error([],"请先登录！");
    }




    // 【我关注的人】
    public function view_relation_follow($post_data)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $users = Pivot_User_Relation::with(['relation_user'])->where(['mine_user_id'=>$me_id])->whereIn('relation_type',[21,41])->get();
            foreach ($users as $user)
            {
                $user->relation_with_me = $user->relation_type;
            }
//            dd($users->toArray());
        }
        else return response_error([],"请先登录！");

        return view('frontend.entrance.relation-follow')->with(['users'=>$users]);
    }
    // 【关注我的人】
    public function view_relation_fans($post_data)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $users = Pivot_User_Relation::with(['relation_user'])->where(['mine_user_id'=>$me_id])->whereIn('relation_type',[21,71])->get();
            foreach ($users as $user)
            {
                $user->relation_with_me = $user->relation_type;
            }
        }
        else return response_error([],"请先登录！");

        return view('frontend.entrance.relation-fans')->with(['users'=>$users]);
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
                    'forward_item'=>function($query) { $query->with('user'); },
                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
                ])->wherePivot('type',31)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $items = $query->pivot_item;

//            // Method 2
//            $query = Pivot_User_Item::with([
//                    'item'=>function($query) { $query->with(['user']); }
//                ])->where(['type'=>11,'user_id'=>$user_id])->orderby('id','desc')->get();
//            dd($query->toArray());
        }
        else $items = [];

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-todolist')->with(['items'=>$items,'root_todolist_active'=>'active']);
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

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-schedule')->with(['items'=>$items,'root_schedule_active'=>'active']);
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
                ])->wherePivot('type',21)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $items = $query->pivot_item;
        }
        else $items = [];

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-collection')->with(['items'=>$items,'root_collection_active'=>'active']);
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
                    'forward_item'=>function($query) { $query->with('user'); },
                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
                ])->wherePivot('type',11)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $items = $query->pivot_item;
        }
        else $items = [];

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-favor')->with(['items'=>$items,'root_favor_active'=>'active']);
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
            'forward_item'=>function($query) { $query->with('user'); },
            'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
        ])->where('is_shared','>=',99)->orderBy('id','desc')->get();

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-discovery')->with(['items'=>$items,'root_discovery_active'=>'active']);
    }

    // 【好友圈】
    public function view_home_follow($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
        }
        else $user_id = 0;
//
//        $items = RootItem::with([
//            'user',
//            'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
//        ])->where('is_shared','>=',99)->orderBy('id','desc')->get();

        $user = User::with([
            'relation_items'=>function($query) use($user_id) {$query->with([
                'user',
                'forward_item'=>function($query) { $query->with('user'); },
                'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
            ])->where('pivot_user_relation.relation_type','<=', 50)->where('root_items.is_shared','>=', 41); }
        ])->find($user_id);

        $items = $user->relation_items;
        $items = $items->sortByDesc('id');
//        dd($items->toArray());

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-follow')->with(['items'=>$items,'root_follow_active'=>'active']);
    }

    // 【好友圈】
    public function view_home_circle($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
        }
        else $user_id = 0;
//
//        $items = RootItem::with([
//            'user',
//            'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
//        ])->where('is_shared','>=',99)->orderBy('id','desc')->get();

        $user = User::with([
            'relation_items'=>function($query) use($user_id) { $query->with([
                'user',
                'forward_item'=>function($query) { $query->with('user'); },
                'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
            ])->where('pivot_user_relation.relation_type',21)->where('root_items.is_shared','>=', 41); }
        ])->find($user_id);

        $items = $user->relation_items;
        $items = $items->sortByDesc('id');
//        dd($items->toArray());

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-circle')->with(['items'=>$items,'root_circle_active'=>'active']);
    }




    // 【消息提醒】
    public function view_home_notification($post_data)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
        }
        else $me_id = 0;

        $count = Notification::where(['is_read'=>0,'type'=>11,'user_id'=>$me_id])->count();
        if($count)
        {
            $notifications = Notification::with([
                'source',
                'item'=>function($query) {
                    $query->with([
                        'user',
                        'forward_item'=>function($query) { $query->with('user'); }
                    ]);
                },
                'communication'=>function($query) { $query->with(['user']); },
                'reply'=>function($query) {
                    $query->with([
                        'user',
                        'reply'=>function($query) { $query->with('user'); }
                    ]);
                }
            ])->where(['type'=>11,'is_read'=>0,'user_id'=>$me_id])->orderBy('id','desc')->get();

            $update_num = Notification::where(['type'=>11,'is_read'=>0,'user_id'=>$me_id])->update(['is_read'=>1]);
            view()->share('notification_type', 'new');
        }
        else
        {
            $notifications = Notification::with([
                'source',
                'item'=>function($query) {
                    $query->with([
                        'user',
                        'forward_item'=>function($query) { $query->with('user'); }
                    ]);
                },
                'communication'=>function($query) { $query->with(['user']); },
                'reply'=>function($query) {
                    $query->with([
                        'user',
                        'reply'=>function($query) { $query->with('user'); }
                    ]);
                }
            ])->where(['type'=>11,'user_id'=>$me_id])->orderBy('id','desc')->paginate(10);
            view()->share('notification_type', 'paginate');
        }


//        dd($notifications->toArray());

//        foreach ($items as $item)
//        {
//            $item->custom_decode = json_decode($item->custom);
//            $item->content_show = strip_tags($item->content);
//            $item->img_tags = get_html_img($item->content);
//        }
//
        return view('frontend.entrance.root-notification')->with(['notifications'=>$notifications,'root_notification_active'=>'active']);
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
                if($item->item_id == 0)
                {
                    $parent_item = $item;
                    $parent_item->load([
                        'contents'=>function($query) { $query->where('active',1)->orderBy('rank','asc'); }
                    ]);
                }
                else $parent_item = RootItem::with([
                    'contents'=>function($query) { $query->where('active',1)->orderBy('rank','asc'); }
                ])->find($item->item_id);

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
                if($item->item_id == 0)
                {
                    $parent_item = $item;
                    $parent_item->load([
                        'contents'=>function($query) {
                            $query->where('active',1);
                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
                            $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
                            $query->orderBy('time_point','asc');
                        }
                    ]);
                }
                else
                {
                    $parent_item = RootItem::with([
                        'contents'=>function($query) {
                            $query->where('active',1);
                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
                            $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
                            $query->orderBy('time_point','asc');
                        }
                    ])->find($item->item_id);
                }

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

            $item->custom_decode = json_decode($item->custom);

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
                ])->wherePivot('type',32)->where(function ($query) use($start,$end) {
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
            foreach ($items as $item)
            {
                $item->calendar_days = $this->handleScheduleDays($item->start_time, $item->end_time);
            }

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
                $me = Auth::user();
                $pivot = Pivot_User_Item::where(['type'=>$type,'user_id'=>$me->id,'item_id'=>$item_id])->first();
                if(!$pivot)
                {
                    DB::beginTransaction();
                    try
                    {
                        $time = time();
                        $me->pivot_item()->attach($item_id,['type'=>$type,'created_at'=>$time,'updated_at'=>$time]);
//

                        // 记录机制 Communication
                        if($type == 11)
                        {
                            // 点赞
                            $item->timestamps = false;
                            $item->increment('favor_num');
                            $communication_insert['type'] = 11;
                            $communication_insert['sort'] = 1;
                        }
                        else if($type == 21)
                        {
                            // 添加收藏
                            $item->timestamps = false;
                            $item->increment('collection_num');
                            $communication_insert['type'] = 21;
                            $communication_insert['sort'] = 1;
                        }
                        else if($type == 31)
                        {
                            // 添加待办
                            $item->timestamps = false;
                            $item->increment('working_num');
                            $communication_insert['type'] = 31;
                            $communication_insert['sort'] = 1;
                        }
                        else if($type == 32)
                        {
                            // 添加日程
                            $item->timestamps = false;
                            $item->increment('agenda_num');
                            $communication_insert['type'] = 32;
                            $communication_insert['sort'] = 1;
                        }

                        $communication_insert['user_id'] = $item->user_id;
                        $communication_insert['source_id'] = $me->id;
                        $communication_insert['item_id'] = $item_id;

                        $communication = new Communication;
                        $bool = $communication->fill($communication_insert)->save();
                        if(!$bool) throw new Exception("insert--communication--fail");


                        // 通知机制 Communication
                        if($type == 11)
                        {
                            // 点赞
                            if($item->user_id != $me->id)
                            {
                                $notification_insert['type'] = 11;
                                $notification_insert['sort'] = 11;
                                $notification_insert['user_id'] = $item->user_id;
                                $notification_insert['source_id'] = $me->id;
                                $notification_insert['item_id'] = $item_id;

                                $notification_once = Notification::where($notification_insert)->first();
                                if(!$notification_once)
                                {
                                    $notification = new Notification;
                                    $bool = $notification->fill($notification_insert)->save();
                                    if(!$bool) throw new Exception("insert--notification--fail");
                                }
                            }
                        }

//                        $html['html'] = $this->view_item_html($item_id);

                        DB::commit();
                        return response_success([]);
                    }
                    catch (Exception $e)
                    {
                        DB::rollback();
                        $msg = '操作失败，请重试！';
                        $msg = $e->getMessage();
//                        exit($e->getMessage());
                        return response_fail([],$msg);
                    }
                }
                else
                {
                    if($type == 11) $msg = '成功点赞';
                    else if($type == 21) $msg = '已经收藏过了';
                    else if($type == 31) $msg = '已经在待办事列表';
                    else if($type == 32) $msg = '已经在日程列表';
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
                $me = Auth::user();
                $pivots = Pivot_User_Item::where(['type'=>$type,'user_id'=>$me->id,'item_id'=>$item_id])->get();
                if(count($pivots) > 0)
                {
                    DB::beginTransaction();
                    try
                    {
                        $num = Pivot_User_Item::where(['type'=>$type,'user_id'=>$me->id,'item_id'=>$item_id])->delete();
                        if($num != count($pivots)) throw new Exception("delete--pivots--fail");

                        // 记录机制 Communication
                        if($type == 11)
                        {
                            // 移除点赞
                            $item->timestamps = false;
                            $item->decrement('favor_num');
                            $communication_insert['type'] = 11;
                            $communication_insert['sort'] = 9;
                        }
                        else if($type == 21)
                        {
                            // 移除收藏
                            $item->timestamps = false;
                            $item->decrement('collection_num');
                            $communication_insert['type'] = 21;
                            $communication_insert['sort'] = 9;
                        }
                        else if($type == 31)
                        {
                            // 移除待办
                            $item->timestamps = false;
                            $item->decrement('working_num');
                            $communication_insert['type'] = 31;
                            $communication_insert['sort'] = 9;
                        }
                        else if($type == 32)
                        {
                            // 移除日程
                            $item->timestamps = false;
                            $item->decrement('agenda_num');
                            $communication_insert['type'] = 32;
                            $communication_insert['sort'] = 9;
                        }

                        $communication_insert['user_id'] = $item->user_id;
                        $communication_insert['source_id'] = $me->id;
                        $communication_insert['item_id'] = $item_id;

                        $communication = new Communication;
                        $bool = $communication->fill($communication_insert)->save();
                        if(!$bool) throw new Exception("insert--communication--fail");

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
                    if($type == 11) $msg = '';
                    else if($type == 21) $msg = '移除收藏成功';
                    else if($type == 31) $msg = '移除待办事成功';
                    else if($type == 32) $msg = '移除日程成功';
                    else $msg = '';
                    return response_fail(['reason'=>'exist'],$msg);
                }
            }
            else return response_fail([],'内容不存在！');
        }
        else return response_error([],'请先登录！');

    }
    // 【转发】
    public function item_forward($post_data)
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
                $me = Auth::user();
                $me_id = $me->id;

                DB::beginTransaction();
                try
                {
                    $mine = new RootItem;
                    $post_data['user_id'] = $me_id;
                    $post_data['category'] = 99;
                    $post_data['is_shared'] = 100;
                    $bool = $mine->fill($post_data)->save();
                    if($bool)
                    {
                        $item->timestamps = false;
                        $item->increment('share_num');
                    }
                    else throw new Exception("insert--item--fail");

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
            $me = Auth::user();
            $me_id = $me->id;

            $item_id = $post_data['item_id'];
            if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

            $communication_insert['type'] = 1;
            $communication_insert['user_id'] = $me_id;
            $communication_insert['item_id'] = $item_id;
            $communication_insert['content'] = $post_data['content'];
            $communication_insert['support'] = !empty($post_data['support']) ? $post_data['support'] : 0;

            DB::beginTransaction();
            try
            {
                $item = RootItem::find($item_id);
                if(!$item) return response_error([],"该内容不存在，刷新一下试试");

                $item->timestamps = false;
                $item->increment('comment_num');

                $communication = new Communication;
                $bool = $communication->fill($communication_insert)->save();
                if(!$bool) throw new Exception("insert--communication--fail");

                // 通知对方
                if($item->user_id != $me_id)
                {
                    $notification_insert['type'] = 11;
                    $notification_insert['sort'] = 1;
                    $notification_insert['user_id'] = $item->user_id;
                    $notification_insert['source_id'] = $me_id;
                    $notification_insert['item_id'] = $item_id;
                    $notification_insert['communication_id'] = $communication->id;

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
//                $msg = $e->getMessage();
//                exit($e->getMessage());、
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
//                    'favors'=>function($query) use ($user_id)  { $query->where(['type'=>11,'user_id'=>$user_id]); }
//                ])->orderBy('id','desc'); },
                'favors'=>function($query) use ($user_id) { $query->where(['type'=>11,'user_id'=>$user_id]); }
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

        if(!empty($post_data['support']))
        {
            if(in_array($post_data['support'], [0,1,2]))
            {
                if($post_data['support'] != 0) $comments->where('support', $post_data['support']);
            }
            else
            {
                return response_error([],"参数有误");
            }
        }

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
            $me = Auth::user();
            $me_id = $me->id;

            $item_id = $post_data['item_id'];
            if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

            $comment_encode = $post_data['comment_id'];
            $comment_decode = decode($comment_encode);
            if(!$comment_decode) return response_error([],"参数有误，刷新一下试试！");

            $communication_insert['type'] = 1;
            $communication_insert['user_id'] = $me_id;
            $communication_insert['item_id'] = $item_id;
            $communication_insert['reply_id'] = $comment_decode;
            $communication_insert['content'] = $post_data['content'];

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
                    $communication_insert['dialog_id'] = $comment->dialog_id;
                    $dialog = Communication::find($communication_insert['dialog_id']);
                    $dialog->timestamps = false;
                    $dialog->increment('comment_num');
                }
                else
                {
                    $communication_insert['dialog_id'] = $comment_decode;
                }

                $communication = new Communication;
                $bool = $communication->fill($communication_insert)->save();
                if(!$bool) throw new Exception("insert--communication--fail");

                // 通知对方
                if($comment->user_id != $me_id)
                {
                    $notification_insert_1['type'] = 11;
                    $notification_insert_1['sort'] = 2;
                    $notification_insert_1['user_id'] = $comment->user_id;
                    $notification_insert_1['source_id'] = $me_id;
                    $notification_insert_1['item_id'] = $item_id;
                    $notification_insert_1['communication_id'] = $communication->id;
                    $notification_insert_1['reply_id'] = $comment->id;

                    $notification_1 = new Notification;
                    $bool = $notification_1->fill($notification_insert_1)->save();
                    if(!$bool) throw new Exception("insert--notification--fail");
                }

                if(($item->user_id != $me_id) && ($item->user_id != $comment->user_id))
                {
                    $notification_insert_2['type'] = 11;
                    $notification_insert_2['sort'] = 3;
                    $notification_insert_2['user_id'] = $item->user_id;
                    $notification_insert_2['source_id'] = $me_id;
                    $notification_insert_2['item_id'] = $item_id;
                    $notification_insert_2['communication_id'] = $communication->id;
                    $notification_insert_2['reply_id'] = $comment->id;

                    $notification_2 = new Notification;
                    $bool = $notification_2->fill($notification_insert_2)->save();
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
//                $msg = $e->getMessage();
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
                'favors'=>function($query) use ($user_id) { $query->where(['type'=>11,'user_id'=>$user_id]); }
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
            $me = Auth::user();
            $me_id = $me->id;

            $item_id = $post_data['item_id'];
            if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

            $comment_encode = $post_data['comment_id'];
            $comment_decode = decode($comment_encode);
            if(!$comment_decode) return response_error([],"参数有误，刷新一下试试！");

            $communication_insert['type'] = 11;
            $communication_insert['user_id'] = $me_id;
            $communication_insert['item_id'] = $item_id;
            $communication_insert['reply_id'] = $comment_decode;

            DB::beginTransaction();
            try
            {
                $item = RootItem::find($item_id);
                if(!$item) return response_error([],"该内容不存在，刷新一下试试");

                $comment = Communication::find($comment_decode);
                if(!$comment) return response_error([],"该评论不存在，刷新一下试试！");

                $comment->timestamps = false;
                $comment->increment('favor_num');

                $communication = new Communication;
                $bool = $communication->fill($communication_insert)->save();
                if(!$bool) throw new Exception("insert--communication--fail");

//                通知对方
                if($comment->user_id != $me_id)
                {
                    $notification_insert_1['type'] = 11;
                    $notification_insert_1['sort'] = 12;
                    $notification_insert_1['user_id'] = $comment->user_id;
                    $notification_insert_1['source_id'] = $me_id;
                    $notification_insert_1['item_id'] = $item_id;
                    $notification_insert_1['communication_id'] = $communication->id;
                    $notification_insert_1['reply_id'] = $comment_decode;

                    $notification_1 = new Notification;
                    $bool = $notification_1->fill($notification_insert_1)->save();
                    if(!$bool) throw new Exception("insert--notification--fail");
                }

                if(($item->user_id != $me_id) && ($item->user_id != $comment->user_id))
                {
                    $notification_insert_2['type'] = 11;
                    $notification_insert_2['sort'] = 13;
                    $notification_insert_2['user_id'] = $item->user_id;
                    $notification_insert_2['source_id'] = $me_id;
                    $notification_insert_2['item_id'] = $item_id;
                    $notification_insert_2['communication_id'] = $communication->id;
                    $notification_insert_2['reply_id'] = $comment->id;

                    $notification_2 = new Notification;
                    $bool = $notification_2->fill($notification_insert_2)->save();
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
            $me = Auth::user();
            $me_id = $me->id;

            $item_id = $post_data['item_id'];
            if(!is_numeric($item_id)) return response_error([],"参数有误，刷新一下试试");

            $comment_encode = $post_data['comment_id'];
            $comment_decode = decode($comment_encode);
            if(!$comment_decode) return response_error([],"参数有误，刷新一下试试！");

            DB::beginTransaction();
            try
            {
                $comment = Communication::find($comment_decode);
                if(!$comment && $comment->user_id != $me_id) return response_error([],"参数有误，刷新一下试试");
                $comment->decrement('favor_num');

                $favors = Communication::where([
                    'type'=>11,
                    'user_id'=>$me_id,
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




    public function handleScheduleDays($start_time,$end_time)
    {
        $data_days = "";
        if(($start_time != 0) && ($end_time != 0))
        {
            $day_start = strtotime(date("Y-n-j",$start_time));
            for($i=$day_start;$i<=$end_time;$i=$i+(3600*24))
            {
                $data_days .= "calendar-day-".date("Y-m-j",$i)." ";
            }
        }
        else if(($start_time == 0) || ($end_time == 0))
        {
            if($end_time == 0) $data_days .= "calendar-day-".date("Y-m-j", $start_time)." ";
            if($start_time == 0) $data_days .= "calendar-day-".date("Y-m-j", $end_time)." ";
        }
        return $data_days;
    }

    public function handleScheduleWeeks($start_time,$end_time)
    {
        $data_year_weeks = "";
        $day_start = strtotime(date("Y-n-j",$start_time));
        $year_week_start = $day_start - ((date("N",$start_time)-1)*3600*24);
        for($i=$year_week_start;$i<=$end_time;$i=$i+(3600*24*7))
        {
            $data_year_weeks .= "calendar-week-".date("Y.W",$i)." ";
        }
        return $data_year_weeks;
    }




}