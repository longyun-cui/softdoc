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
    <title>@yield('title')</title>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="robots" content="all" />
    <meta name="title" content="@yield('meta_title')" />
    <meta name="author" content="@yield('meta_author')" />
    <meta name="description" content="@yield('meta_description')" />
    <meta name="keywords" content="@yield('meta_keywords')" />
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

    <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.3/css/fileinput.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}">

    <link href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">

    <script src="https://cdn.bootcss.com/moment.js/2.19.0/moment.min.js"></script>

    <link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <link href="https://cdn.bootcss.com/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/index.css')}}">
    <style>
        .main-header .header-title {
            float: left;
            background-color: transparent;
            background-image: none;
            padding: 15px 15px;
            font-family: fontAwesome;
            color:#fff;
        }
    </style>

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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{url('/')}}" class="logo" style="display:none;background-color:#222d32;">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>师</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>三人行</b></span>
        </a>

        {{--<!-- Header Navbar -->--}}
        <nav class="navbar navbar-static-top" role="navigation" style="margin-left:0;background-color:#1a2226;">
            {{--<!-- Sidebar toggle button-->--}}
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="display:none;">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu" style="height:50px;color:#f39c12 !important;float:left;">
                <span class="logo-big"><a href="{{url('/')}}"><img src="/favicon_transparent.png" class="img-icon" alt="Image"> <b>课栈</b></a></span>
            </div>



            <span class="header-title"> @yield('header_title') </span>

            {{--<!-- Navbar Right Menu -->--}}
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    @if(Auth::check())
                        <li><a href="{{url('/home')}}"><i class="fa fa-home text-default"></i> <span>{{Auth::user()->name}}</span></a></li>
                    @else
                        {{--<li><a href="{{url('/login')}}"><i class="fa fa-circle-o"></i> <span>登录</span></a></li>--}}
                        {{--<li><a href="{{url('/register')}}"><i class="fa fa-circle-o"></i> <span>注册</span></a></li>--}}
                    @endif

                    <li class="dropdown notifications-menu" style="display:none;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-home"></i>
                            {{--<span class="label label-warning">10</span>--}}
                        </a>
                        <ul class="dropdown-menu">
                            {{--<li class="header">You have 10 notifications</li>--}}
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    @if(Auth::check())
                                        <li><a href="{{url('/home')}}"><i class="fa fa-home text-default"></i> <span>{{Auth::user()->name}}</span></a></li>
                                    @else
                                        <li><a href="{{url('/login')}}"><i class="fa fa-circle-o"></i> <span>登录</span></a></li>
                                        <li><a href="{{url('/register')}}"><i class="fa fa-circle-o"></i> <span>注册</span></a></li>
                                    @endif
                                </ul>
                            </li>
                            {{--<li class="footer"><a href="#">View all</a></li>--}}
                        </ul>
                    </li>

                    {{--<!-- Control Sidebar Toggle Button -->--}}
                    <li style="display:none;">
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>



    {{--<!-- Left side column. contains the logo and sidebar -->--}}
    <aside class="main-sidebar" style="display:none;">

        {{--<!-- sidebar: style can be found in sidebar.less -->--}}
        <section class="sidebar">



            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">

                <li class="header">目录</li>

                <li class="treeview">
                    <a href="{{url('/')}}"><i class="fa fa-list text-orange"></i> <span>平台主页</span></a>
                </li>

                <li class="header">Home</li>

                @if(!Auth::check())

                    <li class="treeview">
                        <a href="{{url('/login')}}"><i class="fa fa-circle-o"></i> <span>登录</span></a>
                    </li>
                    <li class="treeview">
                        <a href="{{url('/register')}}"><i class="fa fa-circle-o"></i> <span>注册</span></a>
                    </li>
                @else
                    <li class="treeview">
                        <a href="{{url('/home')}}"><i class="fa fa-home text-default"></i> <span>返回我的后台</span></a>
                    </li>
                @endif



            </ul>
            <!-- /.sidebar-menu -->
        </section>
        {{--<!-- /.sidebar -->--}}
    </aside>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left:0;background:url('/bg.gif') repeat;">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="display:none;">
            <h1>
                @yield('header')
                <small>@yield('description')</small>
            </h1>
            <ol class="breadcrumb">
                @yield('breadcrumb')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content" style="">
            @yield('content') {{--Your Page Content Here--}}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    {{--<!-- Main Footer -->--}}
    <footer class="main-footer" style="margin-left:0;">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 上海如哉网络科技有限公司 2017-2018 Company.</strong> All rights reserved.
        <a href="http://www.miitbeian.gov.cn">沪ICP备17052782号-2</a>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="pull-right-container">
                                    <span class="label label-danger pull-right">70%</span>
                                </span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
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

<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.3/js/fileinput.min.js"></script>

<script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.min.js"></script>

<script src="{{asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>

<script src="https://cdn.bootcss.com/Readmore.js/2.2.0/readmore.min.js"></script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>


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
{{--//                                if(!data.success) layer.msg(data.msg);--}}
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

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
