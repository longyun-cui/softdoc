<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "root_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'email', 'wx_unionid', 'nickname', 'true_name', 'description', 'portrait_img', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'wx_unionid', 'remember_token',
    ];

    protected $dateFormat = 'U';


    // 课程
    function items()
    {
        return $this->hasMany('App\Models\RootItem','user_id','id');
    }

    // 收藏
    function pivot_collection()
    {
        return $this->belongsToMany('App\Models\RootItem','pivot_user_collection','user_id','item_id');
    }

    // 与我相关的内容
    function pivot_item()
    {
        return $this->belongsToMany('App\Models\RootItem','pivot_user_item','user_id','item_id')
            ->withPivot('type')->withTimestamps();
    }


}
