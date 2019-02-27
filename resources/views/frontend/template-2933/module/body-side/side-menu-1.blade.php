<div class="main-side-block main-side-block-padding side-menu main-side-container pull-left padding-8px">

    <a href="javascript:void(0);" class="visible-xs visible-sm header-hide-side side-hidden" role="button"><i class="fa fa-remove"></i></a>

    <div class="col-md-12">
        <span class="recursion-icon">
            <i class="fa fa-bookmark text-orange"></i>
        </span>
        <span class="recursion-text recursion-item @if($parent_item->id == $item->id) active @endif">
            <a href="{{url('/item/'.$parent_item->id)}}">{{ $parent_item->title or '' }}</a>
        </span>
    </div>

    <div class="col-md-12">
        <span class="recursion-icon">
            <i class="fa fa-user text-orange"></i>
        </span>
        <span class="recursion-text recursion-user">
            <a href="{{url('/user/'.$parent_item->user->id)}}"><b class="text-blue">{{ $parent_item->user->name }}</b></a>
        </span>
    </div>

    <div class="col-md-12" >
        <span class="recursion-icon">
            <i class="fa fa-search text-orange"></i>
        </span>
        <span class="recursion-text">
            <a href="javascript:void(0)" style="font-size:12px;">总浏览 <b class="text-blue" style="font-size:12px;">{{ $parent_item->visit_total or 0 }}</b> 次</a>
        </span>
    </div>

    <div class="col-md-12">
        <span class="recursion-icon" >
            <i class="fa fa-comment text-orange"></i>
        </span>
        <span class="recursion-text">
            <a href="javascript:void(0)" style="font-size:12px;">总评论 <b class="text-blue" style="font-size:12px;">{{ $parent_item->comments_total or 0 }}</b> 个</a>
        </span>
    </div>

    <div class="col-md-12 main-side-menu-header" role="button">
        <div class="col-xs-6 col-sm-6 col-md-6 fold-button fold-down">
            <i class="fa fa-plus-square"></i> 全部展开
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 fold-button fold-up" role="button">
            <i class="fa fa-minus-square"></i> 全部折叠
        </div>
    </div>

    @foreach( $contents_recursion as $key => $recursion )
        <div class="col-md-12 recursion-row" data-level="{{$recursion->level or 0}}" data-id="{{$recursion->id or 0}}"
             style="display:@if($recursion->level != 0) none @endif">
             {{--style="">--}}
            <div class="recursion-menu" style="margin-left:{{ $recursion->level*16 }}px">
                <span class="recursion-icon">
                    {{--@if($recursion->type == 1)--}}
                        @if($recursion->has_child == 1)
                            <i class="fa fa-plus-square recursion-fold"></i>
                        @else
                            <i class="fa fa-file-text"></i>
                        @endif
                    {{--@else--}}
                        {{--<i class="fa fa-file-text"></i>--}}
                    {{--@endif--}}
                </span>
                <span class="recursion-text @if($recursion->id == $item->id) active @endif">
                    <a class="row-ellipsis" href="{{ url('/item/'.$recursion->id) }}">
                        {{ $recursion->title or '' }}
                    </a>
                </span>
            </div>
        </div>
    @endforeach

</div>