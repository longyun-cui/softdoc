<div class="item-row col-md-12 box-body comment-piece comment-option" style="padding:8px 8px;" data-id="{{encode($comment->id)}}">


    {{--评论头部--}}
    <div class="item-row comment-title-container">

        <a href="{{ url('/user/'.$comment->user->id) }}" target="_blank" class="link">{{ $comment->user->name }}</a>
        @if($comment->support == 1)<span class="text-red">【支持正方】</span>
        @elseif($comment->support == 2)<span class="text-blue">【支持反方】</span>
        @endif

        <span class="pull-right text-muted disabled">{{ $comment->created_at->format('n月j日 H:i') }} </span>

        <span class="pull-right text-muted disabled comment-reply-toggle" role="button" data-num="{{ $comment->comment_num or 0 }}">
            {{--回复@if($comment->comment_num)({{ $comment->comment_num or '' }})@endif--}}
            回复({{ $comment->comment_num or 0 }})
        </span>

        <span class="comment-favor-btn" data-num="{{ $comment->favor_num or 0 }}">
            @if(Auth::check())
                @if(count($comment->favors))
                    <span class="pull-right text-muted disabled comment-favor-this-cancel" data-parent=".comment-option" role="button">
                        <i class="fa fa-thumbs-up text-red"></i>({{ $comment->favor_num or 0 }})
                    </span>
                @else
                    <span class="pull-right text-muted disabled comment-favor-this" data-parent=".comment-option" role="button">
                        <i class="fa fa-thumbs-o-up"></i>({{ $comment->favor_num or 0 }})
                    </span>
                @endif
            @else
                <span class="pull-right text-muted disabled comment-favor-this" data-parent=".comment-option" role="button">
                    <i class="fa fa-thumbs-o-up"></i>({{ $comment->favor_num or 0 }})
                </span>
            @endif
        </span>

    </div>


    {{--评论内容--}}
    <div class="item-row comment-content-container margin-bottom-8">
        {{ $comment->content or '' }}
    </div>


    {{--回复评论--}}
    <div class="item-row comment-reply-input-container">

        <div class="input-group margin-10">
            <input type="text" class="form-control comment-reply-content">

            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-flat comment-reply-submit">回复</button>
            </span>
        </div>

    </div>


    {{--回复内容--}}
    <div class="item-row reply-container">

        <div class="item-row reply-list-container">
            {{--@if(count($comment->dialogs))--}}
                {{--@foreach($comment->dialogs as $reply)--}}
                    {{--@component('frontend.component.reply',['reply'=>$reply])--}}
                    {{--@endcomponent--}}
                {{--@endforeach--}}
            {{--@endif--}}
        </div>

        @if($comment->dialogs_count)
            <div class="item-row more-box reply-more-box replies-more" role="button"
                    data-more="{{$comment->dialog_more}}"
                    data-maxId="{{$comment->dialog_max_id}}"
                    data-minId="{{$comment->dialog_min_id}}"
                >
                <a href="javascript:void(0);">
                    {!! $comment->dialog_more_text !!}
                </a>
            </div>
        @endif

    </div>

</div>

