@extends('layout.index.index')
@section('content')
    <header data-am-widget="header" class="am-header am-header-default sq-head ">
        <div class="am-header-left am-header-nav">
            <a href="{{url('/')}}" class="">
                <i class="am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="" class="">登录</a>
        </h1>
    </header>
    <div style="height: 49px;"></div>
    <!--<div class="login-logo">
        <img src="images/logo.png" />
    </div>-->
    <div style="height: 3rem;"></div>
    <form action="{{route('member.login')}}" id="login-form" method="POST">
    {{csrf_field()}}
        <input type="text" name="name" id="username" placeholder="请输入用户名" class="login-name">
        <input type="password" name="password" id="password" placeholder="请输入密码" class="login-password">
        <input type="button" class="login-btn" value="我要登录">
    </form>
    {{--  <div class="agree">
        <a href="reg.html" class="forget-left">免费注册</a>
        <a href="forgetpassword.html" class="forget">忘记密码？</a>
    </div>  --}}
    <?php
        $error = session('member_login_err');
    ?>
    @if(!empty($error))
            <div class="am-alert am-alert-danger">
                {{$error}}
            </div>
        @endif
@endsection

@section('script')
<script type="text/javascript" src="{{asset('admin/js/jquery.md5.js')}}"></script>
<script>

     $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

   
            $('.login-btn').on('click', function () {
                $.ajax({
                    url: '{{route('member.hmac')}}',
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
@endsection