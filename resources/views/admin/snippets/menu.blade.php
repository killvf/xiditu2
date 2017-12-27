<ul class="sidebar-nav">

     <li>
        <a href="{{route('staff.language.lists')}}" @if($controller=='admin.languages') class="active"@endif>
            <i class="fa fa-language sidebar-nav-icon"></i>
            <span class="sidebar-nav-mini-hide">语言管理</span></a>

    </li>
    <li>
        <a href="{{route('staff.nav.lists')}}" @if($controller=='admin.nav') class="active"@endif>
            <i class="fa fa-rocket sidebar-nav-icon"></i>
            <span class="sidebar-nav-mini-hide">导航管理</span></a>

    </li>
    <li>
        <a href="{{route('staff.invite.lists')}}" @if($controller=='admin.invite') class="active"@endif>
            <i class="fa fa-flag sidebar-nav-icon"></i>
            <span class="sidebar-nav-mini-hide">招聘管理</span></a>

    </li>
    <li>
        <a href="{{route('staff.article.lists')}}" @if($controller=='admin.article') class="active"@endif>
            <i class="fa fa-newspaper-o sidebar-nav-icon"></i>
            <span class="sidebar-nav-mini-hide">文章管理</span></a>

    </li>
    <li>
        <a href="{{route('staff.slider.lists')}}" @if($controller=='admin.slider') class="active"@endif>
            <i class="fa fa-image sidebar-nav-icon"></i>
            <span class="sidebar-nav-mini-hide">幻灯片管理</span></a>

    </li>

</ul>