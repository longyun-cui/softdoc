<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pivot_User_Collection extends Model
{
    //
    protected $table = "pivot_user_collection";
    protected $fillable = [
        'sort', 'type', 'user_id', 'item_id', 'content_id'
    ];
    protected $dateFormat = 'U';


    // 用户
    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // 课题
    function item()
    {
        return $this->belongsTo('App\Models\Item','item_id','id');
    }

    // 章节
    function chapter()
    {
        return $this->belongsTo('App\Models\Content','content_id','id');
    }





}
