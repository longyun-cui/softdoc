@extends('frontend.'.env('TEMPLATE').'.layout.layout')


{{--html.head--}}
@section('head_title'){{ config('website.website_name') }}@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--微信分享--}}
@section('wx_share_title'){{ config('website.website_name') }}@endsection
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
    {{--@include('frontend.'.env('TEMPLATE').'.module.module-body-content')--}}
{{--@endsection--}}
{{--custom-content-side--}}
{{--@section('custom-body-side')--}}
    {{--@include('frontend.'.env('TEMPLATE').'.module.body-side.side-root')--}}
{{--@endsection--}}


{{--custom-content--}}
@section('custom-body')

    <main class="main-body">

        <section class="main-container">
            <section class="module-container">
                <div class="container- row">

                    <header class="module-row module-header-container text-center _none">
                        <div class="wow slideInLeft module-title-row title-with-double-line color-1 border-light title-h2"><b>原创内容</b></div>
                        {{--<div class="wow slideInRight module-subtitle-row color-5 title-h4"><b>description-1</b></div>--}}
                    </header>

                    <div class="module-row module-body-container bg-light-">
                        @include('frontend.'.env('TEMPLATE').'.component.item-list', ['items'=>$items])
                    </div>

                    <footer class="module-row module-footer-container text-center">
                        {{{ $items->links() }}}
                        {{--<a href="{{ url('/item/list') }}" class="view-more style-dark">查看更多 <i class="fa fa-hand-o-right"></i></a>--}}
                    </footer>

                </div>
            </section>
            {{--@include('frontend.'.env('TEMPLATE').'.module.root-item-list', ['items'=>$items])--}}
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
        });
    </script>
@endsection
