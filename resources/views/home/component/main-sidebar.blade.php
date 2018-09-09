{{--<!-- Left side column. contains the logo and sidebar -->--}}
<aside class="main-sidebar">

    {{--<!-- sidebar: style can be found in sidebar.less -->--}}
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
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
        <ul class="sidebar-menu">

            <li class="header">内容管理</li>

            <li class="treeview {{$menu_all_list or ''}}">
                <a href="{{url('/home/item/list')}}"><i class="fa fa-list text-red"></i> <span>全部内容</span></a>
            </li>

            <li class="treeview {{$menu_article_list or ''}}">
                <a href="{{url('/home/item/list?category=article')}}"><i class="fa fa-circle-o text-red"></i> <span>一般文本</span></a>
            </li>

            <li class="treeview {{$menu_debase_list or ''}}">
                <a href="{{url('/home/item/list?category=debase')}}"><i class="fa fa-circle-o text-red"></i> <span>辩题</span></a>
            </li>

            <li class="treeview {{$menu_menu_list or ''}}">
                <a href="{{url('/home/item/list?category=menu')}}"><i class="fa fa-circle-o text-red"></i> <span>书目类型</span></a>
            </li>

            <li class="treeview {{$menu_timeline_list or ''}}">
                <a href="{{url('/home/item/list?category=timeline')}}"><i class="fa fa-circle-o text-red"></i> <span>时间线</span></a>
            </li>



            <li class="header _none">其他</li>

            <li class="treeview {{$menu_collect_course or ''}} _none">
                <a href="{{url('/home/collect/course/list')}}"><i class="fa fa-heart text-red"></i> <span>收藏「课程」</span></a>
            </li>

            <li class="treeview {{$menu_favor_course or ''}} _none">
                <a href="{{url('/home/favor/course/list')}}"><i class="fa fa-thumbs-up text-red"></i> <span>点赞「课程」</span></a>
            </li>

            <li class="treeview {{$menu_collect_chapter or ''}} _none">
                <a href="{{url('/home/collect/chapter/list')}}"><i class="fa fa-heart text-blue"></i> <span>收藏内容</span></a>
            </li>

            <li class="treeview {{$menu_favor_chapter or ''}} _none">
                <a href="{{url('/home/favor/chapter/list')}}"><i class="fa fa-thumbs-up text-blue"></i> <span>点赞内容</span></a>
            </li>



            <li class="header"><i class="fa fa-envelope"></i></li>

            <li class="treeview {{$menu_notification_comment or ''}}">
                <a href="{{url('/home/notification/comment')}}">
                    <i class="fa fa-bell"></i>消息
                    <span class="pull-right-container">
                        <small class="label pull-right bg-red">{{$notification_count or ''}}</small>
                        <small class="label pull-right bg-blue _none">17</small>
                    </span>
                </a>
            </li>

            <li class="treeview {{$menu_notification_favor or ''}} _none">
                <a href="{{url('/home/notification/favor')}}"><i class="fa fa-dot-circle-o"></i>点赞</a>
            </li>

            <li class="treeview {{$menu_notification_comment or ''}} {{$menu_notification_favor or ''}} _none">
                <a href="">
                    <i class="fa fa-envelope"></i> <span>消息</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{$menu_notification_comment or ''}}">
                        <a href="{{url('/home/notification/comment')}}"><i class="fa fa-dot-circle-o"></i>评论</a>
                    </li>
                    <li class="{{$menu_notification_favor or ''}}">
                        <a href="{{url('/home/notification/favor')}}"><i class="fa fa-dot-circle-o"></i>点赞</a>
                    </li>
                </ul>
            </li>


            <li class="header">课程站</li>

            <li class="treeview">
                <a href="{{url('/')}}" target="_blank"><i class="fa fa-cube text-default"></i> <span>平台主页</span></a>
            </li>


        </ul>
        <!-- /.sidebar-menu -->
    </section>
    {{--<!-- /.sidebar -->--}}
</aside>