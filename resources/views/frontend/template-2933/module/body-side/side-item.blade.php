{{--<!-- START: module -->--}}
<div class="main-side-block">

    <ul>
        <div class="side-info">
            <a href="{{ url('/user/'.encode($item->user->id)) }}">
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



<div class="main-side-block">

    <ul>
        <li>
            <a href="{{url('/discovery')}}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-globe text-orange"></i> <span> 发现</span>

                </div>
            </a>
        </li>
        <li>
            <a href="{{url('/home/circle')}}">
                <div class="box-body main-side-hover">
                    <i class="fa fa-globe text-orange"></i> <span> 好友圈</span>
                </div>
            </a>
        </li>
    </ul>


</div>
{{--<!-- END: module -->--}}