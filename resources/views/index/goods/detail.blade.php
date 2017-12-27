@extends('layout.index.index')

@section('style')
<style>
    .am-slider-default .am-control-nav {
        text-align: center;
    }

        .am-slider-default .am-control-nav li a.am-active {
            background: #fdb325;
        }

        .am-slider-default .am-control-nav li a {
            border: 0;
            width: 10px;
            height: 10px;
        }
</style>

@endsection


@section('content')
<header data-am-widget="header" class="am-header am-header-default sq-head ">
        <div class="am-header-left am-header-nav">
            <a href="javascript:history.back()" class="">
                <i class="am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="" class="">商品详情</a>
        </h1>
    </header>
    <div style="height: 49px;"></div>
    <!--图片轮换-->
    <div class="am-slider am-slider-default" data-am-flexslider id="demo-slider-0">
        <ul class="am-slides">
        @foreach($goods->pictures as $p)
            <li><img src="{{asset($p->url)}}" /></li>
        @endforeach
        </ul>
    </div>
    <div class="detal-info">
        <p>{{$goods->name.' '.$goods->title}}</p>
        <h2><span>￥{{$goods->unit_price/ 100}}</span></h2>
    </div>
    <div class="d-amount">
        <h4>数量：</h4>
        <div class="d-stock">
            <a class="decrease">-</a>
            <input id="num" readonly="" class="text_box" name="" type="text" value="1">
            <input id="id" type="hidden" value="{{$goods->id}}">
            <a class="increase">+</a>
            <span id="dprice" class="price" style="display:none"> {{$goods->unit_price / 100}}</span>
        </div>
    </div>
    <div style="background: #eee; height: 10px;"></div>
    <div class="am-tabs detail-list" data-am-tabs>
        <ul class="am-tabs-nav am-nav am-nav-tabs">
            <li class="am-active"><a href="#tab1">商品详情</a></li>
        </ul>

        <div class="am-tabs-bd">
            <div class="am-tab-panel am-fade am-in am-active detail " id="tab1">
                {!! $goods->description !!}
            </div>
        </div>
    </div>

<div style="height:55px;"></div>

    <ul class="fix-shopping">
        <li><a href="{{route('member.cart.index')}}"><span class="icon-shopping-cart icon-2x"><i id='shopcart-count'>0</i></span></a></li>
        <li><a href="javascript:;" class="join a-button">加入购物车</a></li>
        <li><a href="javascript:;" data-url="{{route('member.order.sure')}}" class="imm-buy a-button">立即购买</a></li>
    </ul>

@endsection

@section('script')
<script src="{{asset('theme/js/jquery.cookie.js')}}"></script>
    <script>
    var detailObj= {
        'num': 1,
        'id' : '{{$goods->id}}',
        'price' : '{{$goods->unit_price/100}}'
    };
    $(function(){
        //页面加载完成后修改购物车数量
        $("#shopcart-count").text(recalc_shopcart_count());


        //添加个数
		$('.increase').on('click',function(){
			detailObj.num++;
            update_item();
		})

        //减少个数
		$('.decrease').on('click',function(){
			detailObj.num--;
            detailObj.num = Math.max(detailObj.num, 1);
            update_item();
		});

        $('#num').on('change', function() {
            var num = $('#num').val();
            if(!isNaN(num)){
                detailObj.num = parseInt(detailObj.num);
            }
            update_item();
        });

        function update_item() {
            //更新个数
            $('#num').val(detailObj.num);
        }

        //添加到购物车
        $('.join').on('click', function() {
            var key='shopcart',shopcartNumKey='shopcart_num',shopcartNum = $.cookie(shopcartNumKey),shopcart = $.cookie(key),count,detailId =detailObj.id;
            if(shopcart) {
                shopcart = JSON.parse(shopcart);
                if(shopcart.hasOwnProperty(detailId)) {
                    shopcart[detailId] += detailObj.num;
                } else {
                    shopcart[detailId] = detailObj.num;
                }
            } else {
                shopcart = {};
                shopcart[detailId] = detailObj.num;
            }
            if(shopcartNum) {
                shopcartNum = parseInt(shopcartNum) + detailObj.num;
            } else {
                shopcartNum = detailObj.num;
            }

            //回写cookie
            $.cookie(shopcartNumKey, shopcartNum, {path:'/'});
            $.cookie(key, JSON.stringify(shopcart), {path:'/'});
            count = recalc_shopcart_count();
            //修改购物车数量
            $('#shopcart-count').text(count);
            location.href = '{{route('member.cart.index')}}';
        });

        /**
         * 跳转到确认支付页面
         */
        $('.imm-buy').on('click', function() {
            var url = $(this).data('url'),
                new_url = url+ '?id='+detailObj.id+'&num='+detailObj.num;
            window.location.href= new_url;
        });
	})
    </script>
@endsection