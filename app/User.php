<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'moblie', 'email', 'nickname', 'truename', 'description', 'portrait_img', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dateFormat = 'U';


    // 课程
    function courses()
    {
        return $this->hasMany('App\Models\Course','user_id','id');
    }

    // 与我相关的话题
    function pivot_collection_courses()
    {
        return $this->belongsToMany('App\Models\Course','pivot_user_collection','user_id','course_id');
    }

    // 与我相关的话题
    function pivot_collection_chapters()
    {
        return $this->belongsToMany('App\Models\Content','pivot_user_collection','user_id','content_id');
    }

    // 与我相关的话题
    function pivot_item_courses()
    {
        return $this->belongsToMany('App\Models\Course','pivot_user_course','user_id','course_id');
    }


}
