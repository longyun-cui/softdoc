{{--<!-- START: module -->--}}
<div class="main-side-block main-side-container">
    <ul>
        <div class="side-info">
            <a href="{{ url('/user/'.$data->id) }}">
                <div class="box-body main-side-hover">
                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="">
                    <span><b>{{ $data->name or '' }}</b></span>
                </div>
            </a>
        </div>
        <div class="side-follow">
            <div class="side-follow-box pull-left">
                <a href="{{ url('/user/'.$data->id.'/follow') }}">
                    <span><b>{{ $data->follow_num or 0 }}</b></span>
                    <span class="font-12px">关注</span>
                </a>
            </div>
            <div class="side-follow-box pull-right">
                <a href="{{ url('/user/'.$data->id.'/fans') }}">
                    <span><b>{{ $data->fans_num or 0 }}</b></span>
                    <span class="font-12px">粉丝</span>
                </a>
            </div>
        </div>
    </ul>
</div>


<div class="main-side-block main-side-container">
    <ul>
        <li class="{{ $user_root_active or '' }}">
            <a href="{{ url('/user/'.$data->id) }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-home"></i> <span> 主页</span>
                </div>
            </a>
        </li>
        <li class="{{ $user_original_active or '' }}">
            <a href="{{ url('/user/'.$data->id.'/original') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-globe"></i> <span> 原创内容</span>
                </div>
            </a>
        </li>
    </ul>
</div>
{{--<!-- END: module -->--}}