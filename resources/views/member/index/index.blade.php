@extends('layout.index.index')

@section('content')
  <!--<header data-am-widget="header" class="am-header am-header-default sq-head ">
        <h1 class="am-header-title">
            <a href="" class="">个人中心</a>
        </h1>
    </header>-->
    <!--<div style="height: 49px;"></div>-->
    <div class="member">
        <div class="mem-tit">
            {{$member->username}}
            {{--<a href="javascript:;" class="step"><img src="{{asset('theme/images/step.png')}}" width="26"/></a>--}}
        </div>
        <div class="mem-pic">
            <div class="mem-pic-bg" style="background-image: url(theme/images/memtx.png);"></div>
            <a href="javascript:;" class="men-level">√普通会员</a>
        </div>
        <ul class="member-menu">
            <li>
                <a href="javascript:;">
                    <p class="yellow">{{$member->money / 100}}</p>
                    <p class="black">帐户余额 </p>
                </a>
            </li>

            <li>
                <a href="javascript:;">
                    <p class="yellow">{{$orderCount}}</p>
                    <p class="black">当月订单数</p>
                </a>
            </li>

        </ul>
    </div>
    <div class="user-list">
        <div class="u-list-main">
            <img src="theme/images/order-pic.png" width="27" />
            <span>我的订单</span>
            <a href="{{route('member.order.index')}}">查看全部订单></a>
        </div>
        <ul class="user-nav">
            <li><a href="{{route('member.order.index', ['status'=> 0])}}"> <img src="theme/images/icon_topay.png"> <p>待付款</p></a></li>
            <li><a href="{{route('member.order.index', ['status'=> 4])}}"> <img src="theme/images/icon_send.png"> <p>待审核</p></a></li>
            <li><a href="{{route('member.order.index', ['status'=> 1])}}"> <img src="theme/images/icon_tosend.png"> <p>待发货</p></a></li>
            <li><a href="{{route('member.order.index', ['status'=> 3])}}"> <img src="theme/images/icon_sign.png"> <p>已完成</p></a></li>
        </ul>
        <div class="u-list-main">
            <img src="{{asset('theme/images/order-my.png')}}" width="27" />
            <span>帐户与安全</span>
        </div>
        <ul class="user-nav">
            {{--<li><a href="infor.html"> <img src="theme/images/1-icon4.png"> <p>个人资料</p></a></li>--}}
            <li><a href="{{route('member.address.index')}}"> <img src="{{asset('theme/images/1-icon5.png')}}"> <p>收货地址</p></a></li>
            <li><a href="{{route('member.password.modify')}}"> <img src="{{asset('theme/images/1-icon6.png')}}"> <p>修改密码</p></a></li>
            <li><a href=""> <img src="{{asset('theme/images/1-icon7.png')}}"> <p>我的钱包</p></a></li>
        </ul>
    </div>
    <!--导航-->
    <ul class="sq-nav" style="background:#fff; margin-top:1rem; border-top:1px solid #ddd; border-bottom:1px solid #ddd;">
        {{--  <li>
            <div class="am-gallery-item">
                <a href="myallchips.html" class="">
                    <img src="theme/images/icon4.png" />
                    <p>我的众筹</p>
                </a>
            </div>
        </li>
        <li>
            <div class="am-gallery-item">
                <a href="mywhite.html" class="">
                    <img src="theme/images/icon5.png" />
                    <p>我的白条</p>
                </a>
            </div>
        </li>
        <li>
            <div class="am-gallery-item">
                <a href="memberreserve.html" class="">
                    <img src="theme/images/icon2.png" />
                    <p>我的预定</p>
                </a>
            </div>
        </li>  --}}
        <li>
            <div class="am-gallery-item">
                <a href="{{route('member.logout')}}" class="">
                    <img src="{{asset('theme/images/icon8.png')}}" />
                    <p>安全退出</p>
                </a>
            </div>
        </li>
    </ul>
    @include('index.snippets.nav')

@endsection


