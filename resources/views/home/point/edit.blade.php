@extends('home.layout.layout')

@section('title')
    @if($operate == 'create') 添加时间点 @else 编辑时间点 @endif
@endsection

@section('header')
    @if($operate == 'create') 添加时间点 @else 编辑时间点 @endif
@endsection

@section('description')
    @if($operate == 'create') 添加时间点 @else 编辑时间点 @endif
@endsection

@section('breadcrumb')
    <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>首页</a></li>
    <li><a href="{{url('/home/item/list?category=timeline')}}"><i class="fa "></i>时间线列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info form-container">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">
                    @if($operate == 'create') 添加时间点
                    @else <a target="_blank" href="{{url('/item/'.$item->id)}}">{{$item->title or '编辑时间点'}}</a>
                    @endif
                </h3>
                <div class="box-tools pull-right">
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-item">
            <div class="box-body">

                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{$operate or 'create'}}" readonly>
                <input type="hidden" name="id" value="{{$encode_id or encode(0)}}" readonly>
                <input type="hidden" name="item_id" value="{{$item->encode or encode(0)}}" readonly>

                {{--时间--}}
                <div class="form-group">
                    <label class="control-label col-md-2">时间点</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="time_point" placeholder="时间点" value="{{$data->time_point or ''}}"></div>
                    </div>
                </div>
                {{--标题--}}
                <div class="form-group">
                    <label class="control-label col-md-2">标题</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="title" placeholder="标题" value="{{$data->title or ''}}"></div>
                    </div>
                </div>
                {{--说明--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        <div><textarea class="form-control" name="description" rows="3" placeholder="描述">{{$data->description or ''}}</textarea></div>
                    </div>
                </div>
                {{--内容--}}
                <div class="form-group">
                    <label class="control-label col-md-2">介绍详情</label>
                    <div class="col-md-8 ">
                        <div>
                            @include('UEditor::head')
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain">{!! $data->content or '' !!}</script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('container');
                                ue.ready(function() {
                                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                });
                            </script>
                        </div>
                    </div>
                </div>

                {{--cover 封面图片--}}
                <div class="form-group">
                    <label class="control-label col-md-2">封面图片</label>
                    <div class="col-md-8 fileinput-group">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if(!empty($data->cover_pic))
                                    <img src="{{url(env('DOMAIN_CDN').'/'.$data->cover_pic)}}" alt="" />
                                @endif
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail">
                            </div>
                            <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input type="file" name="cover" />
                                </span>
                                <span class="">
                                    <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                                </span>
                            </div>
                        </div>
                        <div id="titleImageError" style="color: #a94442"></div>

                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-item-submit"><i class="fa fa-check"></i> 提交</button>
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
        // 修改信息
        $("#edit-item-submit").on('click', function() {
            var options = {
                url: "/home/item/point/edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/home/item/point?id={{$item->encode or encode(0)}}";
                    }
                }
            };
            $("#form-edit-item").ajaxSubmit(options);
        });
    });
</script>
@endsection
