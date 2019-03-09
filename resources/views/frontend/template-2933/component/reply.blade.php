<div class="item-row col-md-12 box-body reply-piece reply-option" data-id="{{ encode($reply->id) }}">

    {{--回复头部--}}
    <div class="item-row reply-title-container">

        <a href="{{ url('/user/'.$reply->user->id) }}" class="link font-xs">{{ $reply->user->name or '' }}</a>

        @if($reply->reply_id != $reply->dialog_id)
            @if($reply->reply)
                <span class="font-12px">回复</span>
                <a href="{{ url('/user/'.$reply->reply->user->id) }}" class="link font-xs">{{ $reply->reply->user->name or '' }}</a> :
            @endif
        @endif

        {{ $reply->content }} <br>

    </div>


    {{--回复工具--}}
    <div class="item-row reply-tools-container item-info-row">

        <span class="pull-left text-muted disabled font-xs">{{ $reply->created_at->format('n月j日 H:i') }}</span>

        <span class="pull-right text-muted disabled font-xs reply-toggle" role="button" data-num="{{ $reply->comment_num or 0 }}">
            回复({{ $reply->comment_num or 0 }})
        </span>

        <span class="comment-favor-btn" data-num="{{ $reply->favor_num or 0 }}">
            @if(Auth::check())
                @if(count($reply->favors))
                    <span class="pull-right text-muted disabled font-xs comment-favor-this-cancel" data-parent=".reply-option" role="button">
                        <i class="fa fa-thumbs-up text-red"></i>({{ $reply->favor_num or 0 }})
                    </span>
                @else
                    <span class="pull-right text-muted disabled font-xs comment-favor-this" data-parent=".reply-option" role="button">
                        <i class="fa fa-thumbs-o-up"></i>({{ $reply->favor_num or 0 }})
                    </span>
                @endif
            @else
                <span class="pull-right text-muted disabled font-xs comment-favor-this" data-parent=".reply-option" role="button">
                    <i class="fa fa-thumbs-o-up"></i>({{ $reply->favor_num or 0 }})
                </span>
            @endif
        </span>

    </div>


    {{--回复输入框--}}
    <div class="item-row reply-input-container">

        <div class="input-group margin-10">
            <input type="text" class="form-control reply-content">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-flat reply-submit">回复</button>
            </span>
        </div>

    </div>

</div>

