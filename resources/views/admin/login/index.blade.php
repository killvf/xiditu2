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
</head>
<body>


<div id="login-container">
    <!-- Login Header -->
    <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
        <i class="fa fa-cube"></i> <strong>后台管理系统</strong>
    </h1>
    <!-- END Login Header -->

    <!-- Login Block -->
    <div class="block animation-fadeInQuickInv">
        <!-- Login Title -->
        <div class="block-title">

            <h2>请登录</h2>
        </div>
        <!-- END Login Title -->
        <?php

            $staffLoginErr = session('staff_login_err');

        ?>
        @if(!empty($staffLoginErr))
            <div class="alert alert-danger" role="alert">
                {{$staffLoginErr}}
            </div>
        @endif
        <!-- Login Form -->
        <form id="login-form" action="{{route('staff.login')}}" method="post" class="form-horizontal">
            {{csrf_field()}}
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="text" id="username" name="name" class="form-control" placeholder="用户名..">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="password" id="password" name="password" class="form-control" placeholder="密码..">
                </div>
            </div>
            <div class="form-group form-actions">

                <div class="col-xs-12 text-right">
                    <button type="submit" id="login-btn" class="btn btn-effect-ripple btn-sm btn-primary col-xs-12"><i class="fa fa-check"></i>登录</button>
                </div>
            </div>
        </form>
        <!-- END Login Form -->
    </div>
    <!-- END Login Block -->

    <!-- Footer -->
    <footer class="text-muted text-center animation-pullUp">
        {{--<small> &copy; <a href="javascript:;" target="_blank">hq</a></small>--}}
    </footer>
    <!-- END Footer -->
</div>

<!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
<script src="{{asset('admin/js/vendor/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('admin/js/vendor/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/js/plugins.js')}}"></script>
<script src="{{asset('admin/js/app.js')}}"></script>
<!-- Load and execute javascript code used only in this page -->
<script type="text/javascript" src="{{asset('admin/js/jquery.md5.js')}}"></script>
<script src="{{asset('admin/js/pages/readyLogin.js')}}"></script>
<script type="text/javascript">

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        ReadyLogin.init();-
            $('#login-btn').on('click', function () {
                $.ajax({
                    url: '{{route('staff.hmac')}}',
                    type: 'GET',
                    success: function(data){
                        var hmac = data.hmac,
                            username = $('#username').val(),
                            password = $('#password').val();
                        $('#password').val($.md5(hmac+$.md5(username+password)));
                        $('#login-form').submit();
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
                return false;
            });
    });
</script>

</body>
</html>