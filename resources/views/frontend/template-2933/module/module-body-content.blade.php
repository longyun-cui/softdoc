{{--<!-- START: module -->--}}
<div class="main-body-block">

    @include('frontend.'.env('TEMPLATE').'.component.items', ['items'=>$items])

</div>
{{--<!-- END: module -->--}}