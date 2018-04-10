@extends('frontend.course.layout')

@section('wx_share_title') {{$item->title or ''}} @endsection
@section('wx_share_desc') {{$item->description or '@'.$course->title}} @endsection

@if(!empty($item->user->portrait_img))
    @section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.cdn').'/'.$item->user->portrait_img}}@endsection
@else
    @section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.root').'/favicon.png'}}@endsection
@endif


@section('title') {{$course->title}} @endsection
@section('header','')
@section('description','')

@section('header_title') {{$course->title}} @endsection


@section('content')
<div class="_none">
    <input type="hidden" id="" value="{{$_encode or ''}}" readonly>
</div>


<div class="container">

    <div class="col-sm-12 col-md-4 hidden-xs hidden-sm container-body-left container-body-sidebar course-menu-md-container sidebar">

        <div class="box-body" style="background:#fff;">
            <div class="col-md-12">
                <span class="recursion-icon" style="color:orange;">
                    <i class="fa fa-bookmark"></i>
                </span>
                <span class="recursion-text recursion-course @if(empty($content)) active @endif">
                    <a href="{{url('/course/'.encode($course->id))}}">
                        {{ $course->title or '' }}
                    </a>
                </span>
            </div>
            <div class="col-md-12">
                <span class="recursion-icon" style="color:orange;">
                    <i class="fa fa-user"></i>
                </span>
                <span class="recursion-text recursion-user">
                    <a href="{{url('/u/'.$course->user->encode_id)}}"><b class="text-blue">{{ $course->user->name }}</b></a>
                </span>
            </div>
            <div class="col-md-12">
                <span class="recursion-icon" style="color:orange;">
                    <i class="fa fa-tv"></i>
                </span>
                <span class="recursion-text">
                    <a href="javascript:void(0)">浏览 <span class="text-blue">{{ $course->visit_num or 0 }}</span> 次</a>
                </span>
            </div>
            <div class="col-md-12">
                <span class="recursion-icon" style="color:orange;">
                    <i class="fa fa-commenting-o"></i>
                </span>
                <span class="recursion-text">
                    <a href="javascript:void(0)">评论 <span class="text-blue">{{ $course->comments_total or 0 }}</span> 个</a>
                </span>
            </div>
        </div>

        <div class="box-body sidebar" style="margin-top:12px;background:#fff;">
            <div class="" style="color:#666;">
                <div class="col-md-6 fold-button fold-down">
                    <span class="">
                        <i class="fa fa-plus-square"></i> &nbsp; 全部展开
                    </span>
                </div>
                <div class="col-md-6 fold-button fold-up">
                    <span class="">
                        <i class="fa fa-minus-square"></i> &nbsp; 全部折叠
                    </span>
                </div>
            </div>
        </div>

        <div class="box-body" style="margin-top:2px;color:#666;background:#fff;">
        @foreach( $course->contents_recursion as $key => $recursion )
            <div class="col-md-12 recursion-row" data-level="{{$recursion->level or 0}}" data-id="{{$recursion->id or 0}}"
                 style="display:@if($recursion->level != 0) none @endif">
                <div class="recursion-menu" style="margin-left:{{ $recursion->level*24 }}px">
                    <span class="recursion-icon">
                        @if($recursion->type == 1)
                            @if($recursion->has_child == 1)
                                <i class="fa fa-plus-square recursion-fold"></i>
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
        </div>

    </div>

    <div class="col-sm-12 col-md-8 container-body-right">

        @include('frontend.course.component.item')

    </div>

</div>

@endsection


@section('js')
    <script>
        $(function() {

            fold();
            $(".comments-get-default").click();

        });
    </script>
@endsection
