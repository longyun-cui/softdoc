{{--<!-- START: module -->--}}
<div class="main-side-block main-side-container">
    @if(Auth::check())
    <ul>
        <div class="side-info">
            <a href="{{ url('/') }}">
                <div class="box-body main-side-hover">
                    <img src="{{ url(env('DOMAIN_CDN').'/'.Auth::user()->portrait_img) }}" alt="">
                    <span><b>{{ Auth::user()->name }}</b></span>
                </div>
            </a>
        </div>
        <div class="side-follow">
            <div class="side-follow-box pull-left">
                <a href="{{ url('/home/relation/follow') }}">
                    <span><b>{{ Auth::user()->follow_num }}</b></span>
                    <span class="font-12px">关注</span>
                </a>
            </div>
            <div class="side-follow-box pull-right">
                <a href="{{ url('/home/relation/fans') }}">
                    <span><b>{{ Auth::user()->fans_num }}</b></span>
                    <span class="font-12px">粉丝</span>
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


@if(Auth::check())
<div class="main-side-block main-side-container">
    <ul>
        <li class="{{ $root_todolist_active or '' }}">
            <a href="{{ url('/home/todolist') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-check-square-o"></i> <span> 待办事</span>
                </div>
            </a>
        </li>
        <li class="{{ $root_schedule_active or '' }}">
            <a href="{{ url('/home/schedule') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-calendar-plus-o"></i> <span> 日程</span>
                </div>
            </a>
        </li>
        <li class="{{ $root_collection_active or '' }}">
            <a href="{{ url('/home/collection') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-star-o"></i> <span> 我的收藏</span>
                </div>
            </a>
        </li>
        <li class="{{ $root_favor_active or '' }}">
            <a href="{{ url('/home/favor') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-thumbs-o-up"></i> <span> 我的点赞</span>
                </div>
            </a>
        </li>
    </ul>
</div>
@endif


<div class="main-side-block main-side-container">
    <ul>
        <li class="{{ $root_discovery_active or '' }}">
            <a href="{{url('/home/discovery')}}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-globe"></i> <span> 发现</span>
                </div>
            </a>
        </li>
        <li class="{{ $root_follow_active or '' }}">
            <a href="{{url('/home/follow')}}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-globe"></i> <span> 关注的</span>
                </div>
            </a>
        </li>
        <li class="{{ $root_circle_active or '' }}">
            <a href="{{url('/home/circle')}}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-globe"></i> <span> 好友圈</span>
                </div>
            </a>
        </li>
    </ul>
</div>
{{--<!-- END: module -->--}}