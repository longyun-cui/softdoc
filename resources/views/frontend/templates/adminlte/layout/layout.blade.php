<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/ico" href="{{ url('favicon.ico') }}">
    <link rel="shortcut icon" type="image/png" href="{{ url('favicon.png') }}">
    <link rel="icon" sizes="16x16 32x32 64x64" href="{{ url('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="196x196" href="{{ url('favicon.png') }}">

    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>@yield('html-head-title')</title>
    <meta name="title" content="@yield('meta_title')" />
    <meta name="author" content="@yield('meta_author')" />
    <meta name="description" content="@yield('meta_description')" />
    <meta name="keywords" content="@yield('meta_keywords')" />
    <meta name="robots" content="all" />

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/AdminLTE/bootstrap/css/bootstrap.min.css">
    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <!-- Font Awesome -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">--}}
    <link href="https://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">--}}
    <link href="https://cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="/AdminLTE/dist/css/AdminLTE.min.css">
    {{--<link href="https://cdn.bootcss.com/admin-lte/2.3.11/css/AdminLTE.min.css" rel="stylesheet">--}}
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="/AdminLTE/dist/css/skins/skin-blue.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    {{--<!--[if lt IE 9]>--}}
    {{--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>--}}
    {{--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}
    {{--<![endif]-->--}}
    {{--<link href="https://cdn.bootcss.com/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css" rel="stylesheet">--}}

    {{--<link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.3/css/fileinput.min.css" rel="stylesheet">--}}

{{--    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}">--}}

    {{--<link href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">--}}

    {{--<script src="https://cdn.bootcss.com/moment.js/2.19.0/moment.min.js"></script>--}}

    {{--<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">--}}

    {{--<link href="https://cdn.bootcss.com/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">--}}




    <link type="text/css" rel="stylesheet" href="{{ asset('templates/themes/floating-button/ionicons.min.css') }}" />

    <script src="{{ asset('templates/themes/floating-button/modernizr.touch.js') }}"></script>

    {{--<link type="text/css" rel="stylesheet" href="{{ asset('templates/themes/floating-button/index.css') }}" />--}}
    <link type="text/css" rel="stylesheet" href="{{ asset('templates/themes/floating-button/mfb.css') }}" />




    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/index.css')}}">

    @yield('css')
    @yield('style')

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-black sidebar-mini">
<div class="wrapper">

    {{--header--}}
    @include('frontend.templates/adminlte/component/header')


    {{--floating-button--}}
    {{--@include('frontend.templates/adminlte/component/floating-button')--}}


    {{--sidebar--}}
    @include('frontend.templates/adminlte/component/sidebar')


    {{--main-container--}}
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header _none">
            <h1>
                Title
                <small>description</small>
            </h1>
            <ol class="breadcrumb"> breadcrumb </ol>
        </section>

        {{--Your Page Content Here--}}
        <section class="content">
            @yield('content')
        </section>

    </div>


    {{--footer--}}
    @include('frontend.templates/adminlte/component/footer')


    {{--control-sidebar--}}
    @include('frontend.templates/adminlte/component/control-sidebar')






</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

{{--<!-- jQuery 2.2.3 -->--}}
<script src="/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
{{--<!-- Bootstrap 3.3.6 -->--}}
<script src="/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
{{--<!-- AdminLTE App -->--}}
<script src="/AdminLTE/dist/js/app.min.js"></script>

<script src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>

{{--<script src="https://cdn.bootcss.com/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script>--}}

<script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>

<script src="https://cdn.bootcss.com/Readmore.js/2.2.0/readmore.min.js"></script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
 <script>

    console.log("@yield('wx_share_imgUrl')");
    var wechat_config = {!! $wechat_config or '' !!};
    //    console.log(wechat_config);

    $(function(){

//        var link = window.location.href;
        var link = location.href.split('#')[0];
//        console.log(link);

        if(typeof wx != "undefined") wxFn();

        function wxFn() {

            wx.config({
                debug: false,
                appId: wechat_config.app_id, // 必填，公众号的唯一标识
                timestamp: wechat_config.timestamp, // 必填，生成签名的时间戳
                nonceStr: wechat_config.nonce_str, // 必填，生成签名的随机串
                signature: wechat_config.signature, // 必填，签名，见附录1
                jsApiList: [
                    'checkJsApi',
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareQQ',
                    'onMenuShareQZone',
                    'onMenuShareWeibo'
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            }) ;

            wx.ready(function(){
                wx.onMenuShareAppMessage({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    dataUrl: '',
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        {{--$.get(--}}
                            {{--"/share",--}}
                            {{--{--}}
                                {{--'_token': $('meta[name="_token"]').attr('content'),--}}
                                {{--'website': "{{$org->website_name or '0'}}",--}}
                                {{--'sort': 1,--}}
                                {{--'module': 0,--}}
                                {{--'share': 1--}}
                            {{--},--}}
                            {{--function(data) {--}}
                                {{--if(!data.success) layer.msg(data.msg);--}}
                            {{--}, --}}
                        {{--'json');--}}
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareTimeline({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        {{--$.get(--}}
                            {{--"/share",--}}
                            {{--{--}}
                                {{--'_token': $('meta[name="_token"]').attr('content'),--}}
                                {{--'website': "{{$org->website_name or '0'}}",--}}
                                {{--'sort': 1,--}}
                                {{--'module': 0,--}}
                                {{--'share': 2--}}
                            {{--},--}}
                            {{--function(data) {--}}
                                {{--if(!data.success) layer.msg(data.msg);--}}
                            {{--}, --}}
                        {{--'json');--}}
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareQQ({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        {{--$.get(--}}
                            {{--"/share",--}}
                            {{--{--}}
                                {{--'_token': $('meta[name="_token"]').attr('content'),--}}
                                {{--'website': "{{$org->website_name or '0'}}",--}}
                                {{--'sort': 1,--}}
                                {{--'module': 0,--}}
                                {{--'share': 3--}}
                            {{--},--}}
                            {{--function(data) {--}}
                                {{--if(!data.success) layer.msg(data.msg);--}}
                            {{--}, --}}
                        {{--'json');--}}
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareQZone({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        {{--$.get(--}}
                            {{--"/share",--}}
                            {{--{--}}
                                {{--'_token': $('meta[name="_token"]').attr('content'),--}}
                                {{--'website': "{{$org->website_name or '0'}}",--}}
                                {{--'sort': 1,--}}
                                {{--'module': 0,--}}
                                {{--'share': 4--}}
                            {{--},--}}
                            {{--function(data) {--}}
                                {{--if(!data.success) layer.msg(data.msg);--}}
                            {{--}, --}}
                        {{--'json');--}}
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareWeibo({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        {{--$.get(--}}
                            {{--"/share",--}}
                            {{--{--}}
                                {{--'_token': $('meta[name="_token"]').attr('content'),--}}
                                {{--'website': "{{$org->website_name or '0'}}",--}}
                                {{--'sort': 1,--}}
                                {{--'module': 0,--}}
                                {{--'share': 5--}}
                            {{--},--}}
                            {{--function(data) {--}}
                                {{--if(!data.success) layer.msg(data.msg);--}}
                            {{--}, --}}
                        {{--'json');--}}
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
            })   ;
        }
    });
</script>


<script src="{{asset('js/frontend/index.js')}}"></script>

@yield('js')
@yield('script')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
