<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="zh-cn"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="zh-cn"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>后台管理系统</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{asset('admin/img/favicon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('admin/img/icon57.png')}}" sizes="57x57">
    <link rel="apple-touch-icon" href="{{asset('admin/img/icon72.png')}}" sizes="72x72">
    <link rel="apple-touch-icon" href="{{asset('admin/img/icon76.png')}}" sizes="76x76">
    <link rel="apple-touch-icon" href="{{asset('admin/img/icon114.png')}}" sizes="114x114">
    <link rel="apple-touch-icon" href="{{asset('admin/img/icon120.png')}}" sizes="120x120">
    <link rel="apple-touch-icon" href="{{asset('admin/img/icon144.png')}}" sizes="144x144">
    <link rel="apple-touch-icon" href="{{asset('admin/img/icon152.png')}}" sizes="152x152">
    <link rel="apple-touch-icon" href="{{asset('admin/img/icon180.png')}}" sizes="180x180">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}">

    <!-- Related styles of various icon packs and plugins -->
    <link rel="stylesheet" href="{{asset('admin/css/plugins.css')}}">

    <link rel="stylesheet" href="{{asset('admin/css/main.css')}}">


    <link rel="stylesheet" href="{{asset('admin/css/themes.css')}}">

    <!-- Modernizr (browser feature detection library) -->
    <script src="{{asset('admin/js/vendor/modernizr-3.3.1.min.js')}}"></script>
    <script src="{{asset('admin/js/vendor/jquery-2.2.4.min.js')}}"></script>    
    @yield('style')
</head>
<body>


<div id="page-wrapper" class="page-loading">
    <!-- Preloader -->
    <!-- Preloader functionality (initialized in js/app.js) - pageLoading() -->
    <!-- Used only if page preloader enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version) -->
    @include('admin.snippets.loader')
    <!-- END Preloader -->

    <!-- Page Container -->
    <!-- In the PHP version you can set the following options from inc/config file -->
    <!--
        Available #page-container classes:

        'sidebar-light'                                 for a light main sidebar (You can add it along with any other class)

        'sidebar-visible-lg-mini'                       main sidebar condensed - Mini Navigation (> 991px)
        'sidebar-visible-lg-full'                       main sidebar full - Full Navigation (> 991px)

        'sidebar-alt-visible-lg'                        alternative sidebar visible by default (> 991px) (You can add it along with any other class)

        'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar
        'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar

        'fixed-width'                                   for a fixed width layout (can only be used with a static header/main sidebar layout)

        'enable-cookies'                                enables cookies for remembering active color theme when changed from the sidebar links (You can add it along with any other class)
    -->
    <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">
        <!-- Alternative Sidebar -->
        <div id="sidebar-alt" tabindex="-1" aria-hidden="true">
            <!-- Toggle Alternative Sidebar Button (visible only in static layout) -->
            <a href="javascript:void(0)" id="sidebar-alt-close" onclick="App.sidebar('toggle-sidebar-alt');"><i class="fa fa-times"></i></a>

            <!-- Wrapper for scrolling functionality -->
            <div id="sidebar-scroll-alt">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Profile -->

                    <!-- END Profile -->

                </div>
                <!-- END Sidebar Content -->
            </div>
            <!-- END Wrapper for scrolling functionality -->
        </div>
        <!-- END Alternative Sidebar -->

        <!-- Main Sidebar -->
        <div id="sidebar">
            <!-- Sidebar Brand -->
            <div id="sidebar-brand" class="themed-background">
                <a href="{{route('staff.index')}}" class="sidebar-title">
                    <i class="fa fa-cube"></i> <span class="sidebar-nav-mini-hide">后台管理系统</span>
                </a>
            </div>
            <!-- END Sidebar Brand -->

            <!-- Wrapper for scrolling functionality -->
            <div id="sidebar-scroll">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Sidebar Navigation -->
                    @include('admin.snippets.menu')
                    <!-- END Sidebar Navigation -->
                </div>
                <!-- END Sidebar Content -->
            </div>
            <!-- END Wrapper for scrolling functionality -->

            <!-- Sidebar Extra Info -->
            @include('admin.snippets.sidebar')
            <!-- END Sidebar Extra Info -->
        </div>
        <!-- END Main Sidebar -->

        <!-- Main Container -->
        <div id="main-container">
            <!-- Header -->
            <!-- In the PHP version you can set the following options from inc/config file -->
            <!--
                Available header.navbar classes:

                'navbar-default'            for the default light header
                'navbar-inverse'            for an alternative dark header

                'navbar-fixed-top'          for a top fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
                    'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

                'navbar-fixed-bottom'       for a bottom fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
                    'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
            -->
            @include('admin.snippets.header')
            <!-- END Header -->

            <!-- Page content -->
            <div id="page-content">
                @yield('content')
            </div>
            <!-- END Page Content -->
        </div>
        <!-- END Main Container -->
    </div>

    <!-- END Page Container -->
</div>
<!-- END Page Wrapper -->




<!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
<script src="{{asset('admin/js/vendor/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('admin/js/vendor/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/js/plugins.js')}}"></script>
<script src="{{asset('admin/js/app.js')}}"></script>
<!-- Load and execute javascript code used only in this page -->

{{--<script src="{{asset('admin/js/pages/readyDashboard.js')}}"></script>--}}
{{--<script>$(function(){ ReadyDashboard.init(); });</script>--}}

@yield('script')

</body>
</html>