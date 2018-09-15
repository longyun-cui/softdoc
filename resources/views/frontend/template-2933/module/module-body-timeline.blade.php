{{--<!-- START: module -->--}}
<div class="main-body-block">

    @include('frontend.'.env('TEMPLATE').'.component.item', ['item'=>$item])
    {{--@include('frontend.'.env('TEMPLATE').'.component.timeline')--}}

</div>
{{--<!-- END: module -->--}}