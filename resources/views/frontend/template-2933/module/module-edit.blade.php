<div class="row" style="background:#fff;">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info form-container">

            <div class="row" style="margin:16px 0;">
                <h3 class="pull-left"><b>@if($operate == 'create') 创作新内容 @else 编辑内容 @endif</b></h3>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-item">
            <div class="box-body">

                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{$operate or 'create'}}" readonly>
                <input type="hidden" name="id" value="{{$encode_id or encode(0)}}" readonly>

                {{--类别--}}
                <div class="form-group form-category">
                    <label class="col-md-12">类别</label>
                    <div class="col-md-12">
                        <div class="btn-group">

                            @if($operate == 'edit')
                                <label role="button">
                                    <input type="radio" name="category-" value="{{ $data->category or 0 }}" checked="checked">
                                    @if($data->category == 1) 文章类型
                                    @elseif($data->category == 7) 辩题类型
                                    @elseif($data->category == 11) 文件目录类型
                                    @elseif($data->category == 18) 时间线类型
                                    @endif
                                </label>
                            @elseif($operate == 'create')
                                <label class="btn" role="button">
                                    <input type="radio" name="category" value="1" checked="checked"> 文章类型
                                </label>
                                <label class="btn" role="button">
                                    <input type="radio" name="category" value="11"> 目录类型
                                </label>
                                <label class="btn" role="button">
                                    <input type="radio" name="category" value="18"> 时间线类型
                                </label>
                                <label class="btn" role="button">
                                    <input type="radio" name="category" value="7" role="button"> 辩题类型
                                </label>
                            @endif

                        </div>
                    </div>
                </div>

                @if($operate == 'create' || ($operate == 'edit' && $data->time_type == 1) )
                {{--是否选择时间--}}
                <div class="form-group article-show">
                    <label class="col-md-12">是否为日程</label>
                    <div class="col-md-12">
                        <div class="btn-group">

                            @if($operate == 'edit')
                                <label role="button">
                                    <input type="radio" name="time_type-" value="{{ $data->time_type or 0 }}" checked="checked">
                                    @if($data->time_type == 0) 非日程
                                    @elseif($data->time_type == 1) 日程
                                    @endif
                                </label>
                            @elseif($operate == 'create')
                                <label class="btn" role="button">
                                    <input type="radio" name="time_type" value="0" checked="checked"> 非日程
                                </label>
                                <label class="btn" role="button">
                                    <input type="radio" name="time_type" value="1"> 日程
                                </label>
                            @endif

                        </div>
                    </div>
                </div>
                @endif
                {{--时间选择器--}}
                <div class="form-group article-show time-show" style="display:none;">
                    <div class="col-md-12 ">
                        <div class="col-md-6" style="padding-left:0;">
                            <input type="text" class="form-control" name="start_time" placeholder="选择开始时间" value="{{$data->start_time or ''}}">
                        </div>
                        <div class="col-md-6" style="padding-right:0;">
                            <input type="text" class="form-control" name="end_time" placeholder="选择结束时间" value="{{$data->end_time or ''}}">
                        </div>
                    </div>
                </div>

                @if($operate == 'edit' && $data->time_type == 1)
                    <div class="form-group">
                        <div class="col-md-12 ">
                            <div class="col-md-6" style="padding-left:0;">
                                <input type="text" readonly class="form-control" name="start_time-" value="@if($data->start_time != 0){{ time_show($data->start_time) }}@endif">
                            </div>
                            <div class="col-md-6" style="padding-right:0;">
                                <input type="text" readonly class="form-control" name="end_time-" value="@if($data->end_time != 0){{ time_show($data->end_time) }}@endif">
                            </div>
                        </div>
                    </div>
                @endif

                {{--标题--}}
                <div class="form-group">
                    <label class=" col-md-12">标题</label>
                    <div class="col-md-12 ">
                        <div><input type="text" class="form-control" name="title" placeholder="请输入标题" value="{{$data->title or ''}}"></div>
                    </div>
                </div>
                <div class="form-group debate-show _none">
                    <label class=" col-md-12">正方观点</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="custom[positive]" placeholder="正方观点" value="{{$data->custom->positive or ''}}"></div>
                    </div>
                </div>
                <div class="form-group debate-show _none">
                    <label class=" col-md-12">反方观点</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="custom[negative]" placeholder="正方观点" value="{{$data->custom->negative or ''}}"></div>
                    </div>
                </div>
                {{--说明--}}
                <div class="form-group">
                    <label class=" col-md-12">描述</label>
                    <div class="col-md-12 ">
                        <div><textarea class="form-control" name="description" rows="3" placeholder="描述">{{$data->description or ''}}</textarea></div>
                    </div>
                </div>
                {{--内容--}}
                <div class="form-group">
                    <label class=" col-md-12">图文详情</label>
                    <div class="col-md-12 ">
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
                    <label class=" col-md-12">封面图片</label>
                    <div class="col-md-8 fileinput-group">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if(!empty($data->cover_pic))
                                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->cover_pic) }}" alt="" />
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

                @if($operate == 'create')
                <div class="form-group">
                    <label class=" col-md-12">待办事</label>
                    <div class="col-md-12">
                        <div class="btn-group">
                            <label class="btn checkbox-" role="button">
                                <input type="checkbox" name="is_working" value="1"> 添加到我的待办事
                            </label>
                        </div>
                    </div>
                </div>
                @endif

                {{--分享--}}
                @if($operate == 'create')
                    <div class="form-group form-type">
                        <label class=" col-md-12">分享</label>
                        <div class="col-md-12">
                            <div class="btn-group">

                                <label class="btn" role="button">
                                    <input type="radio" name="is_shared" value="11" checked="checked"> 仅自己可见
                                </label>
                                <label class="btn" role="button">
                                    <input type="radio" name="is_shared" value="41"> 关注可见
                                </label>
                                <label class="btn" role="button">
                                    <input type="radio" name="is_shared" value="100"> 所有人可见
                                </label>

                            </div>
                        </div>
                    </div>
                @endif

            </div>
            </form>

            <div class="row" style="margin:16px 0;">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="edit-item-submit"><i class="fa fa-check"></i> 提交</button>
                    <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                </div>
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
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
@endsection
@section('custom-script')
<script>
    $(function() {

        // 提交
        $("#edit-item-submit").on('click', function() {
            var options = {
                url: "/home/mine/item/edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
//                        layer.msg(data.msg);
                        var $category = $("#form-edit-item").find('input[name=category]:checked').val();
                        if($category == 11)
                        {
                            location.href = "/home/mine/item/edit/menutype?id=" + data.data.id;
                        }
                        else if($category == 18)
                        {
                            location.href = "/home/mine/item/edit/timeline?id=" + data.data.id;
                        }
                        else location.href = "/home/mine/original";
                    }
                }
            };
            $("#form-edit-item").ajaxSubmit(options);
        });


        // 【选择类别】
        $("#form-edit-item").on('click', "input[name=category]", function() {
            var $value = $(this).val();

            if($value == 1) {
                $('.article-show').show();

                // checkbox
//                if($("input[name=time_type]").is(':checked')) {
//                    $('.time-show').show();
//                } else {
//                    $('.time-show').hide();
//                }
                // radio
                var $time_type = $("input[name=time_type]:checked").val();
                if($time_type == 1) {
                    $('.time-show').show();
                } else {
                    $('.time-show').hide();
                }
            } else {
                $('.article-show').hide();
            }

            if($value == 7) {
                $('.debate-show').show();
            } else {
                $('.debate-show').hide();
            }

        });


        // 【选择时间】
        $("#form-edit-item").on('click', "input[name=time_type]", function() {
            // checkbox
//            if($(this).is(':checked')) {
//                $('.time-show').show();
//            } else {
//                $('.time-show').hide();
//            }

            // radio
            var $value = $(this).val();
            if($value == 1) {
                $('.time-show').show();
            } else {
                $('.time-show').hide();
            }
        });


        $('input[name=start_time]').datetimepicker({
            format:"YYYY-MM-DD HH:mm"
        });
        $('input[name=end_time]').datetimepicker({
            format:"YYYY-MM-DD HH:mm"
        });

    });
</script>
@endsection
