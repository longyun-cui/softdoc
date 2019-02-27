@extends('frontend.'.env('TEMPLATE').'.layout.layout')


{{--html.head--}}
@section('head_title')关注的内容 - {{ config('website.website_name') }}@endsection
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


{{--custom-content--}}
@section('custom-body')

    <main class="main-body">

        <section class="main-container">
            <section class="module-container">
                <div class="container- row">
                    @include('frontend.'.env('TEMPLATE').'.component.item-list-1', ['items'=>$items])
                </div>
            </section>
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
