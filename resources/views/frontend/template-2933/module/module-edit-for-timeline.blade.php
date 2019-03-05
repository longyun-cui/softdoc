<div class="row" style="background:#fff;">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box">

            <div class="row" style="margin:16px 0;">
                <h3 class="pull-left"><b>时间点</b></h3>
                <div class="pull-right">
                    <button type="button" class="btn btn-success pull-right show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
                </div>
            </div>

            <div class="row" id="content-structure-list">
                {{--封面--}}
                <div class="col-md-12">
                    <div class="input-group" data-id='{{ $data->id }}' style="margin-top:4px;margin-bottom:12px;">
                        <span class="input-group-addon"><b>封面</b></span>
                        <span class="form-control multi-ellipsis-1">{{ $data->title or '' }}</span>
                        <span class="input-group-addon btn edit-this-content" style="border-left:0;"><i class="fa fa-pencil"></i></span>
                    </div>
                </div>
                @foreach( $data->contents as $key => $content )
                    <div class="col-md-12">
                        <div class="input-group" data-id='{{ $content->id }}'
                             style="margin-top:4px; margin-left:{{ $content->level*40 }}px">
                            <span class="input-group-addon"><b>{{ $content->time_point or '' }}</b></span>
                            <span class="form-control multi-ellipsis-1">{{ $content->title or '' }}</span>

                            @if($content->active == 0)
                                <span class="input-group-addon btn enable-this-content" title="启用"><b>未启用</b></span>
                            @elseif($content->active == 1)
                                <span class="input-group-addon btn disable-this-content" title="禁用"><b class="text-green">已启用</b></span>
                            @else
                                <span class="input-group-addon btn enable-this-content" title="启用"><b class="text-red">已禁用</b></span>
                            @endif

                            <span class="input-group-addon btn edit-this-content" style="border-left:0;"><i class="fa fa-pencil"></i></span>
                            <span class="input-group-addon btn delete-this-content"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row" style="margin:32px 0;">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
                    <a href="{{ url('/item/'.$data->id) }}" target="_blank"><button type="button" class="btn btn-primary">预览</button></a>
                    <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>


<div class="row" style="margin-top:8px;background:#fff;">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box form-container">

            <div class="row" style="margin:16px 0;">
                <h3 class="pull-left">添加/编辑内容</h3>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-content">
                <div class="box-body">

                    {{csrf_field()}}
                    <input type="hidden" name="operate" value="{{$operate or 'create'}}" readonly>
                    <input type="hidden" name="item_id" value="{{$data->encode_id or encode(0)}}" readonly>
                    <input type="hidden" name="id" value="{{$encode_id or encode(0)}}" readonly>
                    <input type="hidden" name="category" value="18" readonly>

                    {{--时间点--}}
                    <div class="form-group" id="form-time-point-option">
                        <label class=" col-md-12">时间点</label>
                        <div class="col-md-12">
                            <div><input type="text" class="form-control" name="time_point" placeholder="时间点" value=""></div>
                        </div>
                    </div>
                    {{--标题--}}
                    <div class="form-group">
                        <label class=" col-md-12">标题</label>
                        <div class="col-md-12">
                            <div><input type="text" class="form-control" name="title" placeholder="请输入标题" value=""></div>
                        </div>
                    </div>
                    {{--描述--}}
                    <div class="form-group">
                        <label class=" col-md-12">描述</label>
                        <div class="col-md-12">
                            <div><textarea class="form-control" name="description" rows="3" placeholder="描述"></textarea></div>
                        </div>
                    </div>
                    {{--内容--}}
                    <div class="form-group">
                        <label class=" col-md-12">图文详情</label>
                        <div class="col-md-12">
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

                    {{--cover 封面图片--}}
                    <div class="form-group">
                        <label class=" col-md-12">封面图片</label>
                        <div class="col-md-8 fileinput-group">

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail cover-box">
                                    {{--@if(!empty($data->cover_pic))--}}
                                    {{--<img src="{{ url(env('DOMAIN_CDN').'/'.$data->cover_pic) }}" alt="" />--}}
                                    {{--@endif--}}
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

                    {{--是否启用--}}
                    <div class="form-group form-active" id="form-active-option">
                        <label class=" col-md-12">是否启用</label>
                        <div class="col-md-12">
                            <div class="btn-group">

                                <button type="button" class="btn radio active-none">
                                    <label>
                                        <input type="radio" name="active" value="0"> 不启用
                                    </label>
                                </button>
                                <button type="button" class="btn radio">
                                    <label>
                                        <input type="radio" name="active" value="1" checked="checked"> 启用
                                    </label>
                                </button>
                                <button type="button" class="btn radio active-disable _none">
                                    <label>
                                        <input type="radio" name="active" value="9"> 禁用
                                    </label>
                                </button>

                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="row" style="margin:16px 0;">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="edit-content-submit"><i class="fa fa-check"></i> 提交</button>
                    <button type="button" class="btn btn-default" onclick="history.go(-1);">返回</button>
                </div>
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>


<div class="modal fade" id="edit-modal">
    <div class="col-md-8 col-md-offset-2" id="edit-ctn" style="margin-top:64px;margin-bottom:64px;padding-top:32px;background:#fff;"></div>
</div>




@section('custom-css')
    <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/css/fileinput.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('common/css/component/fileinput.css') }}" media="all" />
    <link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@endsection


@section('custom-js')
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
    <script src="{{ asset('common/js/component/fileinput-only.js') }}"></script>
    <script src="https://cdn.bootcss.com/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdn.bootcss.com/select2/4.0.5/js/select2.min.js"></script>
@endsection
@section('custom-script')
<script>
    $(function() {

        // 修改
        $("#edit-content-submit").on('click', function() {
            var options = {
                url: "/home/item/content/edit/timeline",
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

            $("#form-edit-content").find('input[name=rank]').val(0);
            $("#form-edit-content").find('.active-disable').hide();
            $("#form-edit-content").find('.active-none').show();
            $('#form-edit-content').find('input[name=active][value="1"]').prop('checked',true);

            $("html, body").animate({ scrollTop: ($("#form-edit-content").offset().top - 120) }, {duration: 500,easing: "swing"});

        });





        // 编辑内容
        $("#content-structure-list").on('click', '.edit-this-content', function () {
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');

            var result;
            $.post(
                "/home/item/content/get",
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
                        $("#form-edit-content").find('input[name=time_point]').val(data.data.time_point);

                        if(data.data.encode_id == $("#form-edit-content").find('input[name=item_id]').val())
                        {
                            console.log('封面');
                            $("#form-edit-content").find('input[name=time_point]').val(0);
                            $("#form-time-point-option").hide();
                            $("#form-active-option").hide();
                        }
                        else
                        {
                            $("#form-time-point-option").show();
                            $("#form-active-option").show();
                        }

                        $("#form-edit-content").find('input[name=active]:checked').prop('checked','');
                        var $active = data.data.active;
                        $("#form-edit-content").find('.active-none').hide();
                        $("#form-edit-content").find('.active-disable').show();
                        if($active == 0) $("#form-edit-content").find('.active-none').show();
                        $("#form-edit-content").find('input[name=active][value='+$active+']').prop('checked','checked');

                        $("#form-edit-content").find('input[name=title]').val(data.data.title);
                        $("#form-edit-content").find('textarea[name=description]').val(data.data.description);
                        if(data.data.cover_pic != null)
                        {
                            $("#form-edit-content").find('.cover-box').html(data.data.cover_img);
                        }

                        var content = data.data.content;
                        if(data.data.content == null) content = '';
                        var ue = UE.getEditor('container');
                        ue.setContent(content);

//                        var type = data.data.type;
//                        $("#form-edit-content").find('input[name=type]').prop('checked',null);
//                        $("#form-edit-content").find('input[name=type][value='+type+']').prop('checked',true);
//                        if(type == 1) $("#form-edit-content").find('.form-type').hide();
//                        else $("#form-edit-content").find('.form-type').show();

                        $("html, body").animate({ scrollTop: ($("#form-edit-content").offset().top - 120) }, {duration: 500,easing: "swing"});

                    }
                },
                'json'
            );

        });

        // 删除该内容
        $("#content-structure-list").on('click', '.delete-this-content', function () {
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var $msg = '确定要删除该"内容"么？';

            layer.msg($msg, {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/home/item/content/delete",
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


        // 【启用】
        $("#content-structure-list").on('click', ".enable-this-content", function() {
            var that = $(this);
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var $msg = '启用该内容？';

            layer.$msg('启用该内容？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/home/item/content/enable",
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

        // 【禁用】
        $("#content-structure-list").on('click', ".disable-this-content", function() {
            var that = $(this);
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var $msg = '禁用该内容？';

            layer.$msg('禁用该内容？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/home/item/content/disable",
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
                url: "/home/item/edits",
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
//        $("#form-edit-content").find('.form-type').show();

        $("#form-time-point-option").show();
        $("#form-active-option").show();

        $("#form-edit-content").find('input[name=operate]').val("create");
        $("#form-edit-content").find('input[name=id]').val("{{encode(0)}}");
        $("#form-edit-content").find('input[name=time_point]').val("");
        $("#form-edit-content").find('input[name=title]').val("");
        $("#form-edit-content").find('textarea[name=description]').val("");
        var ue = UE.getEditor('container');
        ue.setContent("");
        $("#form-edit-content").find('.cover-box').html("");

        $("#form-edit-content").find('input[name=type]').prop('checked',null);
        $("#form-edit-content").find('input[name=type][value="1"]').prop('checked',true);

        $('#menu').find('option').prop('selected',null);
        $('#menu').find('option[value=0]').prop("selected", true);

        $("#form-edit-content").find('.active-disable').hide();
        $("#form-edit-content").find('.active-none').show();
        $('#form-edit-content').find('input[name=active][value="1"]').prop('checked',true);

    }
</script>
@endsection
