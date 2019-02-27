{{--<!-- START: body -->--}}
<section class="section-body">
    <div class="container">
        <div class="row-">

            <div class="col-xs-12 col-sm-12 col-md-{{$side or 3}} body-side pull-right">
                @yield('custom-body-side')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-{{$main or 9}} body-main pull-left">
                @yield('custom-body-main')
            </div>

        </div>
    </div>
</section>
{{--<!-- END: body -->--}}