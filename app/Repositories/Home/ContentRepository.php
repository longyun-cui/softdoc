<?php
namespace App\Repositories\Home;

use App\Models\RootItem;
use App\Models\Content;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class ContentRepository {

    private $model;
    public function __construct()
    {
//        $this->model = new People;
    }

    public function index()
    {
        return view('home.index');
    }

    // 返回列表数据
    public function get_list_datatable($post_data)
    {
        $user = Auth::user();
        $query = RootItem::select("*")->with(['user'])->where('user_id', $user->id);
        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['major'])) $query->where('major', 'like', "%{$post_data['major']}%");
        if(!empty($post_data['nation'])) $query->where('nation', 'like', "%{$post_data['nation']}%");
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

    // 返回添加视图
    public function view_create()
    {
        return view('home.course.edit')->with(['menu_course_create'=>'active']);
    }
    // 返回编辑视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id && intval($id) !== 0) return view('home.404');

        if($decode_id == 0)
        {
            return view('home.course.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        }
        else
        {
            $data = RootItem::find($decode_id);
            if($data)
            {
                unset($data->id);
                return view('home.course.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$data]);
            }
            else return response("该课程不存在！", 404);
        }
    }

    // 保存数据
    public function save($post_data)
    {
        $messages = [
            'id.required' => '参数有误',
            'title.required' => '请输入课程标题',
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
            if($operate == 'create') // $id==0，添加一个新的课程
            {
                $course = new Item;
                $post_data["user_id"] = $user->id;
            }
            elseif('edit') // 编辑
            {
                $course = RootItem::find($id);
                if(!$course) return response_error([],"该课程不存在，刷新页面重试");
                if($course->user_id != $user->id) return response_error([],"你没有操作权限");
            }
            else throw new Exception("operate--error");

            $bool = $course->fill($post_data)->save();
            if($bool)
            {
                $encode_id = encode($course->id);

                if(!empty($post_data["cover"]))
                {
                    $upload = new CommonRepository();
                    $result = $upload->upload($post_data["cover"], 'unique-cover-courses' , 'cover_course_'.$encode_id);
                    if($result["status"])
                    {
                        $course->cover_pic = $result["data"];
                        $course->save();
                    }
                    else throw new Exception("upload--cover--fail");
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
//            $msg = $e->getMessage();
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

        $course = RootItem::find($id);
        if($course->user_id != $user->id) return response_error([],"你没有操作权限");

        DB::beginTransaction();
        try
        {
            $bool = $course->delete();
            if(!$bool) throw new Exception("delete--course--fail");

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

        $course = RootItem::find($id);
        if($course->user_id != $user->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        DB::beginTransaction();
        try
        {
            $bool = $course->fill($update)->save();
            if(!$bool) throw new Exception("update--course--fail");

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

        $course = RootItem::find($id);
        if($course->user_id != $user->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        DB::beginTransaction();
        try
        {
            $bool = $course->fill($update)->save();
            if(!$bool) throw new Exception("update--course--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            return response_fail([],'禁用失败，请重试');
        }
    }




    // 返回列表数据
    public function content_view_index($post_data)
    {
        $item_encode = $post_data['id'];
        $item_decode = decode($item_encode);
        if(!$item_decode) return view('home.404')->with(['error'=>'参数有误']);
        // abort(404);

        $item = RootItem::with(['contents'])->find($item_decode);
        if($item)
        {
            $item->encode_id = encode($item->id);
            unset($item->id);

//            $contents = $course->contents->toArray();

//            $contents_tree_array = $this->get_tree_array($contents,0);
//            $course->contents_tree_array = collect($contents_tree_array);

//            $contents_recursion_array = $this->get_recursion_array($contents,0);
//            $course->contents_recursion_array = collect($contents_recursion_array);

            $item->contents_recursion = $this->get_recursion($item->contents,0);

            return view('home.content.content')->with(['data'=>$item]);

//            if(request()->isMethod('get'))
//            else if(request()->isMethod('post')) return $this->get_people_product_list_datatable($post_data);
        }
        else return view('home.404')->with(['error'=>'课程不存在']);

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
            else return view('home.404')->with(['error'=>'课程不存在']);
        }
    }

    // 保存数据
    public function content_save($post_data)
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

        $post_data["category"] = 51;
        $item_encode = $post_data["item_id"];
        $item_decode = decode($item_encode);
        if(!$item_decode) return response_error();
        $item = RootItem::find($item_decode);
        if($item)
        {
            if($item->user_id == $user->id)
            {

                $content_decode = decode($post_data["id"]);
                if(intval($content_decode) !== 0 && !$content_decode) return response_error();

                DB::beginTransaction();
                try
                {
                    $post_data["item_id"] = $item_decode;
                    $operate = $post_data["operate"];
                    if($operate == 'create') // $id==0，添加一个新的内容
                    {
                        $content = new RootItem;
                        $post_data["user_id"] = $user->id;
                    }
                    elseif('edit') // 编辑
                    {
                        if($content_decode == $post_data["p_id"]) return response_error([],"不能选择自己为父节点");

                        $content = RootItem::find($content_decode);
                        if(!$content) return response_error([],"该内容不存在，刷新页面重试");
                        if($content->user_id != $user->id) return response_error([],"你没有操作权限");
//                        if($content->type == 1) unset($post_data["type"]);

                        if($post_data["p_id"] != 0)
                        {
                            $is_child = true;
                            $p_id = $post_data["p_id"];
                            while($is_child)
                            {
                                $p = RootItem::find($p_id);
                                if(!$p) return response_error([],"参数有误，刷新页面重试");
                                if($p->p_id == 0) $is_child = false;
                                if($p->p_id == $content_decode)
                                {
                                    $content_children = RootItem::where('p_id',$content_decode)->get();
                                    $children_count = count($content_children);
                                    if($children_count)
                                    {
                                        $num = RootItem::where('p_id',$content_decode)->update(['p_id'=>$content->p_id]);
                                        if($num != $children_count)  throw new Exception("update--children--fail");
                                    }
                                }
                                $p_id = $p->p_id;
                            }
                        }

                    }
                    else throw new Exception("operate--error");


                    if($post_data["p_id"] != 0)
                    {
                        $parent = RootItem::find($post_data["p_id"]);
                        if(!$parent) return response_error([],"父节点不存在，刷新页面重试");
                    }

                    $bool = $content->fill($post_data)->save();
                    if($bool)
                    {
                        $encode_id = encode($content->id);
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
//                    exit($e->getMessage())、;
                    return response_fail([], $msg);
                }

            }
            else response_error([],"该内容不是您的，您不能操作！");

        }
        else return response_error([],"该课程不存在");
    }

    // 内容获取
    public function content_get($post_data)
    {
        $user = Auth::user();
        $id = $post_data["id"];
//        $id = decode($post_data["id"]);
        if(!$id) return response_error([],"该课程不存在，刷新页面试试");

        $content = RootItem::find($id);
        if($content->user_id != $user->id) return response_error([],"你没有操作权限");
        else
        {
            $content->encode_id = encode($content->id);
            return response_success($content);
        }
    }

    // 内容删除
    public function content_delete($post_data)
    {
        $user = Auth::user();
        $id = $post_data["id"];
//        $id = decode($post_data["id"]);
        if(!$id) return response_error([],"该内容不存在，刷新页面试试");

        $content = RootItem::find($id);
        if($content->user_id != $user->id) return response_error([],"你没有操作权限");

        DB::beginTransaction();
        try
        {
            $content_children = RootItem::where('p_id',$id)->get();
            $children_count = count($content_children);
            if($children_count)
            {
                $num = RootItem::where('p_id',$id)->update(['p_id'=>$content->p_id]);
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