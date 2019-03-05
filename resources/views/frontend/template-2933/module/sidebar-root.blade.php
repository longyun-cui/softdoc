{{--<!-- START: module -->--}}
<div class="main-side-block main-side-container text-center">
    @if(Auth::check())
    <ul>
        <div class="side-info">
            <a href="{{ url('/') }}">
                <div class="box-body main-side-hover">
                    <img src="{{ url(env('DOMAIN_CDN').'/'.Auth::user()->portrait_img) }}" alt="">
                </div>
            </a>
        </div>

        <li class="{{ $root_mine_active or '' }}">
            <a href="{{ url('/') }}">
                <div class="box-body main-side-hover multi-ellipsis-1" title="{{ Auth::user()->name }}">
                    {{ Auth::user()->name }}
                </div>
            </a>
        </li>

        <li class="{{ $root_relation_follow_active or '' }}">
            <a href="{{ url('/home/relation/follow') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-calendar-plus-o _none"></i> 关注 {{ Auth::user()->follow_num }}
                </div>
            </a>
        </li>

        <li class="{{ $root_relation_fans_active or '' }}">
            <a href="{{ url('/home/relation/fans') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-calendar-plus-o _none"></i> 粉丝 {{ Auth::user()->fans_num }}
                </div>
            </a>
        </li>

        <br>

        <li class="{{ $root_todolist_active or '' }}">
            <a href="{{ url('/home/mine/todolist') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-check-square-o _none"></i> 待办事
                </div>
            </a>
        </li>
        <li class="{{ $root_schedule_active or '' }}">
            <a href="{{ url('/home/mine/schedule') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-calendar-plus-o _none"></i> 日程
                </div>
            </a>
        </li>
        <li class="{{ $root_collection_active or '' }}">
            <a href="{{ url('/home/mine/collection') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-star-o _none"></i> 收藏
                </div>
            </a>
        </li>
        <li class="{{ $root_favor_active or '' }}">
            <a href="{{ url('/home/mine/favor') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-thumbs-o-up _none"></i> 点赞
                </div>
            </a>
        </li>

        <br>

        <li class="{{ $root_mine_active or '' }}">
            <a href="{{ url('/home/mine/original') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-check-square-o _none"></i> 我的原创
                </div>
            </a>
        </li>

        <br>

        <li class="{{ $root_discovery_active or '' }}">
            <a href="{{ url('/home/mine/discovery') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-globe _none"></i> 发现
                </div>
            </a>
        </li>
        <li class="{{ $root_follow_active or '' }}">
            <a href="{{ url('/home/mine/follow') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-globe _none"></i> 关注的
                </div>
            </a>
        </li>
        <li class="{{ $root_circle_active or '' }}">
            <a href="{{ url('/home/mine/circle') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-globe _none"></i> 好友圈
                </div>
            </a>
        </li>
</ul>
    @else
    <ul class="_none">
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