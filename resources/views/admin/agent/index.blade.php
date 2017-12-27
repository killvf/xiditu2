@extends('layout.admin.layout')
@section('content')

    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>管理</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>代理商管理</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- Table Styles Block -->
    <div class="block">
        <!-- Table Styles Title -->
        <div class="block-title clearfix">
            <!-- Changing classes functionality initialized in js/pages/tablesGeneral.js -->
            <div class="block-options pull-right">
                <a href="{{route('staff.agent.add')}}" class="btn btn-effect-ripple btn-primary">添加</a>
            </div>
            <h2><span >代理商列表</span></h2>
        </div>
        <!-- Table Styles Content -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-vcenter">
                <thead>
                <tr>
                    <th class="hidden-sm hidden-xs">id</th>
                    <th class="hidden-sm ">代理商编码</th>
                    <th class="hidden-sm ">代理商账号</th>
                    <th class="hidden-sm ">余额(元)</th>
                    <th class="hidden-sm ">手机号</th>
                    <th class="hidden-sm hidden-xs" >状态</th>
                    {{--  <th class="hidden-sm hidden-xs" >是否合伙人</th>  --}}
                    <th style="width: 120px;" class="text-center"><i class="fa fa-flash"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $goods)
                    <tr>
                        <td class="hidden-sm hidden-xs">
                            <a href="javascript:void(0)" class="label label-warning">{{$goods->id}}</a></td>
                        <td class="hidden-sm">{{$goods->agent_code}}</td>
                        <td class="hidden-sm hidden-xs">{{$goods->username}}</td>
                        <td class="hidden-sm hidden-xs">{{$goods->money / 100}}</td>
                        <td class="hidden-sm hidden-xs">{{$goods->mobile}}</td>
                        <td class="hidden-sm hidden-xs">{{$goods->status == 1 ? '正常' : '禁用'}}</td>
                        {{--  <td class="hidden-sm hidden-xs">{{$goods->is_partner}}</td>  --}}
                        <td class="text-center">
                            <a href="javascript:;" data-toggle="tooltip" title="充值" onclick='charge_money("{{$goods->id}}")'
                               class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-flash"></i></a>
                            {{--  <a href="javascript:;" data-toggle="tooltip" title="充订单" onclick='charge_order("{{$goods->id}}")'
                               class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-flash"></i></a>  --}}
                            <a href="{{route('staff.agent.modify', ['id'=>$goods->id])}}" data-toggle="tooltip" title="修改"
                               class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:;" data-toggle="tooltip" onclick='removeItem("{{$goods->id}}")'
                               title="删除"
                               class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$data->links()}}
        </div>
        <!-- END Table Styles Content -->
    </div>
    <!-- END Table Styles Block -->

@endsection

@section('script')
    <script>


$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
});

    //删除指定记录
    function removeItem(id) {
        var target = event.currentTarget;
        if(window.confirm('你确定要删除这条记录吗')) {
            $.ajax({
                url: "{{route('staff.agent.delete')}}",
                type: 'POST',
                data: {id: id},
                success: function(data) {
                    if(data.status) {
                        $(target).parents('tr').remove();
                    }
                }, 
                error: function(e) {
                    console.log(e)
                }
            });
        }
    }

    //给用户充值
    function charge_money(id) {
        var money = window.prompt('请输入你要充值的金额(单位元)');
        if(money) {
            $.ajax({
                'url': "{{route('staff.agent.charge')}}",
                'type': 'POST',
                data: {id: id, price: money},
                'dataType': 'json',
                success: function(data) {
                    if(data.status) {
                        window.location.reload();
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    }

    /**
     * 给用户充订单次数
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    function charge_order(id) {
        var money = window.prompt('请输入你要充值的订单数');
        if(money) {
            $.ajax({
                'url': "{{route('staff.agent.charge.order')}}",
                'type': 'POST',
                data: {id: id, price: money},
                'dataType': 'json',
                success: function(data) {
                    if(data.status) {
                        window.location.reload();
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    }
    </script>

@endsection