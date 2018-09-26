@extends('frontend.'.env('TEMPLATE').'.layout.layout')


{{--html.head--}}
@section('head_title')我的收藏@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection




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
