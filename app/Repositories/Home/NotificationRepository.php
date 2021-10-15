<?php
namespace App\Repositories\Home;

use App\User;
use App\Models\Doc\Doc_Content;
use App\Models\Doc\Doc_Communication;
use App\Models\Doc\Doc_Notification;
use App\Models\Doc\Doc_Pivot_User_Collection;

use App\Repositories\Common\CommonRepository;
use Response, Auth, Validator, DB, Exception;
use QrCode;

class NotificationRepository {

    private $model;
    public function __construct()
    {
//        $this->model = new Table;
    }


    public function comment($post_data)
    {
        $user = Auth::user();
        $query = Doc_Notification::with([
            'source'=>function($query) { $query->select('id','name'); },
            'course'=>function($query) { $query->select('id','title'); },
            'chapter'=>function($query) { $query->select('id','title'); },
            'comment'=>function($query) { $query->select('id','content'); },
            'reply'=>function($query) { $query->select('id','user_id','reply_id','content')
                ->with(['user','reply'=>function($query) { $query->with(['user']); } ]); }
        ])->where(['type'=>8,'user_id'=>$user->id])->orderBy('id','desc');

        $notifications = $query->paginate(20);
//        dd($notifications->toArray());

        $num = $query->where(['is_read'=>0])->update(['is_read'=>1]);

        $count = Doc_Notification::where(['is_read'=>0,'type'=>8,'user_id'=>$user->id])->count();
        if(!$count) $count = '';
        view()->share('notification_count', $count);

        return view('home.notification.comment')->with(['datas'=>$notifications,'menu_notification_comment'=>'active']);
    }


    public function favor($post_data)
    {
        $user = Auth::user();
        $query = Doc_Notification::with([
            'source'=>function($query) { $query->select('id','name'); },
            'course'=>function($query) { $query->select('id','title'); },
            'chapter'=>function($query) { $query->select('id','title'); },
            'comment'=>function($query) { $query->select('id','content'); },
            'reply'=>function($query) { $query->select('id','user_id','reply_id','content')
                ->with(['user','reply'=>function($query) { $query->with(['user']); } ]); }
        ])->where(['type'=>8,'user_id'=>$user->id])
            ->where(function ($query) { $query->where('sort', 3)->orWhere('sort', 5);})
//            ->whereIn('sort',[3,5])
            ->orderBy('id','desc');

        $notifications = $query->paginate(20);
//        dd($notifications->toArray());

        $num = $query->where(['is_read'=>0])->update(['is_read'=>1]);

        return view('home.notification.favor')->with(['datas'=>$notifications,'menu_notification_favor'=>'active']);
    }


}