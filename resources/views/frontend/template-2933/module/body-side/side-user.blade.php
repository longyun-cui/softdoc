{{--<!-- START: module -->--}}
<div class="main-side-block main-side-container">
    @if(Auth::check())
        <ul>
            <div class="side-info">
                <div class="box-body main-side-hover">
                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="">
                    <span><b>{{ $data->name }}</b></span>
                </div>
            </div>
            <div class="side-follow">
                <div class="side-follow-box pull-left">
                    <a href="{{url('/')}}">
                        <span><b>{{ $item->user->follow_num or 0 }}</b></span>
                        <span class="font-12px">关注</span>
                    </a>
                </div>
                <div class="side-follow-box pull-right">
                    <a href="{{url('/')}}">
                        <span><b>{{ $item->user->fans_num or 0 }}</b></span>
                        <span class="font-12px">被关注</span>
                    </a>
                </div>
            </div>
        </ul>
    @else
        <ul>
            <li>
                <a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxaf993c7aace04371&redirect_uri=http%3A%2F%2Fsoftdoc.cn%2Fweixin%2Flogin&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect">
                    <div class="box-body main-side-hover">
                        <i class="fa fa-sign-in text-orange"></i> <span> 登录/注册</span>
                    </div>
                </a>
            </li>
        </ul>
    @endif
</div>
{{--<!-- END: module -->--}}