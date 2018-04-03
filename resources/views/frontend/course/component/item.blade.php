{{--内容--}}
<div class="item-piece item-option course-option item {{$item_magnitude or 'item-singular'}}"
     data-course="{{$course->encode_id or encode(0)}}"
     data-content="{{$content->encode_id or encode(0)}}"
>

    <div class="boxe panel-default box-default item-entity-container">

        {{--@if(!empty($content))--}}
        {{--@include('frontend.course.component.content')--}}
        {{--@else--}}
        {{--@include('frontend.course.component.course')--}}
        {{--@endif--}}

        <div class="box-header item-title-row with-border -panel-heading">
            <h3 class="box-title"><b>{{$item->title or ''}}</b></h3>
        </div>

        <div class="box-body item-info-row text-muted">
            <span><a href="{{url('/u/'.encode($item->user->id))}}">{{$item->user->name or ''}}</a></span>
            <span> • {{ $item->created_at->format('n月j日 H:i') }}</span>
            <span> • 阅读 <span class="text-blue">{{ $item->visit_num or 0 }}</span> 次</span>
        </div>

        @if(!empty($item->description))
            <div class="box-body item-description-row text-muted">
                <div class="colo-md-12"> {!! $item->description or '' !!} </div>
            </div>
        @endif

        @if(!empty($item->content))
            <div class="box-body item-content-row">
                <div class="colo-md-12"> {!! $item->content or '' !!} </div>
            </div>
        @endif

        <div class="box-footer">
            <div class="colo-md-12 prev-content"> 上一篇 : <span class="a-box"></span> </div>
            <div class="colo-md-12 next-content" style="margin-top:10px;"> 下一篇 : <span class="a-box"></span> </div>
        </div>

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

            <a class="margin comment-btn" role="button" data-num="{{$item->comment_num}}">
                <i class="fa fa-commenting-o"></i> @if($item->comment_num) {{$item->comment_num}} @endif
            </a>

        </div>

        {{--comment--}}
        <div class="box-body comment-container">

            <input type="hidden" class="comments-get comments-get-default">

            {{--添加评论--}}
            <div class="box-body comment-input-container">
                <form action="" method="post" class="form-horizontal form-bordered item-comment-form">

                    {{csrf_field()}}
                    <input type="hidden" name="course_id" value="{{$course->encode_id or encode(0)}}" readonly>
                    <input type="hidden" name="content_id" value="{{$content->encode_id or encode(0)}}" readonly>
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

                <div class="col-md-12 more-box comment-more-box">
                    <button type="button" class="btn btn-block btn-flat btn-more comments-more"></button>
                </div>

            </div>

        </div>

    </div>

</div>