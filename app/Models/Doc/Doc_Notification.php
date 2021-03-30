<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;

class Doc_Notification extends Model
{
    //
    protected $table = "notification";
    protected $fillable = [
        'sort', 'type', 'is_read', 'user_id', 'source_id', 'item_id', 'communication_id', 'reply_id', 'content', 'ps'
    ];
    protected $dateFormat = 'U';

    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    function source()
    {
        return $this->belongsTo('App\User','source_id','id');
    }

    function item()
    {
        return $this->belongsTo('App\Models\Doc_Item','item_id','id');
    }

    function communication()
    {
        return $this->belongsTo('App\Models\Doc_Communication','communication_id','id');
    }

    function reply()
    {
        return $this->belongsTo('App\Models\Doc_Communication','reply_id','id');
    }


}
