@extends('frontend.templates.adminlte.layout.layout')

@section('wx_share_title') 课栈 @endsection
@section('wx_share_desc') 三人行必有我师焉 @endsection
@section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.root').'/favicon.png'}}@endsection

@section('header_title')  @endsection

@section('title','课栈')
@section('header','三人行必有我师焉')
@section('description','课程集')

@section('content')

    <div class="_none">
        <input type="hidden" id="" value="{{$encode or ''}}" readonly>
    </div>

    <div class="container">

        <div class="col-xs-12 col-sm-12 col-md-9 container-main pull-left">
            @include('frontend.templates.adminlte.entity.contents',['datas'=>$contents])
            {{{ $contents->links() }}}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3 hidden-xs hidden-sm container-side pull-right">
            @include('frontend.templates.adminlte.component.main-side.header')
            @include('frontend.templates.adminlte.component.main-side.home')
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

