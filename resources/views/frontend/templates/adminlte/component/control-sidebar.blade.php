{{--<!-- Control Sidebar -->--}}
<aside class="control-sidebar control-sidebar-dark">

    {{--<!-- Tab panes -->--}}
    <div class="tab-content">

        {{--<!-- Home tab content -->--}}
        <div class="tab-pane active">

            <ul class="sidebar-menu">


                <li class="treeview">
                    <a href="{{url('/')}}"><i class="fa fa-home text-orange"></i> <span class="text-white">平台主页</span></a>
                </li>

                <li class="treeview">
                    <a href="{{url('/courses')}}"><i class="fa fa-home text-orange"></i> <span>书目录</span></a>
                </li>


                @if(!Auth::check())

                    <li class="treeview">
                        <a href="{{url('/login')}}"><i class="fa fa-circle-o"></i> <span>登录</span></a>
                    </li>
                    <li class="treeview">
                        <a href="{{url('/register')}}"><i class="fa fa-circle-o"></i> <span>注册</span></a>
                    </li>
                @else
                    <li class="header">{{Auth::user()->name}}</li>
                    <li class="treeview">
                        <a href="{{url('/home')}}" target="_blank"><i class="fa fa-home text-default"></i> <span>返回我的后台</span></a>
                    </li>
                @endif


            </ul>


        </div>

    </div>

</aside>


<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>