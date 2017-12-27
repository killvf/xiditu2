@extends('layout.index.index')


@section('content')

 <!--图片轮换-->
    <div class="am-slider am-slider-default" data-am-flexslider id="demo-slider-0" style="position: relative;">
        <header data-am-widget="header" class="am-header am-header-default tm-head" id="shortbar">
            {{--  <div class="am-header-title1">
                <div class="search-box">
                    <input type="text" name="title" class="index-search" placeholder="寻找你喜欢的商品......" />
                </div>
            </div>  --}}
            {{--  <div class="am-header-right am-header-nav">
                <a href="" class="" style="padding-top: 10px;">
                    <img src="{{asset('theme/images/search.png')}}" />
                </a>
            </div>  --}}
        </header>
        <ul class="am-slides">
            <li><img src="{{asset('theme/images/banner1.png')}}" /></li>
            <li><img src="{{asset('theme/images/banner.png')}}" /></li>
        </ul>
    </div>
    <ul class="shopcart-list">
        @foreach($goods as $g)
        <li onclick="location.href='{{route('index.goods.detail', ['id'=>$g->id])}}'">
            
            <a href="{{route('index.goods.detail', ['id'=>$g->id])}}"><img src="{{empty($g->pictures) ? '': $g->pictures[0]->url}}" class="shop-pic"></a>
            
            <div class="shop-list-mid">
                <div class="tit">
                    <a href="{{route('index.goods.detail', ['id'=>$g->id])}}">{{$g->name .' '. $g->title}}</a>
                   <span class="span-price">￥{{$g->unit_price / 100}}</span> 
                </div>
            </div>
            
            <div class="cart">
          
            <a href="javascript:;" class="am-icon-shopping-cart" onclick="add_to_cart('{{$g->id}}')"></a></div>
        </li>
        @endforeach
    </ul>
    <!--底部-->
    <div style="height: 55px;"></div>
    @include('index.snippets.nav')

@endsection


@section('script')
<script src="{{asset('theme/js/time.js')}}"></script>
<script src="{{asset('theme/js/jquery.cookie.js')}}"></script>
    <script>
        $(function () {
            var elm = $('#shortbar');
            var startPos = $(elm).offset().top;
            $.event.add(window, "scroll", function () {
                var p = $(window).scrollTop();
                if (p > startPos) {
                    elm.addClass('sortbar-fixed');
                } else {
                    elm.removeClass('sortbar-fixed');
                }
            });
        });

        //添加到购物车
        function add_to_cart(id) {
            event.preventDefault();
            event.stopPropagation();
            var key ='shopcart',
                shopcart_key = 'shopcart_num',
                ids = $.cookie(key),
                shopcartNum = $.cookie(shopcart_key);
        
            if(ids) {
                ids = JSON.parse(ids);
            } else {
                ids = {};
            }
            //判断 是否已经添加过
            if(ids.hasOwnProperty(id)) {
                ids[id] += 1;
            } else {
                ids[id] = 1;
            }

            if(shopcartNum) {
                shopcartNum = parseInt(shopcartNum) + 1;
            } else {
                shopcartNum = 1;
            }
            layer.msg('添加购物车成功');
            $.cookie(shopcart_key, shopcartNum, {path: '/'});
            $.cookie(key, JSON.stringify(ids), {path: '/'});
            return false;
        }

    </script>
@endsection