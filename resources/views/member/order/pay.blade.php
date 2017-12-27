@extends('layout.index.index')

@section('style')
    <style>

        .am-ucheck-checkbox:checked+.am-ucheck-icons, .am-ucheck-checkbox:hover:not(.am-nohover):not(:disabled)+.am-ucheck-icons, .am-ucheck-radio:checked+.am-ucheck-icons, .am-ucheck-radio:hover:not(.am-nohover):not(:disabled)+.am-ucheck-icons{
            color:red;
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
            <a href="javascript:;" class="">完成支付</a>
        </h1>
    </header>
    <div style="height: 49px;"></div>
    <ul class="order-subtitle">
        <li><span>订单编号：</span>{{$order->order_code}}</li>
        <li><span>支付金额：</span><span class="order-money">￥{{$order->pay_amount / 100}}</span></li>
    </ul>
    <ul class="order-pay">
        {{--<li>--}}
            {{--<img src="theme/images/alipay.png" width="50" />--}}
            {{--<span>--}}
                {{--<p>支付宝</p>--}}
                {{--<p class="descript">推荐有支付宝账号的用户使用</p>--}}
            {{--</span>--}}
            {{--<label class="am-radio-inline">--}}
                {{--<input type="radio" checked="checked" name="radio10" value="1" data-am-ucheck>--}}
            {{--</label>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<img src="theme/images/wechatpay.jpg" width="50" />--}}
            {{--<span>--}}
                {{--<p>微信支付</p>--}}
                {{--<p class="descript">推荐安装微信5.0及以上版本的使用</p>--}}
            {{--</span>--}}
            {{--<label class="am-radio-inline">--}}
                {{--<input type="radio" name="radio10" value="1" data-am-ucheck>--}}
            {{--</label>--}}
        {{--</li>--}}
        <li>
            <img src="{{asset('theme/images/yuepay.jpg')}}" width="50" />
            <span>
                <p>账户余额({{$amount / 100}})</p>
                <p class="descript">账户余额支付</p>
            </span>
            <label class="am-radio-inline">
                <input type="radio" name="type" checked="checked" value="{{\App\Models\AgentOrderForm::TYPE_MONEY}}" data-am-ucheck>
            </label>
        </li>
        <li>
            <img src="{{asset('theme/images/yuepay.jpg')}}" width="50" />
            <span>
                <p>线下支付</p>
                <p class="descript">账户线下支付</p>
            </span>
            <label class="am-radio-inline">
                <input type="radio" name="type" value="{{\App\Models\AgentOrderForm::TYPE_LOCAL}}" data-am-ucheck>
            </label>
        </li>

    </ul>

    <div class="order-detail">
        请您在提交订单后24小时内完成付款，否则订单将自动取消
    </div>
    <div style="height: 40px;"></div>

    <input type="button" class="login-btn" data-canorder="{{$product}}" data-disabled="{{$amount < $order->pay_amount ? 1: 0}}" value="确认支付" style="">

@endsection


@section('script')
    <script src="{{asset('theme/js/jquery.cookie.js')}}"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            });
            var payObj = {
                pid: '{{$order->id}}',
                type: '{{\App\Models\AgentOrderForm::TYPE_MONEY}}',
                canSubmit: '{{$product == 0 ? 0 : ($product > 0 ? ($amount < $order->pay_amount ? 0 : 1) : 0)}}',
                msg: ''
            };


            $('input[name="type"]').on('change',function() {
                //如果有次数再说下面的事
                if(parseInt($('.login-btn').data('canorder')) > 0) {
                    if($(this).val() == '{{\App\Models\AgentOrderForm::TYPE_LOCAL}}') {
                        $('.login-btn').attr('disabled', false);
                        payObj.canSubmit = 1;
                    } else {
                        $('.login-btn').attr('disabled', $('.login-btn').data('disabled') ? 'disabled': false);
                        payObj.canSubmit = parseInt(!$('.login-btn').data('disabled'));
                    }
                }
                //设置支付类型
                payObj.type = $(this).val();
            });

            $('.login-btn').on('click', function() {
                if(payObj.canSubmit > 0) {
                    $.ajax({
                        url: '{{route('member.order.pay', ['pid' => $order->id])}}',
                        type: 'POST',
                        dataType: 'json',
                        data: payObj,
                        success: function(data) {
                            if(data.status == 1) {
                               
                                var buyItems = $.cookie('buyItems'),
                                    shopcarts = $.cookie('shopcart');
                                if(buyItems && shopcarts) {
                                    buyItems = JSON.parse(buyItems);
                                    shopcarts = JSON.parse(shopcarts);
                                    for(item in shopcarts) {
                                        if(buyItems[item]) {
                                            delete shopcarts[item];
                                        }
                                    }
                                    $.cookie('buyItems', '', {path: '/'});
                                    $.cookie('shopcart', JSON.stringify(shopcarts), {path : '/'});
                                }

                                layer.alert('支付成功', {
                                    icon: 1,
                                    skin: 'layer-ext-moon' 
                                }, function(){
                                   location.href = '{{route('member.order.index')}}';
                                });
                            }
                        },
                        error: function(e){
                            console.log(e);
                        }
                    });
                } else {
                    //判断支付类型
                    @if($product == 0)
                    payObj.msg = '平台订单数不足';
                    @else
                    if(payObj.type == {{\App\Models\AgentOrderForm::TYPE_MONEY}}) {
                        payObj.msg = '余额不足';
                    } else {
                        payObj.msg = '平台订单数不足';
                    }
                    @endif
                    layer.alert(payObj.msg, {
                        icon: 1,
                        skin: 'layer-ext-moon' 
                    });
                }

            });

        });
    </script>

    @endsection