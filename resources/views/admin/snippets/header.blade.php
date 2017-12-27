<header class="navbar navbar-inverse navbar-fixed-top">
    <!-- Left Header Navigation -->
    <ul class="nav navbar-nav-custom">
        <!-- Main Sidebar Toggle Button -->
        <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
            </a>
        </li>
        <!-- END Main Sidebar Toggle Button -->

        <!-- Header Link -->
        {{--<li class="hidden-xs animation-fadeInQuick">--}}
            {{--<a href=""><strong>WELCOME</strong></a>--}}
        {{--</li>--}}
        <!-- END Header Link -->
    </ul>
    <!-- END Left Header Navigation -->

    <!-- Right Header Navigation -->
    <ul class="nav navbar-nav-custom pull-right">
        <!-- Search Form -->
        {{--<li>--}}
            {{--<form action="javascript:void(0)" method="post" class="navbar-form-custom">--}}
                {{--<input type="text" id="top-search" name="top-search" class="form-control" placeholder="Search..">--}}
            {{--</form>--}}
        {{--</li>--}}
        <!-- END Search Form -->

        <!-- Alternative Sidebar Toggle Button -->
        {{--<li>--}}
            {{--<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');this.blur();">--}}
                {{--<i class="gi gi-settings"></i>--}}
            {{--</a>--}}
        {{--</li>--}}
        <!-- END Alternative Sidebar Toggle Button -->

        <!-- User Dropdown -->
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{asset('admin/img/placeholders/avatars/avatar9.jpg')}}" alt="avatar">
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">
                    <strong>root</strong>
                </li>

                <li>
                    <a href="{{route('staff.logout')}}">
                        <i class="fa fa-power-off fa-fw pull-right"></i>
                        退出
                    </a>
                </li>
            </ul>
        </li>
        <!-- END User Dropdown -->
    </ul>
    <!-- END Right Header Navigation -->
</header>