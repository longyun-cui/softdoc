@extends('frontend.'.env('TEMPLATE').'.layout.layout')


{{--html.head--}}
@section('head_title'){{ $data->name or '如未' }} - {{ config('website.website_name') }}@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection




{{--微信分享--}}
@section('wx_share_title'){{ $data->name or '如未' }}@endsection
@section('wx_share_desc')欢迎来到我的主页@endsection
@section('wx_share_imgUrl'){{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}@endsection




{{--header--}}
@section('component-header')
    @include('frontend.'.env('TEMPLATE').'.component.header-user')
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
    {{--@include('frontend.'.env('TEMPLATE').'.module.body-side.side-user')--}}
{{--@endsection--}}


{{--custom-content--}}
@section('custom-body')

    <main class="main-body">

        <section class="main-container">
            @include('frontend.'.env('TEMPLATE').'.module.root-item-list', ['items'=>$items])
        </section>

    </main>

    <main class="main-sidebar-fixed">
        @include('frontend.'.env('TEMPLATE').'.module.sidebar-user')
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
