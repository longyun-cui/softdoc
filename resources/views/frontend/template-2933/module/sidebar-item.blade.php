{{--<!-- START: module -->--}}
<div class="main-side-block main-side-container text-center">
    <ul>
        <div class="side-info">
            <a href="{{ url('/user/'.$item->user->id) }}">
                <div class="box-body main-side-hover">
                    <img src="{{ url(env('DOMAIN_CDN').'/'.$item->user->portrait_img) }}" alt="">
                </div>
            </a>
        </div>

        <li class="{{ $item_mine_active or '' }}">
            <a href="{{ url('/user/'.$item->user->id) }}">
                <div class="box-body main-side-hover row-ellipsis">
                    {{ $item->user->name or '' }}
                </div>
            </a>
        </li>

        <li class="{{ $item_relation_follow_active or '' }}">
            <a href="{{ url('/user/'.$item->user->id.'/follow') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-calendar-plus-o _none"></i> 关注 {{ $item->user->follow_num or 0 }}
                </div>
            </a>
        </li>

        <li class="{{ $item_relation_fans_active or '' }}">
            <a href="{{ url('/user/'.$item->user->id.'/fans') }}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-calendar-plus-o _none"></i> 粉丝 {{ $item->user->fans_num or 0 }}
                </div>
            </a>
        </li>

        <br>

        <li class="{{ $item_root_active or '' }}">
            <a href="{{ url('/user/'.$item->user->id) }}">
                <div class="box-body main-side-hover">
                    Ta的主页
                </div>
            </a>
        </li>
        <li class="{{ $item_original_active or '' }}">
            <a href="{{ url('/user/'.$item->user->id.'/original') }}">
                <div class="box-body main-side-hover">
                    Ta的原创
                </div>
            </a>
        </li>
    </ul>
</div>
{{--<!-- END: module -->--}}