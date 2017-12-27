@extends('layout.index.index')


@section('content')
<header data-am-widget="header" class="am-header am-header-default sq-head ">
        <div class="am-header-left am-header-nav">
            <a href="javascript:history.back()" class="">
                <i class="am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="{{route('member.cart.index')}}" class="">购物车</a>
        </h1>
    </header>
    <div style="height: 49px;"></div>
    @if(empty($goods[0]))
    <!--购物车空的状态-->
    <div class="login-logo">
        <img src="{{asset('theme/images/logo.png')}}">
        <p>亲、您的购物车还是空空的哦，快去装满它!</p>
        <a href="{{url('/')}}" class="goshopping">前去逛逛</a>
    </div>
    @else
    <ul class="shopcart-list">
    <?php 
        $goodsData = [];
    ?>
    @foreach($goods as $g)
     <?php 
            $goodsData[$g->id] = [
                'id' => $g->id,
                'unit_price' => $g->unit_price,
                'amount' => $g->amount,
                'checked' => true,
            ];
        ?>
        <li data-id='{{$g->id}}' data-data='{{json_encode($goodsData[$g->id])}}'>
            <label class="am-checkbox am-warning">
                <input type="checkbox" class='item-check' checked="checked" value="" data-am-ucheck >
            </label>
            <a href="{{route('index.goods.detail', ['id'=>$g->id])}}">
                <img src="{{empty($g->pictures) ? '':asset($g->pictures[0]->url)}}" class="shop-pic" />
            </a>
            <div class="shop-list-mid">
                <div class="tit">
                    <a href="{{route('index.goods.detail', ['id'=>$g->id])}}">{{$g->name .' '. $g->title}}</a>
                </div>
                <div class="d-stock">
                    <a class="decrease">-</a>
                    <input readonly="" class="text_box num" name="" type="text" value="{{$g->amount}}">
                    <a class="increase">+</a>
                </div>
            </div>
            <b class="shop-list-price">￥{{$g->unit_price * $g->amount / 100}} </b>
            <div class="del"><i class="am-icon-trash"></i></div>
        </li>
       
    @endforeach
       
    </ul>
        <div style="height: 60px; background: #eee;"></div>
    <div class="shop-fix">
        <label class="am-checkbox am-warning">
            <input type="checkbox" id="select-all" checked="checked" value="" data-am-ucheck >
        </label>
        <a class="del select-all">全选</a>
        <a href="javascript:;" data-url="{{route('member.order.sure', ['type'=> 'shopcart'])}}" class="js-btn pay-order">去结算</a>
        <div class="js-text">
            <P>合计：￥<b id='cart-sum'>{{$sum}}</b></P>
            <p class="js-car">免费配送</p>
        </div>
    </div>

    @endif

    <!--底部-->
    
    @include('index.snippets.nav')
@endsection


@section('script')

<script src="{{asset('theme/js/jquery.cookie.js')}}"></script>

<script>

    

//购物数量加减
	$(function(){
        var cartObj = {
            'sum':{{$sum}},
            'goods':{!! empty($goodsData) ? json_encode(new \StdClass()) : json_encode($goodsData); !!}
        };

        //一进来就重新对页面进行一次重载
        update_item();

        //增加数量
		$('.increase').on('click', function(){
            var id = $(this).parents('li').data('id');
            cartObj.goods[id].amount++;
			update_item();
		});

        //减少数量
		$('.decrease').on('click', function(){
			 var id = $(this).parents('li').data('id');
            cartObj.goods[id].amount = Math.max(1, --cartObj.goods[id].amount);
            console.log(cartObj.goods[id].amount);
			update_item();
		});

        //修改状态
        $(".item-check").on('change', function() {
            var id = $(this).parents('li').data('id');
            cartObj.goods[id].checked = $(this).prop('checked');
            if(!$(this).prop('checked')) {
                //如果有一个没有选中的话就把全选的选中去掉
                $('#select-all').prop('checked', false);
            }
            //判断是否都选中了，如果选中了就把全选勾上
            var allChecked = true;
            $('.item-check').each(function() {
                allChecked = $(this).prop('checked');
                console.log(allChecked);
                if(!allChecked) {
                    return false;
                }
            });
            if(allChecked){
                console.log('in');
                $('#select-all').prop('checked', true);
            }

            update_item();
        });

        //删除购物车指定商品
        $('div.del').on('click', function() {
            if(window.confirm('你确定要删除这个商品吗?')){
                var id = $(this).parents('li').data('id');

                delete cartObj.goods[id];
                //去掉页面上对应的html
                $(this).parents('li').remove();

                //如果页面中一个li都没有了就重载页面
                if($('ul.shopcart-list li').length == 0) {
                    location.reload();
                }
                update_item();

            }
        });

        //更新界面
        function update_item() {
            //遍历所有li,把对应的值放到对应的位置
            var sum = 0, cookieData={};
            $('.shopcart-list > li').each(function() {
                var id = $(this).data('id');
                $(this).find('.num').val(cartObj.goods[id].amount);
                if(cartObj.goods[id].checked) {
                    sum += cartObj.goods[id].amount * cartObj.goods[id].unit_price;
                }
            });
            cartObj.sum = (sum/100).toFixed(2);
            $('#cart-sum').text(cartObj.sum);
            //如果sum为0则把全选去掉
//            $('#select-all').prop('checked', false);
            //修改后更新cookie值
            for(item in cartObj.goods){
                cookieData[item] = cartObj.goods[item].amount;
            }
            $.cookie('shopcart', JSON.stringify(cookieData), {path: '/' });

//            if(cartObj.sum == 0) {
//                $('.pay-order').attr('href', 'javascript:;');
//            } else {
//                $('.pay-order').attr('href', $('.pay-order').data('url'));
//            }
        }

        $('#select-all').on('change', function() {
            //判断当前选择按钮是否选中
            if($(this).prop('checked')) {
                //全选
                $('.item-check').prop('checked', true);
                for(item in cartObj.goods){
                                    //@todo:全部设置为取消
                    cartObj.goods[item].checked = true;
                }
            } else {
                //取消全选
                $('.item-check').prop('checked', false);
                for(item in cartObj.goods){
                    //@todo:全部设置为取消
                    cartObj.goods[item].checked = false;
                }
            }
            update_item();
        });

        /**
         * 前往购买
         */
        $('.pay-order').on('click', function() {
            //把当前可以购买的物品写入到Cookie中
            var buyItem = {};
            for(item in cartObj.goods){
                if(cartObj.goods[item].checked) {
                    buyItem[item] = cartObj.goods[item].amount;
                }
            }
            if(Object.getOwnPropertyNames(buyItem).length > 0) {
                $.cookie('buyItems', JSON.stringify(buyItem));
                location.href = $(this).data('url');
            } else {
                layer.alert('你还没有选中任何商品', {
                    icon: 1,
                        skin: 'layer-ext-moon' 
                });
            }
        });

	});

</script>

@endsection