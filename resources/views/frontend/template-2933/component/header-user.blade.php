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

                <li class="mb10"> &nbsp; </li>

                @if(Auth::check())
                    @if(Auth::user()->id != $data->id)
                        @if(!empty($relation) && ($relation->relation_type==21 || $relation->relation_type==41) )
                            <li class="follow-remove-it" data-user-id="{{ $data->id or 0 }}">
                                <a href="javascript:void(0);"><i class="fa fa-minus"></i> 取消关注</a>
                            </li>
                        @else
                            <li class="follow-add-it" data-user-id="{{ $data->id or 0 }}">
                                <a href="javascript:void(0);"><i class="fa fa-plus"></i> 添加关注</a>
                            </li>
                        @endif
                    @endif
                @else
                    <li class="follow-add-it" data-user-id="{{ $data->id or 0 }}">
                        <a href="javascript:void(0);"><i class="fa fa-plus"></i> 添加关注</a>
                    </li>
                @endif

                <li class=""><a href="{{ url('/') }}"><i class="fa fa-home"></i> 返回首页</a></li>

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