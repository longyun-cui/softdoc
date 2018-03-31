@extends('home.layout.layout')

@section('title','基本信息')
@section('header','基本信息')
@section('description','基本信息')
@section('breadcrumb')
    <li><a href="{{url('/home')}}"><i class="fa fa-home"></i>首页</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">基本信息</h3>
                <div class="pull-right">
                    <a href="{{url('/home/info/edit')}}">
                        <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa "></i>编辑信息</button>
                    </a>
                </div>
            </div>

            <form class="form-horizontal form-bordered">
            <div class="box-body">
                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">用户名：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$info->name or ''}}</label></div>
                    </div>
                </div>
                {{--简称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">昵称：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$info->nickname or ''}}</label></div>
                    </div>
                </div>
                {{--标语 Slogan--}}
                <div class="form-group">
                    <label class="control-label col-md-2">真实姓名：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$info->truename or ''}}</label></div>
                    </div>
                </div>
                {{--电话--}}
                <div class="form-group">
                    <label class="control-label col-md-2">电话：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$info->telephone or ''}}</label></div>
                    </div>
                </div>
                {{--邮箱--}}
                <div class="form-group">
                    <label class="control-label col-md-2">邮箱：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$info->email or ''}}</label></div>
                    </div>
                </div>
                {{--描述--}}
                <div class="form-group">
                    <label class="control-label col-md-2">个人描述：</label>
                    <div class="col-md-8 ">
                        <div><label class="">{{$info->description or ''}}</label></div>
                    </div>
                </div>
                {{--portrait--}}
                <div class="form-group">
                    <label class="control-label col-md-2">头像：</label>
                    <div class="col-md-8 ">
                        <div style="width:100px;height:100px;"><img src="{{config('common.host.'.env('APP_ENV').'.cdn').'/'.$info->portrait_img}}" alt=""></div>
                    </div>
                </div>
                {{--qrcode--}}
                <div class="form-group" style="display:none;">
                    <label class="control-label col-md-2">二维码：</label>
                    <div class="col-md-8 ">
                        <a class="btn btn-success _left" target="_blank" href="/admin/download_root_qrcode">下载首页二维码</a>
                    </div>
                </div>
            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8">
                        <a href="{{url('/home/info/edit')}}">
                            <button type="button" onclick="" class="btn btn-success"><i class="fa "></i>编辑信息</button>
                        </a>
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
    });
</script>
@endsection
