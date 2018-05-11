<aside class="main-sidebar hidden-md hidden-lg">

    {{--<!-- sidebar: style can be found in sidebar.less -->--}}
    <section class="sidebar course-menu-sm-container side-menu" style="padding-bottom:32px;margin-top:0;">

        <div class="col-xs-12 col-sm-12 col-md-12 recursion-menu" style="color:#eee;">
                <span class="recursion-icon" style="color:orange;">
                    <i class="fa fa-bookmark"></i>
                </span>
            <span class="recursion-text @if(empty($content)) active @endif">
                    <a href="{{url('/course/'.encode($course->id))}}">
                        {{ $course->title or '' }}
                    </a>
                </span>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 recursion-menu" style="color:#eee;">
                <span class="recursion-icon" style="color:orange;">
                    <i class="fa fa-user"></i>
                </span>
            <span class="recursion-text recursion-user">
                    <a href="{{url('/u/'.$course->user->encode_id)}}"><b class="text-white">{{ $course->user->name }}</b></a>
                </span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 recursion-menu">
                <span class="recursion-icon" style="color:orange;">
                    <i class="fa fa-tv"></i>
                </span>
            <span class="recursion-text">
                    <a href="javascript:void(0)">浏览 <span class="text-white">{{ $course->visit_num or 0 }}</span> 次</a>
                </span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 recursion-menu">
                <span class="recursion-icon" style="color:orange;">
                    <i class="fa fa-commenting-o"></i>
                </span>
            <span class="recursion-text">
                    <a href="javascript:void(0)">评论 <span class="text-white">{{ $course->comments_total or 0 }}</span> 个</a>
                </span>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12" style="margin:8px 0;color:#666;">
            <div class="col-xs-6 col-sm-6 col-md-6 fold-button fold-down">
                    <span class="">
                        <i class="fa fa-plus-square"></i> &nbsp; 全部展开
                    </span>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 fold-button fold-up">
                    <span class="">
                        <i class="fa fa-minus-square"></i> &nbsp; 全部折叠
                    </span>
            </div>
        </div>

        @foreach( $course->contents_recursion as $key => $recursion )
            <div class="col-xs-12 col-sm-12 col-md-12 recursion-row" data-level="{{$recursion->level or 0}}" data-id="{{$recursion->id or 0}}"
                 style="padding:0 15px;color:#eee;">
                <div class="recursion-menu" style="margin-left:{{ $recursion->level*24 }}px">
                        <span class="recursion-icon">
                            @if($recursion->type == 1)
                                @if($recursion->has_child == 1)
                                    <i class="fa fa-minus-square recursion-fold"></i>
                                @else
                                    <i class="fa fa-file-text"></i>
                                @endif
                            @else
                                <i class="fa fa-file-text"></i>
                            @endif
                        </span>
                    <span class="recursion-text @if(!empty($content)) @if($recursion->id == $content->id) active @endif @endif">
                            <a href="{{url('/course/'.encode($course->id).'?content='.encode($recursion->id))}}">
                                {{ $recursion->title or '' }}
                            </a>
                        </span>
                </div>
            </div>
    @endforeach

    <!-- /.sidebar-menu -->
    </section>
    {{--<!-- /.sidebar -->--}}
</aside>