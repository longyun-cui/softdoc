@extends('home.layout.layout')

@section('title','修改密码')
@section('header','修改密码')
@section('description','修改密码')
@section('breadcrumb')
    <li><a href="{{url('/home')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{url('/home/info/index')}}"><i class="fa "></i>个人信息</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">修改密码</h3>
                <div class="box-tools pull-right">
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-password">
            <div class="box-body">
                {{csrf_field()}}

                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">旧密码</label>
                    <div class="col-md-8 ">
                        <div><input type="password" class="form-control" name="old_password" placeholder="旧密码"></div>
                    </div>
                </div>
                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">新密码</label>
                    <div class="col-md-8 ">
                        <div><input type="password" class="form-control" name="new_password" placeholder="新密码"></div>
                    </div>
                </div>
                {{--标语 slogan--}}
                <div class="form-group">
                    <label class="control-label col-md-2">确认密码</label>
                    <div class="col-md-8 ">
                        <div><input type="password" class="form-control" name="confirm_password" placeholder="确认密码"></div>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" onclick="" class="btn btn-primary" id="edit-password-submit"><i class="fa fa-check"></i>提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection


@section('js')
<script>
    $(function() {
        // 添加or修改产品信息
        $("#edit-password-submit").on('click', function() {
            var options = {
                url: "/home/info/password/reset",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/home/info/index";
                    }
                }
            };
            $("#form-edit-password").ajaxSubmit(options);
        });
    });
</script>
@endsection