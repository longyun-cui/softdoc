@foreach($courses as $num => $item)
<div class="item-piece item-option course-option items {{$item_magnitude or 'item-plural'}}"
     data-course="{{encode($item->id)}}"
     data-content="{{encode(0)}}">
    <!-- BEGIN PORTLET-->
    <div class="panel-default box-default item-entity-container">

        {{--header--}}
        <div class="box-body item-title-row">
            <a href="{{url('/course/'.encode($item->id))}}">{{$item->title or ''}}</a>
        </div>

        <div class="box-body item-info-row text-muted">
            <span><a href="{{url('/u/'.encode($item->user->id))}}">{{$item->user->name or ''}}</a></span>
            <span> • {{ $item->created_at->format('n月j日 H:i') }}</span>
            <span> • 阅读 <span class="text-blue">{{ $item->visit_num }}</span> 次</span>
            <span class="pull-right"><a class="show-menu" style="cursor:pointer">查看目录</a></span>
        </div>

        {{--menu--}}
        <div class="box-body item-menu-container menu-container">
            <div class="colo-md-12 text-muted" style="margin-bottom:8px;">目录结构</div>
            @foreach($item->contents as $content)
                <div class="box-body" style="padding:2px 10px;">
                    <a href="{{ url('course/'.encode($item->id).'?content='.encode($content->id)) }}">
                        <i class="fa fa-list-ol"></i> &nbsp; {{ $content->title or '' }}
                    </a>
                </div>
            @endforeach
        </div>

        {{--description--}}
        @if(!empty($item->description))
            <div class="box-body item-description-row">
                <div class="colo-md-12 text-muted"> {!! $item->description or '' !!} </div>
            </div>
        @endif

        {{--content--}}
        @if(!empty($item->content))
            <div class="box-body item-content-row">
                <div class="media">
                    <div class="media-left">
                        @if(!empty($item->cover_pic))
                            <img class="media-object" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$item->cover_pic }}">
                        @else
                            <img class="media-object" src="{{ $item->img_tags[2][0] or '' }}">
                        @endif
                    </div>
                    <div class="media-body">
                        <div class="clearfix">
                            <article class="colo-md-12"> {!! $item->content_show or '' !!} </article>
                        </div>
                    </div>
                </div>
                {{--<article class="colo-md-12"> {!! $item->content or '' !!} </article>--}}
            </div>
        @endif


        {{--tools--}}
        <div class="box-footer item-tools-row">

            {{--点赞--}}
            <a class="margin favor-btn" data-num="{{$item->favor_num}}" role="button">
                @if(Auth::check())
                    @if($item->others->contains('type', 1))
                        <span class="favor-this-cancel"><i class="fa fa-thumbs-up text-red"></i>
                    @else
                        <span class="favor-this"><i class="fa fa-thumbs-o-up"></i>
                    @endif
                @else
                    <span class="favor-this"><i class="fa fa-thumbs-o-up"></i>
                @endif

                @if($item->favor_num) {{$item->favor_num}} @endif </span>
            </a>

            {{--收藏--}}
            <a class="margin collect-btn" data-num="{{$item->collect_num}}" role="button">
                @if(Auth::check())
                    @if($item->user_id != Auth::id())
                        @if(count($item->collections))
                            <span class="collect-this-cancel"><i class="fa fa-heart text-red"></i>
                        @else
                            <span class="collect-this"><i class="fa fa-heart-o"></i>
                        @endif
                    @else
                        <span class="collect-mine"><i class="fa fa-heart-o"></i>
                    @endif
                @else
                    <span class="collect-this"><i class="fa fa-heart-o"></i>
                @endif

                @if($item->collect_num) {{$item->collect_num}} @endif </span>
            </a>

            <a class="margin _none" role="button">
                <i class="fa fa-share"></i> @if($item->share_num) {{$item->share_num}} @endif
            </a>

            <a class="margin comment-toggle" role="button" data-num="{{$item->comment_num}}">
                <i class="fa fa-commenting-o"></i> @if($item->comment_num) {{$item->comment_num}} @endif
            </a>

        </div>


        {{--comment--}}
        <div class="box-body comment-container">

            <input type="hidden" class="comments-get comments-get-default">

            <div class="box-body comment-input-container">
                <form action="" method="post" class="form-horizontal form-bordered item-comment-form">

                    {{csrf_field()}}
                    <input type="hidden" name="course_id" value="{{encode($item->id)}}" readonly>
                    <input type="hidden" name="content_id" value="{{encode(0)}}" readonly>
                    <input type="hidden" name="type" value="1" readonly>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div><textarea class="form-control" name="content" rows="3" placeholder="请输入你的评论"></textarea></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 ">
                            <button type="button" class="btn btn-block btn-flat btn-primary comment-submit">提交</button>
                        </div>
                    </div>

                </form>
            </div>


            {{--评论列表--}}
            <div class="box-body comment-entity-container">

                <div class="comment-list-container">
                </div>

                <div class="col-md-12 more-box">
                    <a href="{{url('/course/'.encode($item->id))}}" target="_blank">
                        <button type="button" class="btn btn-block btn-flat btn-default item-more"></button>
                    </a>
                </div>

            </div>

        </div>

    </div>
    <!-- END PORTLET-->
</div>
@endforeach