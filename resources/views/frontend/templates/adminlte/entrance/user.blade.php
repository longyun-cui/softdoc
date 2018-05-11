@extends('frontend.templates.adminlte.layout.layout')
@section('html-head-title') {{$data->name}}的主页-课栈 @endsection


@section('wx_share_title') {{$data->name or ''}} @endsection
@section('wx_share_desc') 欢迎来到我的课栈 @endsection
@if(!empty($data->portrait_img))
    @section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.cdn').'/'.$data->portrait_img}}@endsection
@else
    @section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.root').'/favicon.png'}}@endsection
@endif


@section('content')

    <div style="display:none;">
        <input type="hidden" id="" value="{{$_encode or ''}}" readonly>
    </div>

    <div class="container">

        <div class="col-xs-12 col-sm-12 col-md-9 container-main pull-left">
            @include('frontend.component.course')
            {{{ $courses->links() }}}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3 container-side pull-right">
            @include('frontend.templates.adminlte.component.main-side.user')
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

        $('.course-option').on('click', '.show-menu', function () {
            var course_option = $(this).parents('.course-option');
            course_option.find('.menu-container').show();
            $(this).removeClass('show-menu').addClass('hide-menu');
            $(this).html('隐藏目录');
        });
        $('.course-option').on('click', '.hide-menu', function () {
            var course_option = $(this).parents('.course-option');
            course_option.find('.menu-container').hide();
            $(this).removeClass('hide-menu').addClass('show-menu');
            $(this).html('查看目录');
        });
    });
</script>
@endsection
