<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;

class Doc_Verification extends Model
{
    //
    protected $table = "verification";
    protected $fillable = [
        'sort', 'type', 'user_id', 'email', 'mobile', 'code'
    ];
    protected $dateFormat = 'U';

    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }


}
