<div class="item-piece item-option item" data-item="{{ $item->id }}">
    <div class="panel-default box-default item-entity-container">

        <div class="box-body item-title-row">
            <b>{{ $item->title or '' }}</b>
        </div>

        <div class="box-body item-info-row text-muted">
            {{--<span> • {{ $item->created_at->format('n月j日 H:i') }}</span>--}}
            <span>{{ time_show($item->created_at) }}</span>
            <span> • 阅读({{ $item->visit_num }})</span>
        </div>

    </div>
</div>


<div class="item-piece item-option item" data-item="{{ $item->id }}">
    <!-- BEGIN PORTLET-->
    <div class="panel-default box-default item-entity-container">

        {{--description--}}
        {{--@if(!empty($item->description))--}}
            {{--<div class="box-body item-description-row">--}}
                {{--<div class="colo-md-12 text-muted"> {!! $item->description or '' !!} </div>--}}
            {{--</div>--}}
        {{--@endif--}}

        {{--content--}}
        <div class="box-body item-content-row">
            <article class="colo-md-12"> {!! $item->content or '' !!} </article>
        </div>

        {{--tools--}}
        <div class="box-footer item-tools-row">

            <div class="pull-left _none">
                <a class="margin" role="button">
                    {{--{{ time_show($item->created_at) }}--}}
                </a>
            </div>

            <div class="pull-right">

                <a class="margin _none" role="button">
                    ({{ $item->share_num or '' }})
                </a>

                <a class="margin _none" role="button" data-num="{{ $item->comment_num or 0 }}">
                    阅读({{ $item->visit_num }})
                </a>

                <a class="margin comment-toggle" role="button" data-num="{{ $item->comment_num or 0 }}">
                    评论({{ $item->comment_num }})
                </a>

                {{--点赞--}}
                <a class="margin favor-btn" data-num="{{ $item->favor_num or 0 }}" role="button">
                    @if(Auth::check() && $item->pivot_item_relation->contains('type', 1))
                        <span class="favor-this-cancel"><i class="fa fa-thumbs-up text-red"></i>({{ $item->favor_num }})</span>
                    @else
                        <span class="favor-this"><i class="fa fa-thumbs-o-up"></i>({{ $item->favor_num }})</span>
                    @endif
                </a>

            </div>

        </div>


        {{--comment--}}
        <div class="box-body comment-container _none">

            <input type="hidden" class="comments-get comments-get-default">

            <div class="box-body comment-input-container">
                <form action="" method="post" class="form-horizontal form-bordered item-comment-form">

                    {{csrf_field()}}
                    <input type="hidden" name="course_id" value="{{encode($item->id)}}" readonly>
                    <input type="hidden" name="type" value="1" readonly>

                    <div class="form-group">
                        <div class="col-md-9">
                            <div><textarea class="form-control" name="content" rows="1" placeholder="请输入你的评论"></textarea></div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-block btn-primary comment-submit">提交</button>
                        </div>
                    </div>

                    <div class="form-group">
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