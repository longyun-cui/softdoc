<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RootItem extends Model
{
    //
    protected $table = "root_items";
    protected $fillable = [
        'category', 'type', 'sort', 'form', 'active', 'order', 'user_id', 'item_id', 'p_id', 'version',
        'title', 'subtitle', 'description', 'content', 'custom', 'link_url', 'cover_pic',
        'time_point', 'time_type', 'start_time', 'end_time', 'order', 'rank',
        'is_shared', 'visit_num', 'share_num'
    ];

    // 定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
//    public $timestamps = false;

    // 此属性决定插入和取出数据库的格式，默认datetime格式，'U'是int(10)
    protected $dateFormat = 'U';

    // 应被转换为日期的属性
//    protected $dates = [];
//    protected $dates = ['created_at', 'updated_at', 'disabled_at'];


    // 如果数据库存的是datetime或者没定义$dateFormat，又想取出的时候是int...
//    public function getDates()
//    {
//        return array('created_at','updated_at');
//        return array(); // 原形返回；
//    }

    // 属性类型转换
//    protected $casts = [
//        'created_at' => 'int',
//        'updated_at' => 'integer',
//    ];




    /**
     * 获取当前时间
     *
     * @return int
     */
//    public function freshTimestamp() {
//        return time();
//    }

    /**
     * 避免转换时间戳为时间字符串
     *
     * @param DateTime|int $value
     * @return DateTime|int
     */
//    public function fromDateTime($value) {
//        return $value;
//    }

    /**
     * select的时候避免转换时间为Carbon
     *
     * @param mixed $value
     * @return mixed
     */
//    protected function asDateTime($value) {
//        return $value;
//    }

    /**
     * 从数据库获取的为获取时间戳格式
     *
     * @return string
     */
//    public function getDateFormat() {
//        return 'U';
//    }




    // 用户信息
    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // 用户信息（备用）
    function user_()
    {
        return $this->belongsTo('App\User','user_id_','id');
    }

    // 子节点
    function items()
    {
        return $this->hasMany('App\Models\RootItem','item_id','id');
    }

    // 父节点
    function belong_item()
    {
        return $this->belongsTo('App\Models\RootItem','item_id','id');
    }

    // 转发内容
    function forward_item()
    {
        return $this->belongsTo('App\Models\RootItem','item_id','id');
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
        return $this->hasMany('App\Models\RootItem','item_id','id');
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
