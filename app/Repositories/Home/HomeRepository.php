<?php
namespace App\Repositories\Home;

use App\Repositories\Common\CommonRepository;
use Response, Auth, Validator, DB, Exception;
use QrCode;

class HomeRepository {

    private $model;
    public function __construct()
    {
//        $this->model = new Table;
    }



    // 返回【个人资料】 视图
    public function view_info_index()
    {
        $user = Auth::user();
        return view('home.info.index')->with(['info'=>$user]);
    }

    // 返回【个人资料】【编辑】视图
    public function view_info_edit()
    {
        $user = Auth::user();
        return view('home.info.edit')->with(['info'=>$user]);
    }

    // 保存【个人资料】信息
    public function info_save($post_data)
    {
        $user = Auth::user();
        $mine = Auth::user();

        // 封面图片
        if(!empty($post_data["portrait"]))
        {
            // 删除原封面图片
            $mine_cover_pic = $mine->portrait_img;
            if(!empty($mine_cover_pic) && file_exists(storage_path("resource/user{$user->id}/" . $mine_cover_pic)))
            {
                unlink(storage_path("resource/" . $mine_cover_pic));
            }

            $result = upload_storage($post_data["portrait"]);
            if($result["result"])
            {
                $mine->portrait_img = $result["local"];
                $mine->save();
            }
            else throw new Exception("upload-portrait-fail");
        }
        else unset($post_data["portrait"]);

        $bool = $user->fill($post_data)->save();
        if($bool)
        {
            return response_success();
        }
        else return response_fail();
    }




    // 返回【密码】【编辑】视图
    public function view_password_reset()
    {
        $user = Auth::user();
        return view('home.info.password');
    }

    // 保存【密码】
    public function password_reset($post_data)
    {
        $messages = [
            'old_password.required' => '请输入旧密码',
            'new_password.required' => '请输入新密码',
            'confirm_password.required' => '请确认密码',
        ];
        $v = Validator::make($post_data, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $old_password = $post_data["old_password"];
        $new_password = $post_data["new_password"];
        $confirm_password = $post_data["confirm_password"];
        if($new_password == $confirm_password)
        {
            $user = Auth::user();
            if(password_check($old_password,$user->password))
            {
                $user->password = password_encode($new_password);
                $user->save();
                return response_success();
            }
            else return response_error([],'账户or密码不正确 ');
        }
        else return response_error([],"两次密码不一致");
    }


}