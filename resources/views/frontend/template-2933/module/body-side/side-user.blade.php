{{--<!-- START: module -->--}}
<div class="main-side-block main-side-container">
    <ul>
        <div class="side-info">
            <div class="box-body main-side-hover">
                <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="">
                <span><b>{{ $data->name or '' }}</b></span>
            </div>
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
{{--<!-- END: module -->--}}