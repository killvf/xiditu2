<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <title>喜地控股</title>

    <meta name="renderer" content="webkit" />
    <meta http-equiv="Cache-Control" content="no-siteapp,no-transform" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta name="baidu-site-verification" content="CuO2DGTNex" />
    <meta name="keywords" content="喜地控股" />
    <meta name="description" content="喜地控股" />
    <!-- Common styles and scripts -->
    <!-- <link rel="shortcut icon" href="favicon.ico" /> -->
    <script type="text/javascript" src="{{asset('resource/js/require.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('resource/css/base.css')}}" />

    <link rel="stylesheet" type="text/css" href="{{asset('resource/css/jquery.fullPage.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('resource/css/animate.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('resource/css/mestion.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('resource/css/style.css')}}" />
</head>

<body>

@include('index.snippets.header')
<div class="hearder-wrap opacity heard-fixed">

@include('layout.index.common.nav')
    <div class="sub-nav-wrap">
        <div class="wrap-1200 sub-nav">
            @foreach($subNavs as $subNav)
            <a href="{{$subNav->link}}" >{{$subNav->title}}</a>
            @endforeach
        </div>
    </div>

</div>

@yield('content')

@include('layout.index.common.script')
</body>

</html>