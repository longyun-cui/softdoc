<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;

class Doc_Menu extends Model
{
    //
    protected $table = "root_menu";
    protected $fillable = [
        'category', 'sort', 'type', 'admin_id', 'active',
        'name', 'title', 'subtitle', 'description', 'content', 'custom', 'link_url', 'cover_pic',
        'visit_num', 'share_num'
    ];
    protected $dateFormat = 'U';

//    protected $dates = ['created_at','updated_at'];
//    public function getDates()
//    {
//        return array(); // 原形返回；
//        return array('created_at','updated_at');
//    }


    function admin()
    {
        return $this->belongsTo('App\Administrator','admin_id','id');
    }

    // 一对多 关联的内容
    function items()
    {
        return $this->hasMany('App\Models\Doc_Item','menu_id','id');
    }

    // 多对多 关联的内容
    function pivot_items()
    {
        return $this->belongsToMany('App\Models\Doc_Item','pivot_menu_item','menu_id','item_id');
    }




}
