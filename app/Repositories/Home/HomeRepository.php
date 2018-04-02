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

        if(!empty($post_data["portrait"]))
        {
            $upload = new CommonRepository();
            $result = $upload->upload($post_data["portrait"], 'user'. $user->id . '-common', 'portrait');
            if($result["status"]) $post_data["portrait_img"] = $result["data"];
            else return response_fail();
        }
        else unset($post_data["portrait"]);

//        // 目标URL
//        $url = 'http://tinyline.cn/org/'.$admin->website_name;
//        // 保存位置
//        $qrcode_path = 'resource/org/'.$admin->id.'/unique/common';
//        if(!file_exists(storage_path($qrcode_path)))
//            mkdir(storage_path($qrcode_path), 0777, true);
//        // qrcode图片文件
//        $qrcode = $qrcode_path.'/qrcode.png';
//        QrCode::errorCorrection('H')->format('png')->size(320)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qrcode));

        $bool = $user->fill($post_data)->save();
        if($bool)
        {
//            $name = $qrcode_path.'/qrcode_img.png';
//            $common = new CommonRepository();
//            $logo = 'resource/'.$org->logo;
//            $common->create_root_qrcode($name, $org->name, $qrcode, $logo);

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