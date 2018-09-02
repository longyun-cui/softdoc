<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    //
    protected $table = "contents";
    protected $fillable = [
        'sort', 'type', 'active', 'user_id', 'item_id', 'p_id', 'order', 'title', 'description', 'content',
        'is_shared', 'visit_num', 'share_num'
    ];
    protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at', 'disabled_at'];

    public function getDates()
    {
        return array('created_at','updated_at');
//        return array(); // 原形返回；
    }


    // 管理员
    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // 课程
    function item()
    {
        return $this->belongsTo('App\Models\Item','item_id','id');
    }

    // 父节点
    function parent()
    {
        return $this->belongsTo('App\Models\Content','p_id','id');
    }

    // 子节点
    function children()
    {
        return $this->hasMany('App\Models\Content','p_id','id');
    }

    // 评论
    function communications()
    {
        return $this->hasMany('App\Models\Communication','content_id','id');
    }

    // 收藏
    function collections()
    {
        return $this->hasMany('App\Models\Pivot_User_Collection','content_id','id');
    }

    // 其他人的
    function others()
    {
        return $this->hasMany('App\Models\Pivot_User_Course','content_id','id');
    }

    /**
     * 获得此人的所有标签。
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }




}
