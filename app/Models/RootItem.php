<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RootItem extends Model
{
    //
    protected $table = "root_items";
    protected $fillable = [
        'category', 'type', 'sort', 'form', 'active', 'user_id', 'item_id', 'p_id',
        'title', 'subtitle', 'description', 'content', 'custom', 'link_url', 'cover_pic',
        'time_type', 'start_time', 'end_time', 'order', 'rank',
        'is_shared', 'visit_num', 'share_num'
    ];
    protected $dateFormat = 'U';

//    protected $dates = ['created_at', 'updated_at', 'disabled_at'];

    public function getDates()
    {
//        return array('created_at','updated_at');
        return array(); // 原形返回；
    }


    // 管理员
    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // 子节点
    function items()
    {
        return $this->hasMany('App\Models\RootItem','item_id','id');
    }

    // 父节点
    function parent()
    {
        return $this->belongsTo('App\Models\RootItem','p_id','id');
    }

    // 子节点
    function children()
    {
        return $this->hasMany('App\Models\RootItem','p_id','id');
    }

    // 内容
    function contents()
    {
        return $this->hasMany('App\Models\Content','item_id','id');
    }

    // 评论
    function communications()
    {
        return $this->hasMany('App\Models\Communication','item_id','id');
    }

    // 评论
    function comments()
    {
        return $this->hasMany('App\Models\Communication','item_id','id');
    }

    // 收藏
    function collections()
    {
        return $this->hasMany('App\Models\Pivot_User_Collection','item_id','id');
    }

    // 其他人的
    function pivot_item_relation()
    {
        return $this->hasMany('App\Models\Pivot_User_Item','item_id','id');
    }

    // 与我相关的话题
    function pivot_collection_course_users()
    {
        return $this->belongsToMany('App\User','pivot_user_collection','item_id','user_id');
    }

    // 与我相关的话题
    function pivot_collection_chapter_users()
    {
        return $this->belongsToMany('App\User','pivot_user_collection','item_id','user_id');
    }

    /**
     * 获得此人的所有标签。
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }




}
