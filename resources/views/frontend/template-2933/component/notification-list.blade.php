@foreach($notifications as $num => $item)
<div class="item-piece item-option" data-notification="{{ $item->id }}">
    <!-- BEGIN PORTLET-->
    <div class="panel-default box-default item-portrait-container">
        <a href="{{ url('/user/'.$item->source->id) }}">
            <img src="{{ url(env('DOMAIN_CDN').'/'.$item->source->portrait_img) }}" alt="">
        </a>
    </div>

    <div class="panel-default box-default item-entity-container with-portrait">

        {{--header--}}
        <div class="item-row item-info-row text-muted">
            <span class="item-user-portrait _none"><img src="{{ url(env('DOMAIN_CDN').'/'.$item->source->portrait_img) }}" alt=""></span>
            <span class="item-user-name"><a href="{{ url('/user/'.$item->source->id) }}"><b>{{ $item->source->name or '' }}</b></a></span>

            @if($item->sort == 1)
                <span>评论了你的文章</span>
            @elseif($item->sort == 2)
                <span>回复了你的评论</span>
            @elseif($item->sort == 3)
                <span>回复评论</span>
            @elseif($item->sort == 11)
                <span></span>
            @elseif($item->sort == 12)
                <span></span>
            @else
                <span></span>
            @endif

            <div class="pull-right">
                <a class="" role="button">
                    {{ time_show($item->created_at->timestamp) }}
                    {{--{{ time_show($item->created_at->getTimestamp()) }}--}}
                </a>
            </div>

        </div>


        <div class="item-row item-content-row margin-top-8 margin-bottom-8">
        @if($item->sort == 1)
            {{{ $item->communication->content or '' }}}
        @elseif($item->sort == 2)
            {{--<span>回复</span>--}}
            {{--<a href="{{ url('/user/'.$item->reply->user->id) }}" target="_blank" class="user-link">--}}
                {{--{{ $item->reply->user->name }}--}}
            {{--</a>--}}
            {{--<span>:</span>--}}
            {{--<span>{{ $item->communication->content or '' }}</span>--}}
        @elseif($item->sort == 11)
            <span>给你点赞 <i class="fa fa-thumbs-o-up text-red"></i></span>
        @elseif($item->sort == 12)
            <span>赞了你的评论 <i class="fa fa-thumbs-o-up text-red"></i></span>
        @elseif($item->sort == 13)
            <span>赞了评论 <i class="fa fa-thumbs-o-up text-red"></i></span>
        @else
            <span></span>
        @endif
        </div>


        @if(!empty($item->item))
            <a href="{{ url('/item/'.$item->item->id) }}" target="_blank">
                <div class="item-row forward-item-container" role="button">
                    <div class="portrait-box"><img src="{{ url(env('DOMAIN_CDN').'/'.$item->item->user->portrait_img) }}" alt=""></div>
                    <div class="text-box">
                        @if($item->item->category == 99)
                            <div class="text-row forward-item-title">
                                {{ $item->item->content or '' }}
                            </div>
                            <div class="text-row forward-user-name">
                                转发{{ '@'.$item->item->forward_item->user->name }} : {{ $item->item->forward_item->title or '' }}
                            </div>
                        @else
                            <div class="text-row forward-item-title">
                                {{ $item->item->title or '' }}
                            </div>
                            <div class="text-row forward-user-name">{{ '@'.$item->item->user->name }}</div>
                        @endif
                    </div>
                </div>
                @if(in_array($item->sort, [2,3,12,13]))
                <div class="item-row item-comment-container" role="button" style="margin-top:-8px;">
                    <div class="">
                        <span class="user-link"><b>{{ $item->reply->user->name or '' }}</b></span>
                        @if(!empty($item->reply->reply->id))
                        <span class="font-12px">回复</span>
                        <span class="user-link"><b>{{ $item->reply->reply->user->name or '' }}</b></span>
                        @endif
                        <span>:</span>
                        <span class="">{{ $item->reply->content or '' }}</span>
                    </div>
                </div>
                @endif
                @if(in_array($item->sort, [2,3]))
                <div class="item-row item-comment-container margin-top-4" role="button">
                    <div class="">
                        <span class="user-link"><b>{{ $item->source->name or '' }}</b></span>
                        <span class="font-12px">回复</span>
                        <span class="user-link">{{ $item->reply->user->name }}</span>
                        <span>:</span>
                        <span class="">{{{ $item->communication->content or '' }}}</span>
                    </div>
                </div>
                @endif
            </a>
        @else
            <div class="forward-item-container" role="button" style="line-height:40px;text-align:center;">
                内容被作者删除或取消分享。
            </div>
        @endif

        {{--tools--}}
        <div class="item-row item-tools-row">

            <div class="pull-right">


            </div>

        </div>


        {{--comment--}}
        <div class="item-row comment-container _none">

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
                            <div class="item-row ">
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

        </div>

    </div>
    <!-- END PORTLET-->
</div>
@endforeach
@if($notification_type == "paginate")
    {{{ $notifications->links() }}}
@endif