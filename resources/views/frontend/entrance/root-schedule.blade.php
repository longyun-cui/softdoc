@extends('frontend.'.env('TEMPLATE').'.layout.layout')


{{--html.head--}}
@section('head_title')我的日程 - {{ config('website.website_name') }}@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--微信分享--}}
@section('wx_share_title')我的日程 | {{ config('website.website_name') }}@endsection
@section('wx_share_desc')如未改变生活@endsection
@section('wx_share_imgUrl'){{ url('/softdoc_white_1.png') }}@endsection




{{--header--}}
@section('component-header')
    @include('frontend.'.env('TEMPLATE').'.component.header-root')
@endsection


{{--footer--}}
@section('component-footer')
    @include('frontend.'.env('TEMPLATE').'.component.footer')
@endsection


{{--custom-content-main--}}
{{--@section('custom-body-main')--}}
    {{--@include('frontend.'.env('TEMPLATE').'.module.module-body-schedule')--}}
{{--@endsection--}}
{{--custom-content-side--}}
{{--@section('custom-body-side')--}}
    {{--@include('frontend.'.env('TEMPLATE').'.module.body-side.side-root')--}}
{{--@endsection--}}


{{--custom-content--}}
@section('custom-body')

    <main class="main-body">

        <section class="main-container">

            <div class="main-body-block" style="margin-bottom:32px;">

                <div class="clearfix">
                    <div id='calendar'></div>
                </div>

            </div>
            <div class="main-body-block">

                {{--@include('frontend.'.env('TEMPLATE').'.component.items', ['items'=>$items])--}}

            </div>
            <div class="main-body-block item-container schedule-container" id="schedule-container-clone">
                I am clone.
            </div>

        </section>

    </main>

    <main class="main-sidebar-fixed">
        @include('frontend.'.env('TEMPLATE').'.module.sidebar-root')
    </main>

    {{--@include('frontend.'.env('TEMPLATE').'.component.body')--}}
    @include('frontend.'.env('TEMPLATE').'.component.modal-forward')

@endsection




{{--css--}}
@section('custom-css')
    {{--<link href="https://cdn.bootcss.com/bootstrap-calendar/0.2.5/css/calendar.min.css" rel="stylesheet">--}}
    {{--<link href="https://cdn.bootcss.com/bootstrap-year-calendar/1.1.1/css/bootstrap-year-calend、ar.min.css" rel="stylesheet">--}}
    {{--<link type="text/css" rel="stylesheet" href="{{ asset('templates/jiaoben5399/css/stylesheet.css') }}" media="all" />--}}
    {{--<link type="text/css" rel="stylesheet" href="{{ asset('templates/jiaoben5399/css/print.css') }}" media="all" />--}}
    <link type="text/css" rel="stylesheet" href="{{ asset('templates/jiaoben5399/css/simple-calendar.css') }}" media="all" />
@endsection
{{--style--}}
@section('custom-style')
<style>
</style>
@endsection


{{--js--}}
@section('custom-js')
    {{--<script src="https://cdn.bootcss.com/underscore.js/1.9.0/underscore-min.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/bootstrap-calendar/0.2.5/js/language/zh-CN.min.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/bootstrap-calendar/0.2.5/js/calendar.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/bootstrap-year-calendar/1.1.1/js/bootstrap-year-calendar.min.js"></script>--}}
    <script src="{{ asset('common/js/frontend/time.js') }}"></script>
    <script src="{{ asset('templates/jiaoben5399/js/simple-calendar.js') }}"></script>
@endsection
{{--script--}}
@section('custom-script')
<script>
    $(function() {

        var options = {
            language: 'CH', //语言
            showLunarCalendar: true //阴历
        };

        var myCalendar = new SimpleCalendar('#calendar',options);

    });
</script>
@endsection
