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
@section('custom-body-main')
    @include('frontend.'.env('TEMPLATE').'.module.module-body-content')
@endsection
{{--custom-content-side--}}
@section('custom-body-side')
    @include('frontend.'.env('TEMPLATE').'.module.body-side.side-root')
@endsection


{{--custom-content--}}
@section('custom-body')

    @include('frontend.'.env('TEMPLATE').'.component.body')
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
