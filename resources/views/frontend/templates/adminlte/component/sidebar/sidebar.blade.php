{{--<!-- Left side column. contains the logo and sidebar -->--}}
<aside class="main-sidebar _none">

    {{--<!-- sidebar: style can be found in sidebar.less -->--}}
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">

            <li class="header">目录</li>

            <li class="treeview">
                <a href="{{url('/')}}"><i class="fa fa-list text-orange"></i> <span>平台主页</span></a>
            </li>

            <li class="header">Home</li>

            @if(!Auth::check())

                <li class="treeview">
                    <a href="{{url('/login')}}"><i class="fa fa-circle-o"></i> <span>登录</span></a>
                </li>
                <li class="treeview">
                    <a href="{{url('/register')}}"><i class="fa fa-circle-o"></i> <span>注册</span></a>
                </li>
            @else
                <li class="treeview">
                    <a href="{{url('/home')}}"><i class="fa fa-home text-default"></i> <span>返回我的后台</span></a>
                </li>
            @endif


        </ul>
        <!-- /.sidebar-menu -->
    </section>
    {{--<!-- /.sidebar -->--}}
</aside>