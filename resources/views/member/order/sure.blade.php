@extends('layout.index.index')


@section('content')

<header data-am-widget="header" class="am-header am-header-default sq-head ">
        <div class="am-header-left am-header-nav">
            <a href="javascript:history.back()" class="">
                <i class="am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="" class="">确认订单</a>
        </h1>
    </header>
    <div style="height: 49px;"></div>
    <h5 class="order-tit">收货人信息</h5>
    @if(!empty($address))
    <div class="order-name">
        <a href="{{route('member.address.choose')}}">
            <p class="order-tele">{{$address->name}}&nbsp;&nbsp;&nbsp;{{$address->mobile}}</p>
            <p class="order-add">{{$address->province.$address->city.$address->district.' '.$address->detail}}</p>
        </a>
        <i class="am-icon-angle-right"></i>
    </div>
    @else
    <div class="add-address">
        <a href="{{route('member.address.add')}}">+新建收货地址</a>
        <i class="am-icon-angle-right"></i>
    </div>
    @endif
    <div style="background: #eee; height: 10px;"></div>
    <h5 class="order-tit">确认订单信息</h5>
    <ul class="shopcart-list" style="padding-bottom: 0;">
    @foreach($goods as $g)
        <li>
            <img src="{{asset(empty($g->pictures) ? '': $g->pictures[0]->url)}}" class="shop-pic" />
            <div class="order-mid">
                <div class="tit">{{$g->name. ' '. $g->title}}</div>
                <div class="order-price">￥{{$g->unit_price / 100}} <i>X {{$g->amount}}</i></div>
            </div>
        </li>
        @endforeach
    </ul>
    <ul class="order-infor">
        <li class="order-infor-first">
            <span>商品总计：</span>
            <i>￥{{$sum}}</i>
        </li>
        <li class="order-infor-first">
            <span>运费：</span>
            <i>+ ￥0.00</i>
        </li>
    </ul>
    <div style="background: #eee; height: 10px;"></div>
    <textarea placeholder="备注说明" class="bz-infor"></textarea>
    <div style="background: #eee; height: 10px;"></div>
    <div style="height: 55px;"></div>
    <div class="shop-shoporder">
        <div class="order-text">
            实付：<span>￥{{$sum}}</span>
        </div>
        <a href="javascript:;" data-href="{{route('member.order.pay')}}" class="js-btn">提交订单</a>
    </div>

@endsection

@section('script')

    <script>
        $(function() {
            $('.js-btn').on('click', function() {
                
                var remark = $('.bz-infor').val();
                location.href = $(this).data('href') + '?remark=' + remark;
       
            });
        });
    </script>

    @endsection