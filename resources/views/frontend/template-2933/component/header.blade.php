{{--<!-- START: header -->--}}
<header role="banner" class="section-header">
    <div class="full-screen">

        <a href="{{ url('/') }}" class="header-logo">
            <img src="{{ url('/images/softdoc_white_0.png') }}" alt="如未">
        </a>
        <a href="{{ url('/') }}">
            如未科技
        </a>

        <a href="javascript:void(0);" class="header-burger-menu visible-xs visible-sm"><i>Menu</i></a>
        <div class="mobile-menu-overlay"></div>

        <nav role="navigation" class="probootstrap-nav hidden-xs hidden-sm">
            <ul class="probootstrap-main-nav">

                <li class="header-phone" style="display:none;">
                    <a href="tel:{{ config('company.info.telephone') }}">
                        <i class="fa fa-mobile-phone"></i>
                        <strong>{{ config('company.info.telephone') }}</strong>
                    </a>
                </li>

                @if(Auth::check())
                <li><a href="{{ url('/home') }}" style="color:#fff">内容管理后台</a></li>
                <li><a href="{{ url('/logout') }}" style="color:#fff">退出</a></li>
                @endif

                <li class="header-wechat" role="button">
                    <a href="javascript:void(0);" style="color:#fff"><i class="fa fa-weixin"></i> 微信公众号</a>
                    <span class="image-box">
                        <img src="{{ url('/images/qrcode_for_softdoc.jpg') }}" alt="微信公众号">
                    </span>
                </li>
            </ul>
            <div class="extra-text visible-xs visible-sm">
                <a href="javascript:void(0);" class="header-burger-menu"><i>Menu</i></a>
                <h5 class="mb20">关注</h5>
                <ul class="social-buttons header-social">
                    <li><a target="_blank" href="http://www.wechat.com">
                        <img src="{{ asset('/common/images/logo-icon/icon-logo-wechat.png') }}" alt="WeChat Logo">
                    </a></li>
                    <li><a target="_blank" href="http://www.linkedin.com/company/keron-international-relocation-movers/">
                        <img src="{{ asset('/common/images/logo-icon/icon-logo-linkedin.png') }}" alt="Linkedin Logo">
                    </a></li>
                    <li><a target="_blank" href="https://moveaide.com/movers/keron-international-relocation-shanghai-china-mover-reviews">
                        <img src="{{ asset('/common/images/logo-icon/icon-logo-moveaide.png') }}" alt="MoveAide Logo">
                    </a></li>
                    <li><a target="_blank" href="http://www.smartshanghai.com/venue/15561/keron_international_relocation_and_movers_zhongshan_bei_lu">
                        <img src="{{ asset('/common/images/logo-icon/icon-logo-smart.png') }}" alt="Instagram Logo">
                    </a></li>
                </ul>
                <p><small>© 2017-2018 softdoc.cn 版权所有</small></p>
                <p><small>沪ICP备18011005号-2</small></p>
            </div>
        </nav>

    </div>
</header>
{{--<!-- END: header -->--}}