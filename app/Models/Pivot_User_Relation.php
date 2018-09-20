<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pivot_User_Relation extends Model
{
    //
    protected $table = "pivot_user_relations";
    protected $fillable = [
        'sort', 'type', 'relation', 'relation_type', 'user_id', 'relation_user_id'
    ];
    protected $dateFormat = 'U';


    // 用户
    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // 关联人
    function relations()
    {
        return $this->hasMany('App\User','relation_user_id','id');
    }


}
