<?php
namespace App\Repositories\Home;

use App\Http\Middleware\LoginMiddleware;

use App\Models\RootItem;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class PointRepository {

    private $model;
    public function __construct()
    {
//        $this->model = new RootItem;
    }

    public function index()
    {
        return view('home.index');
    }

    // 返回列表数据
    public function get_list_datatable($post_data)
    {
        $item_encode = request("id",0);
        $item_decode = decode($item_encode);
        if(!$item_decode) return view('home.404');

        $user = Auth::user();
        $item = RootItem::find($item_decode);
        if(!$item || $item->user_id != $user->id) return view('home.404');

        $query = RootItem::select("*")->with(['user'])->where('item_id', $item_decode);
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            if($field == "time_point")
            {
                $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) '.$order_dir));
                $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) '.$order_dir));
                $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") '.$order_dir));
                $query->orderBy('time_point',$order_dir);
            }
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }
        return datatable_response($list, $draw, $total);
    }

    // 返回添加视图
    public function view_create()
    {
        $item_encode = request("item_id",0);
        $item_decode = decode($item_encode);
        if(!$item_decode && intval($item_decode) !== 0) return view('home.404');
        $user = Auth::user();
        $item = RootItem::find($item_decode);
        if(!$item || $item->user_id != $user->id) return view('home.404');
        $item->encode = encode($item->id);
        return view('home.point.edit')->with(['operate'=>'create', 'item'=>$item]);
    }
    // 返回编辑视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id && intval($id) !== 0) return view('home.404');

        if($decode_id == 0)
        {
            return view('home.point.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        }
        else
        {
            $data = RootItem::with('belong_item')->find($decode_id);
            if($data)
            {
//                unset($data->id);
                $data->belong_item->encode = encode($data->belong_item->id);
//                unset($data->belong_item->id);
                return view('home.point.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$data, 'item'=>$data->belong_item]);
            }
            else return response("该内容不存在！", 404);
        }
    }

    // 保存数据
    public function save($post_data)
    {
        $messages = [
            'id.required' => '参数有误',
            'item_id.required' => '参数有误',
            'title.required' => '请输入标题',
            'time_point.required' => '请输入时间点',
        ];
        $v = Validator::make($post_data, [
            'id' => 'required',
            'item_id' => 'required',
            'title' => 'required',
            'time_point' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $user = Auth::user();

        $operate = $post_data["operate"];
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error();


        DB::beginTransaction();
        try
        {
            if($operate == 'create') // $id==0，添加一个新的课程
            {
                $item_decode = decode($post_data["item_id"]);
                if(!$item_decode && intval($item_decode) !== 0) return response_error();

                $item = RootItem::find($item_decode);
                if(!$item || $item->user_id != $user->id) return response_error();
                $post_data["item_id"] = $item_decode;

                $mine = new RootItem();
                $post_data["user_id"] = $user->id;
            }
            elseif('edit') // 编辑
            {
                $mine = RootItem::find($id);
                if(!$mine) return response_error([],"该课程不存在，刷新页面重试");
                if($mine->user_id != $user->id) return response_error([],"你没有操作权限");
                unset($post_data["item_id"]);
            }
            else throw new Exception("operate--error");

            $post_data['time_point'] = trim($post_data['time_point']);
            $bool = $mine->fill($post_data)->save();
            if($bool)
            {
                $encode_id = encode($mine->id);

                // 封面图片
                if(!empty($post_data["cover"]))
                {
                    // 删除原封面图片
                    $mine_cover_pic = $mine->cover_pic;
                    if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                    {
                        unlink(storage_path("resource/" . $mine_cover_pic));
                    }

                    $result = upload_storage($post_data["cover"]);
                    if($result["result"])
                    {
                        $mine->cover_pic = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload-cover-fail");
                }
            }
            else throw new Exception("insert--people--fail");


            DB::commit();
            return response_success(['id'=>$encode_id]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '操作失败，请重试！';
            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([], $msg);
        }
    }

    // 删除
    public function delete($post_data)
    {
        $user = Auth::user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该课程不存在，刷新页面试试");

        $mine = RootItem::find($id);
        if($mine->user_id != $user->id) return response_error([],"你没有操作权限");

        DB::beginTransaction();
        try
        {
            $bool = $mine->delete();
            if(!$bool) throw new Exception("delete--item--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            return response_fail([],'删除失败，请重试');
        }

    }

    // 启用
    public function enable($post_data)
    {
        $user = Auth::user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该作者不存在，刷新页面试试");

        $mine = RootItem::find($id);
        if($mine->user_id != $user->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        DB::beginTransaction();
        try
        {
            $bool = $mine->fill($update)->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            return response_fail([],'启用失败，请重试');
        }
    }

    // 禁用
    public function disable($post_data)
    {
        $user = Auth::user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该文章不存在，刷新页面试试");

        $mine = RootItem::find($id);
        if($mine->user_id != $user->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        DB::beginTransaction();
        try
        {
            $bool = $mine->fill($update)->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            return response_fail([],'禁用失败，请重试');
        }
    }


}