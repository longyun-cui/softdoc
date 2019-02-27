<!DOCTYPE html>
<html lang="zh_cn">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('head_title')</title>
        <meta name="author" content="@yield('meta_author')" />
        <meta name="description" content="@yield('meta_description')" />
        <meta name="keywords" content="@yield('meta_keywords')" />

        <meta name="_token" content="{{ csrf_token() }}"/>

        {{--<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">--}}

        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
        {{--<link rel="stylesheet" href="{{ asset('/templates/moban2933/css/styles-merged.css') }}">--}}
        <link rel="stylesheet" href="{{ asset('/templates/moban2933/css/style.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/templates/moban2933/css/custom.css') }}">

        <link href="{{ asset('/templates/moban2933/plugins/slick/slick.css') }}" rel="stylesheet">
        <link href="{{ asset('/templates/moban2933/plugins/slick-nav/slicknav.css') }}" rel="stylesheet">

        <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">--}}
        <link href="https://cdn.bootcss.com/layer/3.0.3/skin/moon/style.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/lightcase/2.5.0/css/lightcase.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/fancybox/3.3.5/jquery.fancybox.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/Swiper/4.2.2/css/swiper.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/timelinejs/2.36.0/css/timeline.css" rel="stylesheet">


        <link type="text/css" rel="stylesheet" href="{{ asset('common/css/common.css') }}" media="all" />
        <link type="text/css" rel="stylesheet" href="{{ asset('common/css/frontend.css') }}" media="all" />

        <link type="text/css" rel="stylesheet" href="{{ asset('common/css/frontend/index.css') }}" media="all" />
        <link type="text/css" rel="stylesheet" href="{{ asset('common/css/frontend/item.css') }}" media="all" />
        <link type="text/css" rel="stylesheet" href="{{ asset('common/css/frontend/menu.css') }}" media="all" />
        <link type="text/css" rel="stylesheet" href="{{ asset('common/css/backend/index.css') }}" media="all" />
        <link type="text/css" rel="stylesheet" href="{{ asset('common/css/animate/wicked.css') }}" media="all" />
        <link type="text/css" rel="stylesheet" href="{{ asset('common/css/animate/hover.css') }}" media="all" />

        {{--<link type="text/css" rel="stylesheet" href="{{ asset('css/frontend/index.css') }}" media="all" />--}}

        <!--[if lt IE 9]>
        <script src="{{ asset('/templates/moban2933/js/vendor/html5shiv.min.js') }}"></script>
        <script src="{{ asset('/templates/moban2933/js/vendor/respond.min.js') }}"></script>
        <![endif]-->


        @yield('custom-css')
        @yield('custom-style')


    </head>

    <body>

        {{--header--}}
        @yield('component-header')

        {{--body--}}
        @yield('custom-body')

        {{--footer--}}
        @yield('component-footer')


        {{--<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>--}}
        <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
        {{--<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>--}}
        {{--<script src="{{ asset('/templates/moban2933/js/scripts.min.js') }}"></script>--}}
        <script src="{{ asset('/templates/moban2933/js/main.min-.js') }}"></script>
        <script src="{{ asset('/templates/moban2933/js/custom.js') }}"></script>

        {{--<script src="{{ asset('/templates/moban2933/plugins/slick-nav/jquery.slicknav.min.js') }}"></script>--}}
        {{--<script src="{{ asset('/templates/moban2933/plugins/slick/slick.min.js') }}"></script>--}}

        <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.min.js"></script>
        <script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>
        <script src="https://cdn.bootcss.com/lightcase/2.5.0/js/lightcase.min.js"></script>
        <script src="https://cdn.bootcss.com/fancybox/3.3.5/jquery.fancybox.js"></script>
        <script src="https://cdn.bootcss.com/Swiper/4.2.2/js/swiper.min.js"></script>
        <script src="https://cdn.bootcss.com/timelinejs/2.36.0/js/timeline-min.js"></script>
        <script src="https://cdn.bootcss.com/jquery.sticky/1.0.4/jquery.sticky.min.js"></script>


        <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
         <script>

            var wechat_config = {!! $wechat_config or '' !!};

            $(function(){

                var link = location.href.split('#')[0];

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


        @yield('custom-js')
        @yield('custom-script')


    </body>

</html>