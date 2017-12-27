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
                        <li>订单管理</li>
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
            {{--<div class="block-options pull-right">--}}
                {{--<a href="{{route('staff.order.add')}}" class="btn btn-effect-ripple btn-primary">添加</a>--}}
            {{--</div>--}}

            <div class="block-options">
                <form method="get" action="{{route('staff.order.lists')}}" class="form-inline">
                    <input type="text" value="{{empty($_GET['receiver_name']) ? '' : $_GET['receiver_name'] }}" class="form-control" name="receiver_name" placeholder="收货人"/>
                    <input type="text" value="{{empty($_GET['receiver_mobile']) ? '' : $_GET['receiver_mobile'] }}" class="form-control" name="receiver_mobile" placeholder="手机号"/>
                    <select name="status" class="form-control">
                        <option value=''>选择状态</option>
                        <option value='{{\App\Models\AgentOrderForm::STATUS_NOT_PAY}}' @if(isset($_GET['status']) && $_GET['status'] ==\App\Models\AgentOrderForm::STATUS_NOT_PAY ) selected @endif>未付款</option>
                        <option value='{{\App\Models\AgentOrderForm::STATUS_WATI_CHECK}}'  @if(!empty($_GET['status']) && $_GET['status'] ==\App\Models\AgentOrderForm::STATUS_WATI_CHECK ) selected @endif>待审核</option>
                        <option value='{{\App\Models\AgentOrderForm::STATUS_WAIT_POST}}'  @if(!empty($_GET['status']) && $_GET['status'] ==\App\Models\AgentOrderForm::STATUS_WAIT_POST ) selected @endif>待发货</option>
                        <option value='{{\App\Models\AgentOrderForm::STATUS_FINISHED}}'  @if(!empty($_GET['status']) && $_GET['status'] ==\App\Models\AgentOrderForm::STATUS_FINISHED ) selected @endif>已完成</option>
                    </select>
                    <input type="submit" class="form-control" value="搜索" >
                </form>
                <div class="block-options pull-right">
                    <a class="btn btn-effect-ripple btn-primary" href="{{route('staff.order.export', $_GET)}}" target="_blank">导出</a>

                </div>
                 <div class="block-options pull-right">
                                    <form method="POST" enctype="multipart/form-data" id="excel_form" class="form-inline">
                                        <input type="file" name="file" id="file" value=""  style="display:none;"/>
                                        <a class="btn btn-effect-ripple btn-success" href="javascript:;" onclick="triggerFile()" target="_blank">导入</a>
                                    </form>
                                </div>
            </div>
            <h2><span >商品列表</span></h2>
        </div>
        <!-- Table Styles Content -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-vcenter">
                <thead>
                <tr>
                    <th class="hidden-sm hidden-xs">订单编号</th>
                    <th class="">商品信息</th>
                    <th class="hidden-sm hidden-xs">收货人</th>
                    <th class="hidden-sm hidden-xs">收货人手机</th>
                    <th class="hidden-sm hidden-xs">收货人地址</th>
                    <th class="hidden-sm hidden-xs">下单人</th>
                    <th class="hidden-sm hidden-xs">快递公司</th>
                    <th class="hidden-sm hidden-xs">快递单号</th>
                    <th class="hidden-sm hidden-xs">订单状态</th>
                    <th style="width: 120px;" class="text-center">
                        <i class="fa fa-flash"></i>
                    </th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                @foreach($data as $goods)
                    <tr>
                        <td class="hidden-sm hidden-xs">
                            <a href="javascript:void(0)"
                               class="label label-warning">{{$goods->order_code}}</a></td>
                        <td>
                            @if(!empty($goods->orders))
                                @foreach($goods->orders as $g)
                                    {{$g->goods_name}}x{{$g->goods_amount}}<br />
                                @endforeach
                            @endif
                        </td>
                        <td class="hidden-sm hidden-xs">{{$goods->receiver_name}}</td>
                        <td class="hidden-sm hidden-xs">{{$goods->receiver_mobile}}</td>
                        <td class="hidden-sm hidden-xs">{{$goods->receiver_addr}}</td>
                        <td class="hidden-sm hidden-xs">{{empty($goods->submiter) ? '' : $goods->submiter->username}}</td>
                        <td class="hidden-sm hidden-xs">{{$goods->post_company}}</td>
                        <td class="hidden-sm hidden-xs">{{$goods->post_code}}</td>
                        <td class="hidden-sm hidden-xs">
                                @if($goods->status == \App\Models\AgentOrderForm::STATUS_NOT_PAY)
                                    未支付
                                                    @elseif($goods->status == \App\Models\AgentOrderForm::STATUS_WATI_CHECK)
                                                       待审核
                                                    @elseif($goods->status == \App\Models\AgentOrderForm::STATUS_WAIT_POST)
                                                       待发货
                                                       @elseif($goods->status == \App\Models\AgentOrderForm::STATUS_FINISHED)
                                                       已完成
                                                       @else
                                                       已取消
                                                       @endif

                        </td>

                        <td class="text-center">
                            @if($goods->status == \App\Models\AgentOrderForm::STATUS_NOT_PAY)
                            <a href="javascript:;" data-href="{{route('staff.order.cancel', ['id'=>$goods->id])}}" data-toggle="tooltip" title="取消"
                                   class="btn btn-effect-ripple btn-xs btn-success cancel-order"><i class="fa fa-pencil"></i>取消</a>

                                   <a href="javascript:;" data-href="{{route('staff.order.payed', ['id'=>$goods->id])}}" data-toggle="tooltip" title="已支付"
                                                                      class="btn btn-effect-ripple btn-xs btn-success payed-order"><i class="fa fa-pencil"></i>已支付</a>
                            @elseif($goods->status == \App\Models\AgentOrderForm::STATUS_WATI_CHECK)
                                <a href="javascript:;" data-href="{{route('staff.order.check', ['id'=>$goods->id])}}" data-toggle="tooltip" title="过审"
                                   class="btn btn-effect-ripple btn-xs btn-success check-order"><i class="fa fa-pencil"></i>过审</a>
                                <a href="javascript:;" data-href="{{route('staff.order.notpay', ['id'=>$goods->id])}}" data-toggle="tooltip" title="未支付"
                                   class="btn btn-effect-ripple btn-xs btn-success notpay-order"><i class="fa fa-pencil"></i>未支付</a>
                            @elseif($goods->status == \App\Models\AgentOrderForm::STATUS_WAIT_POST)
                                <a href="{{route('staff.order.post', ['id'=>$goods->id])}}" data-toggle="tooltip" title="发货"
                                   class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i>发货</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @endif
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

        $('.check-order').on('click', function () {
            if(confirm('你确定要通过审核吗')) {
                location.href = $(this).data('href');
            }
        });

 $('.payed-order').on('click', function () {
            if(confirm('你确定已支付了吗')) {
                location.href = $(this).data('href');
            }
        });

 $('.notpay-order').on('click', function () {
            if(confirm('你确定未支付吗')) {
                location.href = $(this).data('href');
            }
        });

 $('.cancel-order').on('click', function () {
            if(confirm('你确定要删除订单吗')) {
                location.href = $(this).data('href');
            }
        });

 $('.check-order').on('click', function () {
            if(confirm('你确定要通过审核吗')) {
                location.href = $(this).data('href');
            }



        });


  $('#file').on('change', function() {
            console.log('in');
            var value = $(this).val();
                        if($.trim(value) != '') {
                            var formData = new FormData($('#excel_form')[0]);
                                            $.ajax({
                                                url: "{{route('staff.order.import')}}",
                                                 type: 'POST',
                                                  data: formData,
                                                  async: false,
                                                  cache: false,
                                                  dataType: 'json',
                                                  contentType: false,
                                                  processData: false,
                                                success:function(data) {

                                                    alert('导入成功');
                                                    window.location.reload();
                                                },
                                                error: function(e) {
                                                    console.log(e);
                                                }
                                            });
                        }

            });
        function triggerFile() {
            $('#file').val('');
            $('#file').trigger('click');
        }


    </script>

@endsection