<div class="box-body main-side-block">

    @if(!Auth::check())

        <a href="{{url('/login')}}">
            <div class="box-body main-side-hover">
                <i class="fa fa-circle-o text-default"></i> <span> 登录</span>
            </div>
        </a>

        <a href="{{url('/register')}}">
            <div class="box-body main-side-hover">
                <i class="glyphicon-log-in text-default"></i> <span> 注册</span>
            </div>
        </a>
    @else
            <div class="box-body">
                <i class="fa fa-user text-blue"></i> <span> {{Auth::user()->name}}</span>
            </div>

        <a href="{{url('/home')}}" target="_blank">
            <div class="box-body main-side-hover">
                <i class="fa fa-home text-default"></i> <span> 返回我的后台</span>
            </div>
        </a>

        <a href="{{url('/logout')}}">
            <div class="box-body main-side-hover">
                <i class="fa fa-power-off text-default"></i> <span> 退出</span>
            </div>
        </a>
    @endif

</div>