@extends('frontend.'.env('TEMPLATE').'.layout.layout')


{{--html.head--}}
@section('head_title'){{ $item->title or '内容详情 - '.config('website.website_name') }}@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection




{{--微信分享--}}
@section('wx_share_title'){{ $item->title or '内容详情 - '.config('website.website_name') }}@endsection
@section('wx_share_desc'){{ "@".$item->user->name }}@endsection
@section('wx_share_imgUrl'){{ url(env('DOMAIN_CDN').'/'.$item->user->portrait_img) }}@endsection




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

    <main class="main-body">
        @if($item->category == 11 || $item->category == 18)
            <div class="main-container">
                <div class="row" style="margin:0;">

                    <div class="col-xs-12 col-sm-12 col-md-4 body-side pull-right" style="padding-left:8px;padding-right:8px;">
                        {{--@yield('custom-body-side')--}}
                        @if($item->category == 11)
                            @include('frontend.'.env('TEMPLATE').'.module.body-side.side-menu')
                        @elseif($item->category == 18)
                            @include('frontend.'.env('TEMPLATE').'.module.body-side.side-timeline')
                        @else
                            @include('frontend.'.env('TEMPLATE').'.module.body-side.side-item')
                        @endif
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-8 body-main pull-left" style="padding-left:8px;padding-right:8px;">
                        {{--@yield('custom-body-main')--}}
                        @if($item->category == 18)
                            @include('frontend.'.env('TEMPLATE').'.module.module-body-timeline')
                        @else
                            @include('frontend.'.env('TEMPLATE').'.module.module-body-item')
                        @endif
                    </div>

                </div>
            </div>
        @else
            <section class="main-container-xs">
                <div class="row" style="margin:0;">
                    @include('frontend.'.env('TEMPLATE').'.module.module-body-item')
                </div>
            </section>
        @endif
    </main>

    {{--@if($item->category == 11 || $item->category == 18)--}}
        {{--@include('frontend.'.env('TEMPLATE').'.component.body', ['side'=>4,'main'=>8])--}}
    {{--@else--}}
        {{--@include('frontend.'.env('TEMPLATE').'.component.body')--}}
    {{--@endif--}}

    <main class="main-sidebar-fixed">
        @include('frontend.'.env('TEMPLATE').'.module.sidebar-item')
    </main>

    {{--@include('frontend.'.env('TEMPLATE').'.component.body')--}}
    @include('frontend.'.env('TEMPLATE').'.component.modal-forward')

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
