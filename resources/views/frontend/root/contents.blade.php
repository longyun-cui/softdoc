@extends('frontend.layout.layout')

@section('wx_share_title') 课栈 @endsection
@section('wx_share_desc') 三人行必有我师焉 @endsection
@section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.root').'/favicon.png'}}@endsection

@section('header_title')  @endsection

@section('title','课栈')
@section('header','三人行必有我师焉')
@section('description','课程集')

@section('content')

    <div style="display:none;">
        <input type="hidden" id="" value="{{$encode or ''}}" readonly>
    </div>

    <div class="container">

        <div class="col-xs-12 col-sm-12 col-md-3 container-body-right container-body-sidebar pull-right">

            <div class="box-body right-menu" style="background:#fff;">

                @if(!Auth::check())

                    <a href="{{url('/login')}}">
                        <div class="box-body hover-box">
                            <i class="fa fa-circle-o text-default"></i> <span>&nbsp; 登录</span>
                        </div>
                    </a>

                    <a href="{{url('/register')}}">
                        <div class="box-body hover-box">
                            <i class="fa fa-circle-o text-default"></i> <span>&nbsp; 注册</span>
                        </div>
                    </a>
                @else
                    <a href="{{url('/home')}}">
                        <div class="box-body hover-box">
                            <i class="fa fa-home text-orange"></i> <span>&nbsp; 返回我的后台</span>
                        </div>
                    </a>
                @endif

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-9 container-body-left pull-left">

            {{--@foreach($courses as $num => $course)--}}
            {{--@include('frontend.component.course')--}}
            {{--@endforeach--}}
            @include('frontend.component.contents',['datas'=>$contents])

            {{{ $contents->links() }}}

        </div>

    </div>

@endsection


@section('style')
<style>
</style>
@endsection
@section('js')
<script>
    $(function() {
//        $('article').readmore({
//            speed: 150,
//            moreLink: '<a href="#">展开更多</a>',
//            lessLink: '<a href="#">收起</a>'
//        });
    });
</script>
@endsection

