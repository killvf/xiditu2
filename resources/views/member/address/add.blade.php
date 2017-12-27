@extends('layout.index.index')
@section('style')
<style>
	.xg_select01{float: left;
    width: 20%;
    height: 34px;
    margin-top: 8px;
    margin-left: 10px;
    border: 1px solid #D2D2D2;
    border-radius: 4px;
    font-size: 1.4rem;
    color: #666;
    overflow: hidden;
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
            <a href="" class="">新增收货地址</a>
        </h1>
    </header>
    <div style="height: 49px;"></div>
    <form action="{{route('member.address.add.do')}}" id="addr_form" method="POST">
    @include('member.address.form')
    </form>
    @if(!empty($errors->all()))
        @foreach($errors->all() as $message)
            <div class="am-alert am-alert-danger">
                {{$message}}
            </div>
            @endforeach
        @endif

@endsection

@section('script')

    <script src="{{asset('theme/js/distpicker.data.js')}}"></script>
    <script src="{{asset('theme/js/distpicker.js')}}"></script>
    <script>

        $(function() {
            $("#distpicker").distpicker({
                province: "---- 所在省 ----",
                city: "---- 所在市 ----",
                district: "其它"
            });

            $('#addr_form').on('submit', function() {

            });
        });

    </script>

@endsection