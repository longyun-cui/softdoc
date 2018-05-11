<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{url('/')}}" class="logo" style="display:none;background-color:#222d32;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>师</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>三人行</b></span>
    </a>

    {{--<!-- Header Navbar -->--}}
    <nav class="navbar navbar-static-top" role="navigation" style="margin-left:0;background-color:#1a2226;">

        @yield('header-sidebar-toggle-menu')



        <div class="navbar-custom-menu" style="height:50px;color:#f39c12 !important;float:left;">
            <span class="logo-big"><a href="{{url('/')}}"><img src="/favicon_transparent.png" class="img-icon" alt="Image"> <b>课栈</b></a></span>
        </div>



        {{--<!-- Navbar Right Menu -->--}}
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

{{--                @if(Auth::check())--}}
                    {{--<li><a target="_blank" href="{{url('/home')}}"><i class="fa fa-home text-default"></i> <span>{{Auth::user()->name}}</span></a></li>--}}
                {{--@else--}}
                    {{--<li><a href="{{url('/login')}}"><i class="fa fa-circle-o"></i> <span>登录</span></a></li>--}}
                    {{--<li><a href="{{url('/register')}}"><i class="fa fa-circle-o"></i> <span>注册</span></a></li>--}}
                {{--@endif--}}

                <li class="dropdown notifications-menu visible-xs visible-sm">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-align-justify"></i>
                        {{--<span class="label label-warning">10</span>--}}
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">
                            <ul class="menu">
                                <li><a href="{{url('/')}}"><i class="fa fa-home text-orange"></i> <span>平台主页</span></a></li>
                                <li><a href="{{url('/courses')}}"><i class="fa fa-list text-orange"></i> <span>书课目录</span></a></li>
                            </ul>
                        </li>
                        <li class="header">
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @if(Auth::check())
                                    <li><a href="javascript:void(0);"><i class="fa fa-user text-blue"></i> {{Auth::user()->name}}</a></li>
                                    <li><a href="{{url('/home')}}" target="_blank"><i class="fa fa-home text-default"></i> <span>返回我的后台</span></a></li>
                                    <li><a href="{{url('/logout')}}"><i class="fa fa-power-off text-default"></i> <span>退出</span></a></li>
                                @else
                                    <li><a href="{{url('/login')}}"><i class="glyphicon glyphicon-log-in"></i> <span>登录</span></a></li>
                                    <li><a href="{{url('/register')}}"><i class="fa fa-circle-o"></i> <span>注册</span></a></li>
                                @endif
                            </ul>
                        </li>
                        {{--<li class="footer"><a href="#">View all</a></li>--}}
                    </ul>
                </li>

                {{--<!-- Control Sidebar Toggle Button -->--}}
                <li class="hidden-xs hidden-sm" style="display:none;">
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-align-justify"></i></a>
                </li>
            </ul>
        </div>


    </nav>

</header>


