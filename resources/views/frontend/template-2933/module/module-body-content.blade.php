{{--<!-- START: module -->--}}
<div class="main-body-block item-container">

    @include('frontend.'.env('TEMPLATE').'.component.items', ['items'=>$items])

</div>
{{--<!-- END: module -->--}}