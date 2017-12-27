@extends('layout.index.index')

@section('content')
    <header data-am-widget="header" class="am-header am-header-default sq-head ">
        <div class="am-header-left am-header-nav">
            <a href="javascript:history.back()" class="">
                <i class="am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="" class="">管理收货地址</a>
        </h1>
        <div class="am-header-right am-header-nav">
            <a href="{{route('member.address.add')}}" class="">
                <i class="am-icon-plus"></i>
            </a>
        </div>
    </header>
    <div style="height: 49px;"></div>
    <ul class="address-list">
        @foreach($addresses as $address)

        <li @if(session('address_id') == $address->id)class="curr"@endif onclick="window.location.href='{{route('member.address.choose', ['id'=>$address->id])}}'">
            <p>收货人：{{$address->name}}&nbsp;&nbsp;{{substr_replace($address->mobile, '****', 3,4)}}</p>
            <p class="order-add1">收货地址：@if($address->default == 1)
                    <span style="color:#d70b1c;">[默认地址]</span>
                    @endif
                {{$address->province.$address->city.$address->district.' '.$address->detail}}</p>
        </li>
        @endforeach
    </ul>

@endsection


