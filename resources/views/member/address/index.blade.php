@extends('layout.index.index')


@section('content')
<header data-am-widget="header" class="am-header am-header-default sq-head ">
        <div class="am-header-left am-header-nav">
            <a href="{{route('member.index')}}" class="">
                <i class="am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="{{route('member.address.index')}}" class="">管理收货地址</a>
        </h1>
        <div class="am-header-right am-header-nav">
            <a href="{{route('member.address.add', ['from'=>'address'])}}" class="">
                <i class="am-icon-plus"></i>
            </a>
        </div>
    </header>
    <div style="height: 49px;"></div>
    <ul class="address-list">
    @foreach($data as $d)
        <li class="curr">
            <p>收货人：{{$d->name}}&nbsp;&nbsp;{{substr_replace($d->mobile, '****',3, 4)}}</p>
            <p class="order-add1">收货地址：{{$d->province.$d->city.$d->district.' '.$d->detail}}</p>
            <hr />
            <div class="address-cz">
                <label class="am-radio am-warning">
                    <input type="radio" name="radio3" value="" onclick="set_default('{{route('member.address.modify', ['id'=>$d->id])}}')" data-am-ucheck
                    @if($d->default == 1)
                    checked
                    @endif
                    > 设为默认
                </label>
                <a href="{{route('member.address.modify', ['id'=>$d->id])}}"><i class="icon-pencil icon-large"></i>&nbsp;编辑</a>
                <a href="javascript:;" onclick="del_address('{{$d->id}}')"><i class="icon-trash icon-large"></i>&nbsp;删除</a>
            </div>
        </li>
        @endforeach
    </ul>

@endsection


@section('script')
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
        /**
         * 设为默认地址
         * @param id
         */
        function set_default(url) {
            $.ajax({
               url: url,
               type: "POST",
               dataType: "json",
               data: {default: 1,agent_user_id: '{{session('member')->id}}'},
               success: function(data) {
                   if(data.status) {
                       console.log(data);
                   }
               },
                error: function(e) {
                   console.log(e);
                }
            });
        }

        /**
         * 删除地址
         * @param id
         */
        function del_address(id) {
            var target = event.currentTarget;
            if(window.confirm('你确定要删除地址吗')) {
                $.ajax( {
                    url: "{{route('member.address.delete')}}",
                    type: "GET",
                    dataType: "json",
                    data: {id: id},
                    success: function(data) {
                        if(data.status) {

                            $(target).parents('li').remove();
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }
                })
            }
        }
    </script>
@endsection