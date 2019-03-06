{{--<!-- START: module -->--}}
<div class="main-side-block main-side-container text-center">
    <ul>
        <div class="side-info">
            <a href="{{ url('/user/'.$data->id) }}">
                <div class="box-body main-side-hover">
                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="">
                </div>
            </a>
        </div>

        <li class="{{ $user_mine_active or '' }}">
            <a href="{{ url('/user/'.$data->id) }}">
                <div class="box-body main-side-hover row-ellipsis" title="{{ $data->name or '' }}">
                    {{ $data->name or '' }}
                </div>
            </a>
        </li>

        <li class="{{ $user_relation_follow_active or '' }}">
            <a href="{{ url('/user/'.$data->id.'/follow') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-calendar-plus-o _none"></i> 关注 {{ $data->follow_num or 0 }}
                </div>
            </a>
        </li>

        <li class="{{ $user_relation_fans_active or '' }}">
            <a href="{{ url('/user/'.$data->id.'/fans') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-calendar-plus-o _none"></i> 粉丝 {{ $data->fans_num or 0 }}
                </div>
            </a>
        </li>

        <br>

        <li class="{{ $user_root_active or '' }}">
            <a href="{{ url('/user/'.$data->id) }}">
                <div class="box-body main-side-hover">
                    Ta的主页
                </div>
            </a>
        </li>
        <li class="{{ $user_original_active or '' }}">
            <a href="{{ url('/user/'.$data->id.'/original') }}">
                <div class="box-body main-side-hover">
                    Ta的原创
                </div>
            </a>
        </li>
    </ul>
</div>
{{--<!-- END: module -->--}}