@extends('home.layout.layout')

@section('title','编辑个人信息')
@section('header','编辑个人信息')
@section('description','编辑个人信息')
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
                <h3 class="box-title">编辑个人信息</h3>
                <div class="box-tools pull-right">
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-info">
            <div class="box-body">
                {{csrf_field()}}

                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">用户名</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="name" placeholder="请输入用户名" value="{{$info->name}}"></div>
                    </div>
                </div>
                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">昵称</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="nickname" placeholder="请输入昵称" value="{{$info->nickname or ''}}"></div>
                    </div>
                </div>
                {{--标语 slogan--}}
                <div class="form-group">
                    <label class="control-label col-md-2">真实姓名</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="truename" placeholder="真实姓名" value="{{$info->truename or ''}}"></div>
                    </div>
                </div>
                {{--描述--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="description" placeholder="一句话描述" value="{{$info->description or ''}}"></div>
                        {{--<div><textarea name="description" id="" cols="100%" rows="3">{{$info->description or ''}}</textarea></div>--}}
                    </div>
                </div>
                {{--portrait--}}
                <div class="form-group">
                    <label class="control-label col-md-2">portrait</label>
                    <div class="col-md-8 ">
                        <div><input type="file" name="portrait" placeholder="请上传头像" value="{{$info->portrait or ''}}"></div>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" onclick="" class="btn btn-primary" id="edit-info-submit"><i class="fa fa-check"></i>提交</button>
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
        $("#edit-info-submit").on('click', function() {
            var options = {
                url: "/home/info/edit",
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
            $("#form-edit-info").ajaxSubmit(options);
        });
    });
</script>
@endsection