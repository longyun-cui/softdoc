{{--<!-- START: module -->--}}
<div class="main-body-block item-container">

    @include('frontend.'.env('TEMPLATE').'.component.notifications', ['notifications'=>$notifications])

</div>
{{--<!-- END: module -->--}}