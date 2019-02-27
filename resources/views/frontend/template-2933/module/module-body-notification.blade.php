{{--<!-- START: module -->--}}
<div class="main-body-block item-container">

    @include('frontend.'.env('TEMPLATE').'.component.notification-list', ['notifications'=>$notifications])

</div>
{{--<!-- END: module -->--}}