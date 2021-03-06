{{--<!-- START: module -->--}}
<div class="main-side-block hidden-xs hidden-sm">

    <ul>
        <div class="side-info">
            <a href="{{ url('/user/'.$item->user->id) }}">
                <div class="box-body main-side-hover">
                    <img src="{{ url(env('DOMAIN_CDN').'/'.$item->user->portrait_img) }}" alt="">
                    <span><b>{{ $item->user->name or '' }}</b></span>
                </div>
            </a>
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

</div>
{{--<!-- END: module -->--}}