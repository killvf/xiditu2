@extends('layout.index.index')

@section('content')

<header data-am-widget="header" class="am-header am-header-default sq-head ">
        <div class="am-header-left am-header-nav">
            <a href="{{route('member.index')}}" class="">
                <i class="am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="{{route('member.order.index')}}" class="">全部订单</a>
        </h1>
    </header>
    <div style="height: 49px;"></div>

    <ul class="order-style">
        <li @if(!isset($_GET['status']))
            class="current"
            @endif><a href="{{route('member.order.index')}}">全部</a></li>
        <li @if(isset($_GET['status']) && $_GET['status'] == 0)
            class="current"
            @endif
        ><a href="{{route('member.order.index', ['status'=> 0])}}">待付款</a></li>

        <li @if(isset($_GET['status']) && $_GET['status'] == 4)
                        class="current"
                        @endif><a href="{{route('member.order.index', ['status'=> 4])}}">待审核</a></li>

        <li @if(isset($_GET['status']) && $_GET['status'] == 1)
                        class="current"
                        @endif><a href="{{route('member.order.index', ['status'=> 1])}}">待发货</a></li>
        
        <li @if(isset($_GET['status']) && $_GET['status'] == 3)
                        class="current"
                        @endif><a href="{{route('member.order.index', ['status'=> 3])}}">已完成</a></li>
    </ul>
    <!--代付款-->
    <div class="order-box">
    @foreach($orders as $order)
    <a href="" style="color: #000;">
        <div class="c-comment">
            <span class="c-comment-num">订单编号：{{$order->order_code}}</span>
            <span class="c-comment-suc">
                @if($order->status == \App\Models\AgentOrderForm::STATUS_NOT_PAY)
                    未付款
                @elseif($order->status == \App\Models\AgentOrderForm::STATUS_WATI_CHECK)
                    待审核
                @elseif($order->status == \App\Models\AgentOrderForm::STATUS_WAIT_POST)
                    待发货   
                @elseif($order->status == \App\Models\AgentOrderForm::STATUS_FINISHED)
                    已完成
                @else
                    已取消
                @endif
            </span>
        </div>

        <div class="c-comment-list" style="border: 0;">
            @if(!empty($order->orders))
        @foreach($order->orders as $g)
            <div class="o-con">
                <div class="o-con-img">
                    <img src="{{empty($g->picture) ? '': asset($g->picture)}}">
                </div>
                <div class="o-con-txt">
                    <p>{{$g->goods_name}}</p>
                    <span class="price-t">￥{{$g->unit_price/100}}</span>
                </div>
                <div class="o-con-much"> <h4>x{{$g->goods_amount}}</h4></div>
            </div>
            @endforeach
            @endif
            <div class="c-com-money">共{{$order->goods_amount}}个商品 实付金额：<span>￥ {{$order->order_sum/100}}</span></div>
        </div>
    </a>
    <div class="c-com-btn">
        @if($order->status == \App\Models\AgentOrderForm::STATUS_NOT_PAY)
            <a class="pay" href="{{route('member.order.pay', ['pid' => $order->id])}}">立即支付</a>
            <a class="other cancel" href="javascript:;" data-href="{{route('member.order.cancel', ['id' => $order->id])}}">取消订单</a>
            <a class="other payed" href="javascript:;" data-href="{{route('member.order.payed', ['id' => $order->id])}}">已支付</a>
        @endif

    </div>
    <div class="clear"></div>
    @endforeach
    </div>

@endsection

@section('script')

    <script>
        $(function() {
            /**
             * 取消订单
             */
            $('.cancel').on('click', function() {
 var href = $(this).data('href');
                layer.confirm('你确定要取消订单吗？', {
                    btn: ['确定','取消']
                }, function(){
                    location.href = href;
                }, function(){
            
                });
               
            });

            /**
             * 确认收货
             */
            $('.receive').on('click', function() {
     var href = $(this).data('href');
                layer.confirm('你确定要确认收货吗', {
                    btn: ['确定','取消']
                }, function(){
                    location.href =href;
                }, function(){
            
                });
            });

            $('.payed').on('click', function() {
                var href = $(this).data('href');
                layer.confirm('你确定已经支付了吗', {
                    btn: ['确定','取消']
                }, function(){
                    location.href = href;
                }, function(){
            
                });
            });
            
            @if(empty($_GET['page']))
            var p=1,params='{{http_build_query($_GET)}}';
            @else
            <?php 
                unset($_GET['page']);
            ?>
            var p = '{{$_GET['page']}}',params="{{http_build_query($_GET)}}";
            @endif
            var stop=true;//触发开关，防止多次调用事件  
            $(window).scroll(function() {    
                //当内容滚动到底部时加载新的内容 100当距离最底部100个像素时开始加载.  
                if ($(this).scrollTop() + $(window).height() + 100 >= $(document).height() && $(this).scrollTop() > 100) {    
                    if(stop==true){  
                        stop=false;  
                        p=parseInt(p)+1;//当前要加载的页码    
                        if($.trim(params) == '') {
                            new_params = '?page='+p;
                        } else {
                            new_params = '?'+params + '&page='+p;
                        }
                        var loading = layer.load(1, {
                            shade: [0.1,'#fff'] //0.1透明度的白色背景
                        });
                        $.get("{{route('member.order.index')}}"+new_params,function(data){                            
                            if($.trim(data.data.html) != '') {
                                $(".order-box").append(data.data.html);
                                stop=true;
                            }
                                layer.close(loading);  
                        });
                    }  
                }    
            });  


        });
    </script>

    @endsection