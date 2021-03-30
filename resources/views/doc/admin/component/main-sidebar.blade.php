{{--<!-- Left side column. contains the logo and sidebar -->--}}
<aside class="main-sidebar">

    {{--<!-- sidebar: style can be found in sidebar.less -->--}}
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel _none">
            <div class="pull-left image">
                <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('admin')->user()->username }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form _none">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree"data-widget="tree">


            {{--用户管理--}}
            <li class="header">机构管理</li>

            <li class="treeview {{ $sidebar_user_all_list_active or '' }}">
                <a href="{{ url('/admin/user/user-all-list') }}">
                    <i class="fa fa-user"></i><span>全部用户</span>
                </a>
            </li>




            {{--内容管理--}}
            <li class="header">内容管理</li>

            <li class="treeview {{ $sidebar_item_all_list_active or '' }} ">
                <a href="{{ url('/admin/item/item-all-list') }}">
                    <i class="fa fa-file-text text-green"></i><span>全部内容</span>
                </a>
            </li>




            {{--流量统计--}}
            <li class="header">流量统计</li>

            <li class="treeview {{ $sidebar_statistic_active or '' }}">
                <a href="{{ url('/admin/statistic') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>流量统计</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_statistic_all_list_active or '' }}">
                <a href="{{ url('/admin/statistic/statistic-all-list') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>统计列表</span>
                </a>
            </li>




            {{--留言管理--}}
            <li class="header _none">消息管理</li>

            <li class="treeview {{ $sidebar_notice_notice_list_active or '' }} _none">
                <a href="{{ url('/admin/notice/notice-list') }}">
                    <i class="fa fa-envelope"></i> <span>消息列表</span>
                </a>
            </li>

            <li class="treeview {{ $sidebar_notice_my_notice_list_active or '' }} _none">
                <a href="{{ url('/admin/notice/my-notice-list') }}">
                    <i class="fa fa-envelope"></i> <span>我发布的</span>
                </a>
            </li>

            <li class="treeview {{ $sidebar_notice_active or '' }} _none">
                <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span>公告&通知管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $sidebar_notice_all_active or '' }}">
                        <a href="{{ url('/admin/notice/notice-all') }}">
                            <i class="fa fa-circle-o"></i> <span>全体通知</span>
                        </a>
                    </li>
                    <li class="{{ $sidebar_notice_agent_active or '' }}">
                        <a href="{{ url('/admin/notice/notice-agent') }}"><i class="fa fa-circle-o"></i> <span>代理商公告</span></a>
                    </li>
                    <li class="{{ $sidebar_notice_client_active or '' }}">
                        <a href="{{ url('/admin/notice/notice-client') }}"><i class="fa fa-circle-o"></i> <span>客户公告</span></a>
                    </li>
                </ul>
            </li>



            {{--平台--}}
            <li class="header">平台</li>

            <li class="treeview">
                <a href="{{ url('/') }}" target="_blank">
                    <i class="fa fa-cube text-default"></i> <span>平台首页</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ url('/admin/user/user-login?type=atom&id=100') }}" target="_blank">
                    <i class="fa fa-sign-in text-default"></i> <span>登录原子</span>
                </a>
            </li>



        </ul>
        <!-- /.sidebar-menu -->
    </section>
    {{--<!-- /.sidebar -->--}}
</aside>