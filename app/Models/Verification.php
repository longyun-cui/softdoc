<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    //
    protected $table = "root_verification";
    protected $fillable = [
        'sort', 'type', 'user_id', 'email', 'mobile', 'code'
    ];
    protected $dateFormat = 'U';

    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }


}
