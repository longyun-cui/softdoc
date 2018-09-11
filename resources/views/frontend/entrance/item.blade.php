@extends('frontend.'.env('TEMPLATE').'.layout.layout')


{{--html.head--}}
@section('head_title'){{ $item->title or '内容详情' }}@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection




{{--header--}}
@section('component-header')
    @include('frontend.'.env('TEMPLATE').'.component.header')
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
    @else
        @include('frontend.'.env('TEMPLATE').'.module.body-side.side-item')
    @endif
@endsection


{{--custom-content--}}
@section('custom-body')

    @if($item->category == 11)
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
    });
</script>
@endsection
