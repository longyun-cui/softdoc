@extends('frontend.'.env('TEMPLATE').'.layout.layout')


{{--html.head--}}
@section('head_title')404 - 如未科技@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection




{{--header--}}
@section('component-header')
    @include('frontend.'.env('TEMPLATE').'.component.header')
@endsection


{{--custom-content-main--}}
@section('custom-body-main')
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> 哦，很抱歉，页面不存在！</h3>
            <p>
                我们找不到你想要的页面。
                但是, 你可以 <a href="/">返回首页</a>。
            </p>
        </div>
    </div>
@endsection


{{--custom-content--}}
@section('custom-body')

    @include('frontend.'.env('TEMPLATE').'.component.body')

    {{--@include('frontend.'.env('TEMPLATE').'.module.module-service-for-root', ['page_type'=>'root','services'=>$services])--}}

@endsection


@section('js')
<script>
    $(function() {
    });
</script>
@endsection