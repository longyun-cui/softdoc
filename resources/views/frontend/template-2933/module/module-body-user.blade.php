{{--<!-- START: module -->--}}
<div class="main-body-block">

    @include('frontend.'.env('TEMPLATE').'.component.relation-user', ['users'=>$users])

</div>
{{--<!-- END: module -->--}}