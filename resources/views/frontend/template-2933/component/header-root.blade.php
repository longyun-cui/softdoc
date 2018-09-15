{{--<!-- START: header -->--}}
<header role="banner" class="section-header">
    <div class="full-screen">

        <a href="{{ url('/') }}" class="header-logo">
            <img src="{{ url('/favicon_white_0.png') }}" alt="如未">
        </a>
        <a href="{{ url('/') }}"> 如未科技 </a>

        <a href="javascript:void(0);" class="header-burger-menu visible-xs visible-sm"><i>Menu</i></a>

        <nav role="navigation" class="probootstrap-nav hidden-xs hidden-sm">
            <ul class="probootstrap-main-nav">

                <li class="header-phone" style="display:none;">
                    <a href="tel:{{ config('company.info.telephone') }}">
                        <i class="fa fa-mobile-phone"></i>
                        <strong>{{ config('company.info.telephone') }}</strong>
                    </a>
                </li>

                @if(Auth::check())
                    <li class="visible-xs visible-sm"><a href="{{ url('/home/todolist') }}"><i class="fa fa-check-square-o"></i> 我的待办事</a></li>
                    <li class="visible-xs visible-sm"><a href="{{ url('/home/schedule') }}"><i class="fa fa-calendar-plus-o"></i> 我的日程</a></li>
                    <li class="visible-xs visible-sm"><a href="{{ url('/home/collection') }}"><i class="fa fa-star-o"></i> 我的收藏</a></li>
                    <li class="visible-xs visible-sm"><a href="{{ url('/home/favor') }}"><i class="fa fa-thumbs-o-up"></i> 我的点赞</a></li>
                @endif

                <li class="mb10"> &nbsp; </li>

                @if(Auth::check())
                    <li class=""><a href="{{ url('/home') }}">内容管理后台</a></li>
                    <li class=""><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> 退出</a></li>
                @endif

                <li class="header-wechat hidden-xs hidden-sm" role="button">
                    <a href="javascript:void(0);"><i class="fa fa-weixin"></i> 微信公众号</a>
                    <span class="image-box">
                        <img src="{{ url('/images/qrcode_for_softdoc.jpg') }}" alt="微信公众号">
                    </span>
                </li>
            </ul>
            <div class="extra-text visible-xs visible-sm">
                <a href="javascript:void(0);" class="header-burger-menu"><i>Menu</i></a>
            </div>
            <div class="extra-text" style="display:none;">
                <h5 class="mb20">关注</h5>
                <ul class="social-buttons header-social">
                    <li><a target="_blank" href="http://www.wechat.com">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-wechat.png') }}" alt="WeChat Logo">
                        </a></li>
                </ul>
                {{--<p><small>© 2017-2018 softdoc.cn 版权所有</small></p>--}}
                {{--<p><small>沪ICP备18011005号-2</small></p>--}}
            </div>
        </nav>

    </div>
</header>
{{--<!-- END: header -->--}}