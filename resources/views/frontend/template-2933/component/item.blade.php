@if($item->category != 99)
<div class="item-piece item-option item" data-item="{{ $item->id }}">
    <div class="panel-default box-default item-portrait-container _none">
        <a href="{{ url('/user/'.$item->user->id) }}">
            <img src="{{ url(env('DOMAIN_CDN').'/'.$item->user->portrait_img) }}" alt="">
        </a>
    </div>
    <div class="panel-default box-default item-entity-container">

        <div class="item-row item-title-row margin-bottom-8">
            <span class="item-user-portrait _none"><img src="{{ url(env('DOMAIN_CDN').'/'.$item->user->portrait_img) }}" alt=""></span>
            <span class="item-user-name _none"><a href="{{ url('/user/'.$item->user->id) }}">{{ $item->user->name or '' }}</a></span>
            <b class="item-title">{{ $item->title or '' }}</b>
        </div>

        @if($item->time_type == 1)
            <div class="item-row item-info-row margin-bottom-8">
                @if(!empty($item->start_time))
                    <b class="text-blue">{{ time_show($item->start_time) }}</b>
                @endif
                @if(!empty($item->end_time))
                    &nbsp;&nbsp;<b>--</b>&nbsp;&nbsp;
                    <b class="text-blue">{{ time_show($item->end_time) }}</b>
                @endif
            </div>
        @endif

        @if($item->category == 7)
            <div class="item-row item-info-row">
                <b class="text-red">【正方】 {{ $item->custom_decode->positive }}</b>
            </div>
            <div class="item-row item-info-row">
                <b class="text-blue">【反方】 {{ $item->custom_decode->negative }}</b>
            </div>
        @endif

        <div class="item-row item-info-row text-muted margin-bottom-8">
            {{--<span> • {{ $item->created_at->format('n月j日 H:i') }}</span>--}}
            <span>{{ time_show($item->created_at) }}</span>
            <span> • </span>
            <span>阅读({{ $item->visit_num }})</span>
            <span> • </span>
            <a class="forward-show" data-toggle="modal" data-target="#modal-forward" role="button">分享({{ $item->share_num }})</a>
            <span> • </span>
            {{--点赞--}}
            <a class="operate-btn" role="button" data-num="{{ $item->favor_num or 0 }}">
                @if(Auth::check() && $item->pivot_item_relation->contains('type', 11))
                    <span class="remove-this-favor" title="取消赞"><i class="fa fa-thumbs-up text-red"></i>(<num>{{ $item->favor_num }}</num>)</span>
                @else
                    <span class="add-this-favor" title="点赞"><i class="fa fa-thumbs-o-up"></i>(<num>{{ $item->favor_num }}</num>)</span>
                @endif
             </a>
        </div>

    </div>
</div>
@endif


<div class="item-piece item-option item" data-item="{{ $item->id }}">

    @if($item->category == 99)
    <div class="panel-default box-default item-portrait-container _none">
        <a href="{{ url('/user/'.$item->user->id) }}">
            <img src="{{ url(env('DOMAIN_CDN').'/'.$item->user->portrait_img) }}" alt="">
        </a>
    </div>
    @endif

    <div class="item-entity-container">

        {{--description--}}
        {{--@if(!empty($item->description))--}}
        {{--<div class="box-body item-description-row">--}}
        {{--<div class="colo-md-12 text-muted"> {!! $item->description or '' !!} </div>--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--content--}}
        <div class="item-row item-content-row">

            @if($item->category == 99)
                <article class="item-row colo-md-12 multi-ellipsis-3- margin-bottom-8" style="">{{{ $item->content or '' }}}</article>
                @if(!empty($item->forward_item))
                    <a href="{{ url('/item/'.$item->forward_item->id) }}" target="_blank">
                        <div class="item-row forward-item-container" role="button">
                            <div class="portrait-box"><img src="{{ url(env('DOMAIN_CDN').'/'.$item->forward_item->user->portrait_img) }}" alt=""></div>
                            <div class="text-box">
                                <div class="text-row forward-item-title">{{ $item->forward_item->title or '' }}</div>
                                <div class="text-row forward-user-name">{{ '@'.$item->forward_item->user->name }}</div>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="item-row forward-item-container" role="button" style="line-height:40px;text-align:center;">
                        内容被作者删除或取消分享。
                    </div>
                @endif
                <div class="item-row item-info-row text-muted">
                    {{--<span> • {{ $item->created_at->format('n月j日 H:i') }}</span>--}}
                    <span>{{ time_show($item->created_at) }}</span>
                    <span> • </span>
                    <span>阅读({{ $item->visit_num }})</span>
                    <span> • </span>
                    {{--点赞--}}
                    <a class="operate-btn" role="button" data-num="{{ $item->favor_num or 0 }}">
                        @if(Auth::check() && $item->pivot_item_relation->contains('type', 11))
                            <span class="remove-this-favor" title="取消赞"><i class="fa fa-thumbs-up text-red"></i>(<num>{{ $item->favor_num }}</num>)</span>
                        @else
                            <span class="add-this-favor" title="点赞"><i class="fa fa-thumbs-o-up"></i>(<num>{{ $item->favor_num }}</num>)</span>
                        @endif
                    </a>
                </div>
            @else
                <article class="colo-md-12"> {!! $item->content or '' !!} </article>
            @endif
        </div>


        @if($item->category == 11)
        <div class="item-row navigation-box">
            <div class="colo-md-12 prev-content"><span class="label">上一篇:</span> <span class="a-box"></span> </div>
            <div class="colo-md-12 next-content"><span class="label">下一篇:</span> <span class="a-box"></span></div>
        </div>
        @endif

    </div>
</div>


<div class="item-piece item-option item" data-item="{{ $item->id }}">
    <div class="item-row item-entity-container">

        {{--comment--}}
        <div class="item-row comment-container">

            <input type="hidden" class="comments-get comments-get-default">

            <div class="item-row comment-input-container">
                <form action="" method="post" class="form-horizontal form-bordered item-comment-form">

                    {{csrf_field()}}
                    <input type="hidden" name="item_id" value="{{ $item->id or 0}}" readonly>
                    <input type="hidden" name="type" value="1" readonly>

                    <div class="item-row ">
                        <div class="comment-textarea-box">
                            <textarea class="comment-textarea" name="content" rows="2" placeholder="请输入你的评论"></textarea>
                        </div>
                        @if($item->category == 7)
                        <div class="mb10">
                            <div class="btn-group">
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="support" value="0" checked="checked"> 只评论
                                        </label>
                                    </div>
                                </button>
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="support" value="1"> 支持正方
                                        </label>
                                    </div>
                                </button>
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="support" value="2"> 支持反方
                                        </label>
                                    </div>
                                </button>
                            </div>
                        </div>
                        @endif
                        <div class="comment-button-box">
                            <a href="javascript:void(0);" class="comment-button comment-submit btn-primary" role="button">发 布</a>
                        </div>
                    </div>

                </form>
            </div>

            @if($item->category == 7)
                <div class="item-row mt10 mb10">
                    <div class="btn-group">
                        <button type="button" class="btn">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="get-support" value="0" checked="checked"> 全部评论
                                </label>
                            </div>
                        </button>
                        <button type="button" class="btn">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="get-support" value="1"> 只看正方
                                </label>
                            </div>
                        </button>
                        <button type="button" class="btn">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="get-support" value="2"> 只看反方
                                </label>
                            </div>
                        </button>
                    </div>
                </div>
            @endif


            {{--评论列表--}}
            <div class="item-row comment-entity-container">

                <div class="item-row comment-list-container">
                </div>

                <div class="item-row more-box">
                    <a href="javascript:void(0);"><span class="item-more">没有更多了</span></a>
                </div>

            </div>

        </div>

    </div>
</div>