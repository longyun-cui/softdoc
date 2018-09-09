@extends('home.layout.layout')

@section('title', '内容管理')

@section('header')
    {{$data->title or ''}}
@endsection

@section('description', '内容管理')

@section('breadcrumb')
    <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>首页</a></li>
    <li><a href="{{url('/home/course/list')}}"><i class="fa "></i>课程列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">内容结构图</h3>
                <div class="pull-right">
                    <button type="button" class="btn btn-success pull-right show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
                </div>
            </div>

            <div class="box-body" id="content-structure-list">
                @foreach( $data->contents_recursion as $key => $content )
                    <div class="col-md-8 col-md-offset-2">
                        <div class="input-group" data-id='{{$content->id}}'
                             style="margin-top:4px; margin-left:{{ $content->level*40 }}px">
                            <span class="input-group-addon">
                                @if($content->type == 1)
                                    <i class="fa fa-list-ul"></i>
                                @else
                                    <i class="fa fa-file-text"></i>
                                @endif
                            </span>
                            <span class="form-control">{{ $content->title or '' }}</span>

                            @if($content->type == 1)
                            <span class="input-group-addon btn create-follow-menu" style="border-left:0;"><i class="fa fa-plus"></i></span>
                            @endif
                            <span class="input-group-addon btn edit-this-content" style="border-left:0;"><i class="fa fa-pencil"></i></span>
                            <span class="input-group-addon btn delete-this-content"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-9 col-md-offset-2">
                        <a href="{{ url('/course/'.$data->encode_id) }}" target="_blank"><button type="button" class="btn btn-primary">预览</button></a>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title"> @if(empty($encode_id)) 添加内容 @else 编辑目录 @endif </h3>
                <div class="pull-right">
                    <button type="button" class="btn btn-success pull-right show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-content">
                <div class="box-body">

                    {{csrf_field()}}
                    <input type="hidden" name="operate" value="{{$operate or 'create'}}" readonly>
                    <input type="hidden" name="course_id" value="{{$data->encode_id or encode(0)}}" readonly>
                    <input type="hidden" name="id" value="{{$encode_id or encode(0)}}" readonly>

                    {{--类型--}}
                    <div class="form-group form-type">
                        <label class="control-label col-md-2">类型</label>
                        <div class="col-md-8">
                            <div class="btn-group">
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" value="1" checked="checked"> 目录
                                        </label>
                                    </div>
                                </button>
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" value="2"> 内容
                                        </label>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{--目录--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">目录</label>
                        <div class="col-md-8 ">
                            <select name="p_id" id="menu" style="width:100%;">

                                <option value="0">顶级目录</option>

                                @foreach( $data->contents_recursion as $key => $content )
                                    @if($content->type == 1)

                                        <option value="{{ $content->id or '' }}">
                                            @for ($i = 0; $i < $content->level; $i++)
                                                —
                                            @endfor
                                            {{ $content->title or '' }}
                                        </option>

                                    @endif
                                @endforeach

                            </select>
                        </div>
                    </div>
                    {{--标题--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">标题</label>
                        <div class="col-md-8 ">
                            <div><input type="text" class="form-control" name="title" placeholder="请输入标题" value=""></div>
                        </div>
                    </div>
                    {{--描述--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">描述</label>
                        <div class="col-md-8 ">
                            <div><textarea class="form-control" name="description" rows="3" placeholder="描述"></textarea></div>
                        </div>
                    </div>
                    {{--内容--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">详情</label>
                        <div class="col-md-8 ">
                            <div>
                            @include('UEditor::head')
                            <!-- 加载编辑器的容器 -->
                                <script id="container" name="content" type="text/plain"></script>
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

                </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-content-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" class="btn btn-default" onclick="history.go(-1);">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>


<div class="modal fade" id="edit-modal">
    <div class="col-md-8 col-md-offset-2" id="edit-ctn" style="margin-top:64px;margin-bottom:64px;padding-top:32px;background:#fff;"></div>
</div>


@endsection


@section('js')
<script src="https://cdn.bootcss.com/select2/4.0.5/js/select2.min.js"></script>
<script>
    $(function() {
        // 修改幻灯片信息
        $("#edit-content-submit").on('click', function() {
            var options = {
                url: "/home/course/content/edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.reload();
                    }
                }
            };
            $("#form-edit-content").ajaxSubmit(options);
        });

        // 显示添加列
        $(".show-create-content").on('click', function() {

            reset_form();

            $("html, body").animate({ scrollTop: $("#form-edit-content").offset().top }, {duration: 500,easing: "swing"});

        });




        // 在该目录下添加内容
        $("#content-structure-list").on('click', '.create-follow-menu', function () {
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');

            reset_form();

            $('#menu').find('option[value='+id+']').attr('selected','selected');

            $("html, body").animate({ scrollTop: $("#form-edit-content").offset().top }, {duration: 500,easing: "swing"});
        });

        // 在该目录下添加内容
        $("#content-structure-list").on('click', '.edit-this-content', function () {
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');

            var result;
            $.post(
                "/home/course/content/get",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    id:id
                },
                function(data){
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        $("#form-edit-content").find('input[name=operate]').val("edit");
                        $("#form-edit-content").find('input[name=id]').val(data.data.encode_id);

                        $("#form-edit-content").find('input[name=title]').val(data.data.title);
                        $("#form-edit-content").find('textarea[name=description]').val(data.data.description);

                        var content = data.data.content;
                        if(data.data.content == null) content = '';
                        var ue = UE.getEditor('container');
                        ue.setContent(content);

                        var type = data.data.type;
                        $("#form-edit-content").find('input[name=type]').prop('checked',null);
                        $("#form-edit-content").find('input[name=type][value='+type+']').prop('checked',true);
                        if(type == 1) $("#form-edit-content").find('.form-type').hide();
                        else $("#form-edit-content").find('.form-type').show();

                        $('#menu').find('option').prop('selected',null);
                        $('#menu').find('option[value='+data.data.p_id+']').prop("selected", true);
                        var selected_text = $('#menu').find('option[value='+data.data.p_id+']').text();
                        $("html, body").animate({ scrollTop: $("#form-edit-content").offset().top }, {duration: 500,easing: "swing"});

                    }
                },
                'json'
            );

        });

        // 删除该内容
        $("#content-structure-list").on('click', '.delete-this-content', function () {
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var msg = '确定要删除该"内容"么，该内容下子内容自动进入父节点';

            layer.msg(msg, {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/home/course/content/delete",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:id
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else location.reload();
                        },
                        'json'
                    );
                }
            });
        });




        // 取消添加or编辑
        $("#edit-modal").on('click', '.cansel-this-content', function () {
            $('#edit-ctn').html('');
            $('#edit-modal').modal('hide');
        });

        // 取消添加or编辑
        $("#edit-modal").on('click', '.create-this-content', function () {
            var options = {
                url: "/home/course/edits",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.reload();
                    }
                }
            };
            $("#form-edit-content").ajaxSubmit(options);
        });

    });

    function reset_form()
    {
        $("#form-edit-content").find('.form-type').show();

        $("#form-edit-content").find('input[name=operate]').val("create");
        $("#form-edit-content").find('input[name=id]').val("{{encode(0)}}");
        $("#form-edit-content").find('input[name=title]').val("");
        $("#form-edit-content").find('textarea[name=description]').val("");
        var ue = UE.getEditor('container');
        ue.setContent("");

        $("#form-edit-content").find('input[name=type]').prop('checked',null);
        $("#form-edit-content").find('input[name=type][value=1]').prop('checked',true);

        $('#menu').find('option').prop('selected',null);
        $('#menu').find('option[value=0]').prop("selected", true);
    }
</script>
@endsection
