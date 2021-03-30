<?php
namespace App\Repositories\Home;

use App\Models\Doc_Item;

use App\Repositories\Common\CommonRepository;

use Request, Response, Auth, Validator, DB, Exception;
use QrCode;

class ItemRepository {

    private $model;
    public function __construct()
    {
//        $this->model = new Doc_Item;
    }


    public function index()
    {
        return view('home.index');
    }


    // 返回列表数据
    public function get_list_datatable($post_data)
    {
        $user = Auth::user();
        $query = Doc_Item::select("*")->with(['user'])->where('user_id', $user->id)->where('item_id', 0);

        $category = isset($post_data['category']) ? $post_data['category'] : '';
        if($category == "article") $query->where('category', 1);
        else if($category == "debase") $query->where('category', 7);
        else if($category == "menu") $query->where('category', 11);
        else if($category == "timeline") $query->where('category', 18);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");

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


    // 返回列表数据
    public function get_timeline_list_datatable($post_data)
    {
        $item_encode = request("item_id",0);
        $item_decode = decode($item_encode);
        if(!$item_decode) return view('home.404');

        $user = Auth::user();
        $line = Line::find($item_decode);
        if(!$line || $line->user_id != $user->id) return view('home.404');

        $query = Point::select("*")->with(['user'])->where('line_id', $item_decode);
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




    // 返回【添加】视图
    public function view_create()
    {
        $category = request("category",'');

        if($category == 'item') $view_blade = 'home.item.edit';
        elseif($category == 'about') $view_blade = 'home.item.edit-about';
        elseif($category == 'advantage') $view_blade = 'home.item.edit-advantage';
        elseif($category == 'cooperation') $view_blade = 'home.item.edit-cooperation';
        elseif($category == 'service') $view_blade = 'home.item.edit-service';
        elseif($category == 'faq') $view_blade = 'home.item.edit-faq';
        elseif($category == 'coverage') $view_blade = 'home.item.edit-coverage';
        elseif($category == 'activity') $view_blade = 'home.item.edit-activity';
        elseif($category == 'customer') $view_blade = 'home.item.edit-customer';
        else $view_blade = 'home.item.edit';

        if($category == 'item') $menus = Doc_Item::get();
        elseif($category == 'advantage') $menus = Doc_Item::where(['category'=>5])->get();
        elseif($category == 'service') $menus = Doc_Item::where(['category'=>11])->get();
        else $menus = [];

        return view($view_blade)->with(['operate'=>'create', 'encode_id'=>encode(0), 'menus'=>$menus]);
    }
    // 返回编辑视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id && intval($id) !== 0) return view('home.404');

        if($decode_id == 0)
        {
            return view('home.item.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        }
        else
        {
            $data = Doc_Item::find($decode_id);
            if($data)
            {
                unset($data->id);
                return view('home.item.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$data]);
            }
            else return response("该内容不存在！", 404);
        }
    }

    // 保存数据
    public function save($post_data)
    {
        $messages = [
            'id.required' => '参数有误',
            'title.required' => '请输入标题',
        ];
        $v = Validator::make($post_data, [
            'id' => 'required',
            'title' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $user = Auth::user();

        $id = decode($post_data["id"]);
        $operate = $post_data["operate"];
        if(intval($id) !== 0 && !$id) return response_error();

        DB::beginTransaction();
        try
        {
            if($operate == 'create') // $id==0，添加一个新的内容
            {
                $mine = new Doc_Item;
                $post_data["user_id"] = $user->id;
            }
            elseif('edit') // 编辑
            {
                $mine = Doc_Item::find($id);
                if(!$mine) return response_error([],"该内容不存在，刷新页面重试");
                if($mine->user_id != $user->id) return response_error([],"你没有操作权限");
            }
            else throw new Exception("operate--error");

            if(!empty($post_data['custom']))
            {
                $post_data['custom'] = json_encode($post_data['custom']);
            }

            if($operate == 'create' && $post_data['category'] == 1 && $post_data['time_type'] == 1)
            {
                if(!empty($post_data['start_time'])) {
                    $post_data['start_time'] = strtotime($post_data['start_time']);
                }
                else $post_data['start_time'] = 0;

                if(!empty($post_data['end_time'])) {
                    $post_data['end_time'] = strtotime($post_data['end_time']);
                }
                else $post_data['end_time'] = 0;
            }
            else {
                unset($post_data['start_time']);
                unset($post_data['end_time']);
            }

            $bool = $mine->fill($post_data)->save();
            if($bool)
            {
                $encode_id = encode($mine->id);

                $is_working = isset($post_data["is_working"]) ? $post_data["is_working"] : 0;
                if($is_working == 1)
                {
                    $time = time();
                    $user->pivot_item()->attach($mine->id,['type'=>11,'created_at'=>$time,'updated_at'=>$time]);
                }

                if($operate == 'create' && $post_data['category'] == 1 && $post_data['time_type'] == 1)
                {
                    $time = time();
                    $user->pivot_item()->attach($mine->id,['type'=>12,'created_at'=>$time,'updated_at'=>$time]);
                }

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
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        $mine = Doc_Item::find($id);
        if($mine->user_id != $user->id) return response_error([],"你没有操作权限");

        DB::beginTransaction();
        try
        {
            $content = $mine->content;
            $cover_pic = $mine->cover_pic;

            $bool = $mine->delete();
            if(!$bool) throw new Exception("delete--item--fail");

            DB::commit();

            // 删除UEditor图片
            $img_tags = get_html_img($content);
            foreach ($img_tags[2] as $img)
            {
                if (!empty($img) && file_exists(public_path($img)))
                {
                    unlink(public_path($img));
                }
            }

            // 删除封面图片
            if(!empty($cover_pic) && file_exists(storage_path("resource/" . $cover_pic)))
            {
                unlink(storage_path("resource/" . $cover_pic));
            }

            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '操作失败，请重试！';
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }

    }

    // 分享
    public function share($post_data)
    {
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        if(!is_numeric($post_data["is_shared"])) return response_error([],"参数有误，刷新页面试试");

        $user = Auth::user();
        $mine = Doc_Item::find($id);
        if($mine->user_id != $user->id) return response_error([],"你没有操作权限");
        $update["is_shared"] = $post_data["is_shared"];
        DB::beginTransaction();
        try
        {
            $mine->timestamps = false;
            $bool = $mine->fill($update)->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            return response_fail([],'分享失败，请重试');
        }
    }

    // 启用
    public function enable($post_data)
    {
        $user = Auth::user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该作者不存在，刷新页面试试");

        $mine = Doc_Item::find($id);
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

        $mine = Doc_Item::find($id);
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




    /*
     * 目录类型
     */
    // 返回列表数据
    public function content_menutype_view_index($post_data)
    {
        $item_encode = $post_data['id'];
        $item_decode = decode($item_encode);
        if(!$item_decode) return view('home.404')->with(['error'=>'参数有误']);
        // abort(404);

        $item = Doc_Item::with([
            'contents'=>function($query) { $query->orderBy('rank','asc'); }
        ])->find($item_decode);
        if($item)
        {
            $item->encode_id = encode($item->id);
//            unset($item->id);

//            $contents = $course->contents->toArray();

//            $contents_tree_array = $this->get_tree_array($contents,0);
//            $course->contents_tree_array = collect($contents_tree_array);

//            $contents_recursion_array = $this->get_recursion_array($contents,0);
//            $course->contents_recursion_array = collect($contents_recursion_array);

            $item->contents_recursion = $this->get_recursion($item->contents,0);

            return view('home.item.edit-for-menutype')->with(['data'=>$item]);
        }
        else return view('home.404')->with(['error'=>'该内容不存在']);

    }

    // 返回列表数据
    public function content_timeline_view_index($post_data)
    {
        $item_encode = $post_data['id'];
        $item_decode = decode($item_encode);
        if(!$item_decode) return view('home.404')->with(['error'=>'参数有误']);
        // abort(404);

        $item = Doc_Item::with([
            'contents'=>function($query) {
                $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
                $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
                $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
                $query->orderBy('time_point','asc');
            }
        ])->find($item_decode);
        if($item)
        {
            $item->encode_id = encode($item->id);
//            unset($item->id);

            return view('home.item.edit-for-timeline')->with(['data'=>$item]);
        }
        else return view('home.404')->with(['error'=>'该内容不存在']);

    }

    // 返回添加视图
    public function content_view_create()
    {
        return view('home.content.menu');
    }

    // 返回编辑视图
    public function content_view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id && intval($id) !== 0) return view('home.404')->with(['error'=>'参数有误']);

        if($decode_id == 0)
        {
            return view('home.content.menu')->with(['operate'=>'create', 'encode_id'=>$id]);
        }
        else
        {
            $data = Content::find($decode_id);
            if($data)
            {
                unset($data->id);
                return view('home.item.menu')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$data]);
            }
            else return view('home.404')->with(['error'=>'该内容不存在']);
        }
    }

    // 保存【目录类型】
    public function content_menutype_save($post_data)
    {
        $messages = [
            'id.required' => '参数有误',
            'title.required' => '请输入标题',
            'p_id.required' => '请选择目录',
        ];
        $v = Validator::make($post_data, [
            'id' => 'required',
            'title' => 'required',
            'p_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $user = Auth::user();

//        $post_data["category"] = 11;
        $item_encode = $post_data["item_id"];
        $item_decode = decode($item_encode);
        if(!$item_decode) return response_error();
        $item = Doc_Item::find($item_decode);
        if($item)
        {
            if($item->user_id == $user->id)
            {

                $content_encode = $post_data["id"];
                $content_decode = decode($content_encode);
                if(intval($content_decode) !== 0 && !$content_decode) return response_error();

                DB::beginTransaction();
                try
                {
                    $post_data["item_id"] = $item_decode;
                    $operate = $post_data["operate"];
                    if($operate == 'create') // $id==0，添加一个新的内容
                    {
                        $content = new Doc_Item;
                        $post_data["user_id"] = $user->id;
                    }
                    elseif('edit') // 编辑
                    {
                        if($content_decode == $post_data["p_id"]) return response_error([],"不能选择自己为父节点");

                        $content = Doc_Item::find($content_decode);
                        if(!$content) return response_error([],"该内容不存在，刷新页面重试");
                        if($content->user_id != $user->id) return response_error([],"你没有操作权限");
//                        if($content->type == 1) unset($post_data["type"]);

                        if($post_data["p_id"] != 0)
                        {
                            $is_child = true;
                            $p_id = $post_data["p_id"];
                            while($is_child)
                            {
                                $p = Doc_Item::find($p_id);
                                if(!$p) return response_error([],"参数有误，刷新页面重试");
                                if($p->p_id == 0) $is_child = false;
                                if($p->p_id == $content_decode)
                                {
                                    $content_children = Doc_Item::where('p_id',$content_decode)->get();
                                    $children_count = count($content_children);
                                    if($children_count)
                                    {
                                        $num = Doc_Item::where('p_id',$content_decode)->update(['p_id'=>$content->p_id]);
                                        if($num != $children_count)  throw new Exception("update--children--fail");
                                    }
                                }
                                $p_id = $p->p_id;
                            }
                        }

                        if($content_encode == $item_encode)
                        {
                            unset($post_data['item_id']);
                            unset($post_data['rank']);
                        }

                    }
                    else throw new Exception("operate--error");


                    if($post_data["p_id"] != 0)
                    {
                        $parent = Doc_Item::find($post_data["p_id"]);
                        if(!$parent) return response_error([],"父节点不存在，刷新页面重试");
                    }

                    $bool = $content->fill($post_data)->save();
                    if($bool)
                    {
                        $encode_id = encode($content->id);

                        // 封面图片
                        if(!empty($post_data["cover"]))
                        {
                            // 删除原封面图片
                            $mine_cover_pic = $content->cover_pic;
                            if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                            {
                                unlink(storage_path("resource/" . $mine_cover_pic));
                            }

                            $result = upload_storage($post_data["cover"]);
                            if($result["result"])
                            {
                                $content->cover_pic = $result["local"];
                                $content->save();
                            }
                            else throw new Exception("upload-cover-fail");
                        }
                    }
                    else throw new Exception("insert--content--fail");


                    DB::commit();
                    return response_success(['id'=>$encode_id]);
                }
                catch (Exception $e)
                {
                    DB::rollback();
                    $msg = '操作失败，请重试！';
                    $msg = $e->getMessage();
//                    exit($e->getMessage());
                    return response_fail([], $msg);
                }

            }
            else response_error([],"该内容不是您的，您不能操作！");

        }
        else return response_error([],"该内容不存在");
    }

    // 保存【时间点】
    public function content_timeline_save($post_data)
    {
        $messages = [
            'id.required' => '参数有误',
            'title.required' => '请输入标题',
            'time_point.required' => '请输入时间点',
        ];
        $v = Validator::make($post_data, [
            'id' => 'required',
            'title' => 'required',
            'time_point' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $user = Auth::user();

//        $post_data["category"] = 18;
        $item_encode = $post_data["item_id"];
        $item_decode = decode($item_encode);
        if(!$item_decode) return response_error();
        $item = Doc_Item::find($item_decode);
        if($item)
        {
            if($item->user_id == $user->id)
            {

                $content_encode = $post_data["id"];
                $content_decode = decode($content_encode);
                if(intval($content_decode) !== 0 && !$content_decode) return response_error();

                DB::beginTransaction();
                try
                {
                    $post_data["item_id"] = $item_decode;
                    $operate = $post_data["operate"];
                    if($operate == 'create') // $id==0，添加一个新的内容
                    {
                        $content = new Doc_Item;
                        $post_data["user_id"] = $user->id;
                    }
                    elseif('edit') // 编辑
                    {
                        $content = Doc_Item::find($content_decode);
                        if(!$content) return response_error([],"该内容不存在，刷新页面重试");
                        if($content->user_id != $user->id) return response_error([],"你没有操作权限");
//                        if($content->type == 1) unset($post_data["type"]);

                        if($content_encode == $item_encode)
                        {
                            unset($post_data['item_id']);
                            unset($post_data['time_point']);
                        }
                    }
                    else throw new Exception("operate--error");

                    $bool = $content->fill($post_data)->save();
                    if($bool)
                    {
                        $encode_id = encode($content->id);

                        // 封面图片
                        if(!empty($post_data["cover"]))
                        {
                            // 删除原封面图片
                            $mine_cover_pic = $content->cover_pic;
                            if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                            {
                                unlink(storage_path("resource/" . $mine_cover_pic));
                            }

                            $result = upload_storage($post_data["cover"]);
                            if($result["result"])
                            {
                                $content->cover_pic = $result["local"];
                                $content->save();
                            }
                            else throw new Exception("upload-cover-fail");
                        }
                    }
                    else throw new Exception("insert--content--fail");


                    DB::commit();
                    return response_success(['id'=>$encode_id]);
                }
                catch (Exception $e)
                {
                    DB::rollback();
                    $msg = '操作失败，请重试！';
                    $msg = $e->getMessage();
//                    exit($e->getMessage());
                    return response_fail([], $msg);
                }

            }
            else response_error([],"该内容不是您的，您不能操作！");

        }
        else return response_error([],"该内容不存在");
    }

    // 内容获取
    public function content_get($post_data)
    {
        $user = Auth::user();
        $id = $post_data["id"];
//        $id = decode($post_data["id"]);
        if(!$id) return response_error([],"该内容不存在，刷新页面试试");

        $content = Doc_Item::find($id);
        if($content->user_id != $user->id) return response_error([],"你没有操作权限");
        else
        {
            $content->encode_id = encode($content->id);
            if(!empty($content->cover_pic))
            {
                $cover_url = url(env('DOMAIN_CDN').'/'.$content->cover_pic);
                $content->cover_img = '<img src="'.$cover_url.'" alt="" />"';
            }
            return response_success($content);
        }
    }

    // 删除
    public function content_delete($post_data)
    {
        $user = Auth::user();
        $id = $post_data["id"];
//        $id = decode($post_data["id"]);
        if(!$id) return response_error([],"该内容不存在，刷新页面试试");

        $content = Doc_Item::find($id);
        if($content->user_id != $user->id) return response_error([],"你没有操作权限");

        DB::beginTransaction();
        try
        {
            $content_children = Doc_Item::where('p_id',$id)->get();
            $children_count = count($content_children);
            if($children_count)
            {
                $num = Doc_Item::where('p_id',$id)->update(['p_id'=>$content->p_id]);
                if($num != $children_count)  throw new Exception("update--children--fail");
            }
            $bool = $content->delete();
            if(!$bool) throw new Exception("delete--content--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
//            exit($e->getMessage());
//            $msg = $e->getMessage();
            $msg = '删除失败，请重试';
            return response_fail([],$msg);
        }

    }

    // 启用
    public function content_enable($post_data)
    {
        $user = Auth::user();
        $id = $post_data["id"];
//        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        $mine = Doc_Item::find($id);
        if($mine->user_id != $user->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        DB::beginTransaction();
        try
        {
            $mine->timestamps = false;
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
    public function content_disable($post_data)
    {
        $user = Auth::user();
        $id = $post_data["id"];
//        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该文章不存在，刷新页面试试");

        $mine = Doc_Item::find($id);
        if($mine->user_id != $user->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        DB::beginTransaction();
        try
        {
            $mine->timestamps = false;
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








    //
    public function select2_menus($post_data)
    {
        $course_encode = $post_data['course_id'];
        $course_decode = decode($course_encode);
        if(!$course_decode) return view('home.404')->with(['error'=>'参数有误']);

        if(empty($post_data['keyword']))
        {
            $list =Content::select(['id','title as text'])->where('course_id', $course_decode)->get()->toArray();
        }
        else
        {
            $keyword = "%{$post_data['keyword']}%";
            $list =Content::select(['id','title as text'])->where('course_id', $course_decode)->where('name','like',"%$keyword%")->get()->toArray();
        }
        return $list;
    }




    // 层叠排列
    function get_tree($a,$pid=0)
    {
        $tree = array();
        //每次都声明一个新数组用来放子元素
        foreach($a as $v)
        {
            if($v->p_id == $pid)
            {
                //匹配子记录
                $v->children = $this->get_tree($a, $v->id); //递归获取子记录

                if($v->children == null)
                {
                    unset($v->children); //如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）
                }
                $tree[] = $v; //将记录存入新数组
            }
        }
        return $tree; //返回新数组
    }
    // 层叠排列
    function get_tree_array($a,$pid=0)
    {
        $tree = array();
        //每次都声明一个新数组用来放子元素
        foreach($a as $v)
        {
            if($v['p_id'] == $pid)
            {
                //匹配子记录
                $v['children'] = $this->get_tree_array($a, $v['id']); //递归获取子记录

                if($v['children'] == null)
                {
                    unset($v['children']); //如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）
                }
                $tree[] = $v; //将记录存入新数组
            }
        }
        return $tree; //返回新数组
    }


    // 顺序排列
    function get_recursion($result, $parent_id=0, $level=0)
    {
        /*记录排序后的类别数组*/
        static $list = array();

        foreach ($result as $k => $v)
        {
            if($v->p_id == $parent_id)
            {
                $v->level = $level;

                foreach($list as $key=>$val)
                {
                    if($val->id == $parent_id) $list[$key]->has_child = 1;
                }

                /*将该类别的数据放入list中*/
                $list[] = $v;

                $this->get_recursion($result, $v->id, $level+1);
            }
        }

        return $list;
    }
    // 顺序排列
    function get_recursion_array($result, $parent_id=0, $level=0)
    {
        /*记录排序后的类别数组*/
        static $list = array();

        foreach ($result as $k => $v)
        {
            if($v['p_id'] == $parent_id)
            {
                $v['level'] = $level;

                foreach($list as $key=>$val)
                {
                    if($val['id'] == $parent_id) $list[$key]['has_child'] = 1;
                }

                /*将该类别的数据放入list中*/
                $list[] = $v;

                $this->get_recursion_array($result, $v['id'], $level+1);
            }
        }

        return $list;
    }




}