<div class="item-piece item-option item" data-item="{{ $item->id }}">
    <div class="panel-default box-default item-entity-container">

        <div class="item-row item-title-row">
            <b>{{ $item->title or '' }}</b>
        </div>

        <div class="item-row item-info-row text-muted">
            {{--<span> • {{ $item->created_at->format('n月j日 H:i') }}</span>--}}
            <span>{{ time_show($item->created_at) }}</span>
            <span> • 阅读({{ $item->visit_num }})</span>
            <span> • </span>
            {{--点赞--}}
            <a class="operate-btn" role="button" data-num="{{ $item->favor_num or 0 }}">
                @if(Auth::check() && $item->pivot_item_relation->contains('type', 9))
                    <span class="remove-this-favor" title="取消赞"><i class="fa fa-thumbs-up text-red"></i>(<num>{{ $item->favor_num }}</num>)</span>
                @else
                    <span class="add-this-favor" title="点赞"><i class="fa fa-thumbs-o-up"></i>(<num>{{ $item->favor_num }}</num>)</span>
                @endif
        </div>

        @if($item->category == 7)
            <div class="box-body item-info-row">
                <b class="text-red">【正方】 {{ $item->custom_decode->positive }}</b>
            </div>
            <div class="box-body item-info-row">
                <b class="text-blue">【反方】 {{ $item->custom_decode->negative }}</b>
            </div>
        @endif

    </div>
</div>


<div class="item-piece item-option item" data-item="{{ $item->id }}">
    <div class="item-entity-container">

        {{--description--}}
        {{--@if(!empty($item->description))--}}
        {{--<div class="box-body item-description-row">--}}
        {{--<div class="colo-md-12 text-muted"> {!! $item->description or '' !!} </div>--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--content--}}
        <div class="item-row item-content-row">
            <article class="colo-md-12"> {!! $item->content or '' !!} </article>
        </div>


        @if($item->category == 11)
        <div class="box-footer">
            <div class="colo-md-12 prev-content"> 上一篇 : <span class="a-box"></span> </div>
            <div class="colo-md-12 next-content" style="margin-top:10px;"> 下一篇 : <span class="a-box"></span> </div>
        </div>
        @endif

    </div>
</div>


<div class="item-piece item-option item" data-item="{{ $item->id }}">
    <div class="item-entity-container">

        {{--comment--}}
        <div class="item-row comment-container">

            <input type="hidden" class="comments-get comments-get-default">

            <div class="comment-input-container">
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
            <div class="comment-entity-container">

                <div class="comment-list-container">
                </div>

                <div class="more-box">
                    <a href="javascript:void(0);"><span class="item-more">没有更多了</span></a>
                </div>

            </div>

        </div>

    </div>
</div>