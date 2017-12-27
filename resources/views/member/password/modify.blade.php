@extends('layout.index.index')

@section('content')
<header data-am-widget="header" class="am-header am-header-default sq-head ">
        <div class="am-header-left am-header-nav">
            <a href="{{route("member.index")}}" class="">
                <i class="am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="{{route('member.password.modify')}}" class="">修改密码</a>
        </h1>
    </header>
    <div style="height: 49px;"></div>
    <form method="POST" action="{{route('member.password.modify')}}">
    {{csrf_field()}}
    <input type="password" name="old_password" placeholder="请输入旧密码" class="login-password">
    <input type="password" name="password" placeholder="请输入密码" class="login-password">
    <input type="password" name="confirm_password" placeholder="确认密码" class="login-password">
    <input type="submit" class="login-btn" value="立即提交">
    </form>
@endsection