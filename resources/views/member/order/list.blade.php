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