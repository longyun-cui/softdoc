@extends('frontend.'.env('TEMPLATE').'.layout.layout')


{{--html.head--}}
@section('head_title'){{ $item->title or '内容详情 - '.config('website.website_name') }}@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--微信分享--}}
@section('wx_share_title'){{ $item->title or '内容详情 - '.config('website.website_name') }}@endsection
@section('wx_share_desc')如未改变生活@endsection
@section('wx_share_imgUrl'){{ url('/softdoc_white_1.png') }}@endsection




{{--header--}}
@section('component-header')
    @include('frontend.'.env('TEMPLATE').'.component.header-item')
@endsection


{{--footer--}}
@section('component-footer')
    @include('frontend.'.env('TEMPLATE').'.component.footer')
@endsection


{{--custom-content-main--}}
@section('custom-body-main')
    @if($item->category == 18)
        @include('frontend.'.env('TEMPLATE').'.module.module-body-timeline')
    @else
        @include('frontend.'.env('TEMPLATE').'.module.module-body-item')
    @endif
@endsection
{{--custom-content-side--}}
@section('custom-body-side')
    @if($item->category == 11)
        @include('frontend.'.env('TEMPLATE').'.module.body-side.side-menu')
    @elseif($item->category == 18)
        @include('frontend.'.env('TEMPLATE').'.module.body-side.side-timeline')
    @else
        @include('frontend.'.env('TEMPLATE').'.module.body-side.side-item')
    @endif
@endsection


{{--custom-content--}}
@section('custom-body')

    @if($item->category == 11 || $item->category == 18)
        @include('frontend.'.env('TEMPLATE').'.component.body', ['side'=>4,'main'=>8])
    @else
        @include('frontend.'.env('TEMPLATE').'.component.body')
    @endif

    {{--@include('frontend.'.env('TEMPLATE').'.module.module-service-for-root', ['page_type'=>'root','services'=>$services])--}}

@endsection




{{--css--}}
@section('custom-css')
    @if($item->category == 18)
        <link rel="stylesheet" type="text/css" href="{{ asset('templates/jiaoben912/css/default.css') }}" />
        <link type="text/css" rel="stylesheet" href="{{ asset('templates/jiaoben912/css/component.css') }}" media="all" />
    @endif
@endsection
{{--style--}}
@section('custom-style')
<style>
</style>
@endsection


{{--js--}}
@section('custom-js')
@endsection
{{--script--}}
@section('custom-script')
<script>
    $(function() {
        @if($item->category == 11)
        fold();
        @endif
        $(".comments-get-default").click();
    });
</script>
@endsection
